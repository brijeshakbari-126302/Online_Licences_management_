<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    /**
     * Display a listing of licenses requiring renewal or attention.
     */
    public function index(Request $request): View
    {
        $query = License::with(['vendor', 'activeAssignments']);

        $timeframe = $request->input('timeframe', 'all_expiring');

        if ($timeframe === 'expired') {
            $query->where(function ($q) {
                $q->where('status', 'expired')
                    ->orWhere(function ($sq) {
                        $sq->whereNotNull('expiration_date')->where('expiration_date', '<', now());
                    });
            });
        } elseif ($timeframe === '30_days') {
            $query->whereNotNull('expiration_date')
                ->whereBetween('expiration_date', [now(), now()->addDays(30)]);
        } elseif ($timeframe === '60_days') {
            $query->whereNotNull('expiration_date')
                ->whereBetween('expiration_date', [now(), now()->addDays(60)]);
        } elseif ($timeframe === '90_days') {
            $query->whereNotNull('expiration_date')
                ->whereBetween('expiration_date', [now(), now()->addDays(90)]);
        } else {
            // all_expiring: Expired or expiring within 90 days
            $query->where(function ($q) {
                $q->where('status', 'expired')
                    ->orWhere(function ($sq) {
                        $sq->whereNotNull('expiration_date')->where('expiration_date', '<=', now()->addDays(90));
                    });
            });
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->input('vendor_id'));
        }

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('software_name', 'like', $term)
                    ->orWhere('license_key', 'like', $term)
                    ->orWhereHas('vendor', function ($vq) use ($term) {
                        $vq->where('name', 'like', $term);
                    });
            });
        }

        $licenses = $query->orderBy('expiration_date')->paginate(10)->withQueryString();

        // Metrics for summary cards
        $totalExpired = License::where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('expiration_date')->where('expiration_date', '<', now());
            })->count();

        $expiringNext30 = License::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [now(), now()->addDays(30)])
            ->count();

        $renewalCostEstimate = License::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [now(), now()->addDays(60)])
            ->get()
            ->sum(function (License $lic) {
                return (float) $lic->total_cost;
            });

        $vendors = Vendor::orderBy('name')->get();

        return view('renewals.index', [
            'licenses' => $licenses,
            'vendors' => $vendors,
            'timeframe' => $timeframe,
            'selectedVendor' => $request->input('vendor_id'),
            'searchTerm' => $request->input('search'),
            'totalExpired' => $totalExpired,
            'expiringNext30' => $expiringNext30,
            'renewalCostEstimate' => $renewalCostEstimate,
        ]);
    }

    /**
     * Quickly extend / renew a license.
     */
    public function extend(Request $request, License $license): RedirectResponse
    {
        $validated = $request->validate([
            'extension_type' => ['required', 'string', 'in:1_year,6_months,1_month,custom'],
            'custom_date' => ['nullable', 'required_if:extension_type,custom', 'date', 'after:today'],
            'cost_per_seat' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $currentExpiry = $license->expiration_date && $license->expiration_date->isFuture()
            ? $license->expiration_date->copy()
            : Carbon::now();

        $newExpiry = match ($validated['extension_type']) {
            '1_year' => $currentExpiry->addYear(),
            '6_months' => $currentExpiry->addMonths(6),
            '1_month' => $currentExpiry->addMonth(),
            'custom' => Carbon::parse($validated['custom_date']),
        };

        $renewalNote = '['.now()->format('Y-m-d').'] License renewed and extended to '.$newExpiry->format('M d, Y');
        if (! empty($validated['notes'])) {
            $renewalNote .= '. Note: '.$validated['notes'];
        }

        $existingNotes = $license->notes ? $license->notes."\n" : '';

        $updateData = [
            'expiration_date' => $newExpiry->toDateString(),
            'status' => 'active',
            'notes' => $existingNotes.$renewalNote,
        ];

        if (isset($validated['cost_per_seat']) && $validated['cost_per_seat'] !== null) {
            $updateData['cost_per_seat'] = $validated['cost_per_seat'];
        }

        $license->update($updateData);

        return redirect()->back()
            ->with('success', "License '{$license->software_name}' successfully renewed until {$newExpiry->format('M d, Y')}!");
    }
}
