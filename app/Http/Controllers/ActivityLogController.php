<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ActivityLogController extends Controller
{
    /**
     * Display the audit trail and activity log.
     */
    public function index(Request $request): View
    {
        $filter = $request->input('filter', 'all');

        $activities = new Collection;

        // 1. Assignments activities
        if ($filter === 'all' || $filter === 'assignments') {
            $assignments = Assignment::with(['license.vendor', 'employee'])
                ->where('status', 'active')
                ->latest('assigned_date')
                ->take(50)
                ->get();

            foreach ($assignments as $a) {
                $activities->push([
                    'type' => 'assignment_created',
                    'badge' => 'Seat Assigned',
                    'badge_class' => 'badge-active',
                    'icon' => 'user-check',
                    'title' => "Seat assigned to {$a->employee->name}",
                    'description' => "Allocated 1 seat of '{$a->license->software_name}' to {$a->employee->name} ({$a->employee->department}) on workstation '{$a->device_info}'.",
                    'timestamp' => $a->assigned_date ?? $a->created_at,
                    'link' => route('assignments.show', $a),
                    'link_text' => 'View Assignment',
                ]);
            }
        }

        // 2. Revocations
        if ($filter === 'all' || $filter === 'revocations') {
            $revoked = Assignment::with(['license.vendor', 'employee'])
                ->where('status', 'revoked')
                ->whereNotNull('revoked_date')
                ->latest('revoked_date')
                ->take(50)
                ->get();

            foreach ($revoked as $r) {
                $activities->push([
                    'type' => 'assignment_revoked',
                    'badge' => 'Seat Revoked',
                    'badge_class' => 'badge-neutral',
                    'icon' => 'user-minus',
                    'title' => "Seat returned by {$r->employee->name}",
                    'description' => "Revoked access for '{$r->license->software_name}'. Seat returned to the available inventory pool.",
                    'timestamp' => $r->revoked_date ?? $r->updated_at,
                    'link' => route('assignments.show', $r),
                    'link_text' => 'View Record',
                ]);
            }
        }

        // 3. New Licenses Registered
        if ($filter === 'all' || $filter === 'licenses') {
            $licenses = License::with('vendor')
                ->latest('created_at')
                ->take(30)
                ->get();

            foreach ($licenses as $l) {
                $activities->push([
                    'type' => 'license_created',
                    'badge' => 'License Added',
                    'badge_class' => 'badge-primary',
                    'icon' => 'shield',
                    'title' => "New software license: {$l->software_name}",
                    'description' => "Registered {$l->total_seats} seats from publisher '{$l->vendor->name}' under category {$l->category}.",
                    'timestamp' => $l->purchase_date ?? $l->created_at,
                    'link' => route('licenses.show', $l),
                    'link_text' => 'View License',
                ]);
            }
        }

        // 4. Vendor Additions
        if ($filter === 'all' || $filter === 'vendors') {
            $vendors = Vendor::latest('created_at')
                ->take(20)
                ->get();

            foreach ($vendors as $v) {
                $activities->push([
                    'type' => 'vendor_created',
                    'badge' => 'Vendor Partner',
                    'badge_class' => 'badge-info',
                    'icon' => 'building',
                    'title' => "Software vendor onboarded: {$v->name}",
                    'description' => "Added corporate publisher profile for {$v->name}. Contact: {$v->contact_name} ({$v->contact_email}).",
                    'timestamp' => $v->created_at,
                    'link' => route('vendors.show', $v),
                    'link_text' => 'View Vendor',
                ]);
            }
        }

        // Sort all by timestamp descending
        $sorted = $activities->sortByDesc(function ($item) {
            return $item['timestamp'];
        })->values();

        // Paginate manually
        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginated = new LengthAwarePaginator(
            $currentItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('activity.index', [
            'activities' => $paginated,
            'currentFilter' => $filter,
            'totalActivitiesCount' => $sorted->count(),
        ]);
    }
}
