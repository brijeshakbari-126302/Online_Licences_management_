<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the reports and analytics dashboard.
     */
    public function index(Request $request): View
    {
        $licenses = License::with(['vendor', 'activeAssignments.employee'])->get();
        $totalLicenses = $licenses->count();
        $totalSeats = $licenses->sum('total_seats');

        // Total active assignments
        $assignedSeats = Assignment::where('status', 'active')->count();
        $utilizationRate = $totalSeats > 0 ? round(($assignedSeats / $totalSeats) * 100, 1) : 0;
        $unassignedSeats = max(0, $totalSeats - $assignedSeats);

        // Financial calculations
        $annualSpend = $licenses->sum(function (License $license) {
            $cost = (float) $license->total_cost;

            return $license->billing_cycle === 'monthly' ? $cost * 12 : $cost;
        });

        // Shelfware / Wasted spend on unused seats
        $wastedSpend = $licenses->sum(function (License $license) {
            $unusedSeats = max(0, $license->total_seats - $license->activeAssignments->count());
            $annualUnitCost = $license->billing_cycle === 'monthly'
                ? ((float) $license->cost_per_seat * 12)
                : (float) $license->cost_per_seat;

            return $unusedSeats * $annualUnitCost;
        });

        // Category Breakdown
        $categoryBreakdown = License::selectRaw('category, COUNT(*) as count, SUM(total_seats) as seats')
            ->groupBy('category')
            ->orderByDesc('seats')
            ->get();

        // Vendor Breakdown with spend
        $vendorBreakdown = Vendor::with('licenses')->get()->map(function (Vendor $vendor) {
            $spend = $vendor->licenses->sum(function (License $lic) {
                return $lic->billing_cycle === 'monthly' ? $lic->total_cost * 12 : $lic->total_cost;
            });
            $seats = $vendor->licenses->sum('total_seats');

            return [
                'name' => $vendor->name,
                'license_count' => $vendor->licenses->count(),
                'total_seats' => $seats,
                'annual_spend' => $spend,
            ];
        })->sortByDesc('annual_spend')->values();

        // Department Breakdown
        $departmentBreakdown = Employee::where('status', 'active')
            ->withCount(['assignments' => function ($query) {
                $query->where('status', 'active');
            }])
            ->get()
            ->groupBy('department')
            ->map(function ($deptEmployees, $deptName) {
                $staffCount = $deptEmployees->count();
                $seatsCount = $deptEmployees->sum('assignments_count');

                return [
                    'department' => $deptName,
                    'staff_count' => $staffCount,
                    'seats_count' => $seatsCount,
                ];
            })
            ->sortByDesc('seats_count')
            ->values();

        // Expiry timeline counts
        $expiredCount = License::where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('expiration_date')->where('expiration_date', '<', now());
            })->count();

        $expiring30Days = License::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [now(), now()->addDays(30)])
            ->count();

        $expiring90Days = License::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [now()->addDays(30), now()->addDays(90)])
            ->count();

        return view('reports.index', [
            'totalLicenses' => $totalLicenses,
            'totalSeats' => $totalSeats,
            'assignedSeats' => $assignedSeats,
            'unassignedSeats' => $unassignedSeats,
            'utilizationRate' => $utilizationRate,
            'annualSpend' => $annualSpend,
            'wastedSpend' => $wastedSpend,
            'categoryBreakdown' => $categoryBreakdown,
            'vendorBreakdown' => $vendorBreakdown,
            'departmentBreakdown' => $departmentBreakdown,
            'expiredCount' => $expiredCount,
            'expiring30Days' => $expiring30Days,
            'expiring90Days' => $expiring90Days,
        ]);
    }

    /**
     * Export data to CSV.
     */
    public function export(string $type): StreamedResponse
    {
        $filename = "{$type}_export_".now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($type) {
            $handle = fopen('php://output', 'w');

            if ($type === 'licenses') {
                fputcsv($handle, [
                    'ID', 'Software Name', 'Vendor', 'License Key', 'Category',
                    'License Type', 'Total Seats', 'Cost Per Seat', 'Currency',
                    'Billing Cycle', 'Total Cost', 'Status', 'Expiration Date',
                ]);

                License::with('vendor')->chunk(100, function ($licenses) use ($handle) {
                    foreach ($licenses as $l) {
                        fputcsv($handle, [
                            $l->id,
                            $l->software_name,
                            $l->vendor->name ?? 'N/A',
                            $l->license_key ?? 'Auto-provisioned',
                            $l->category ?? 'General',
                            $l->license_type,
                            $l->total_seats,
                            $l->cost_per_seat,
                            $l->currency,
                            $l->billing_cycle,
                            $l->total_cost,
                            $l->status,
                            $l->expiration_date ? $l->expiration_date->format('Y-m-d') : 'Perpetual',
                        ]);
                    }
                });
            } elseif ($type === 'assignments') {
                fputcsv($handle, [
                    'ID', 'Software License', 'Vendor', 'Employee Name',
                    'Employee ID', 'Department', 'Device Info', 'Assigned Date',
                    'Revoked Date', 'Status',
                ]);

                Assignment::with(['license.vendor', 'employee'])->chunk(100, function ($assignments) use ($handle) {
                    foreach ($assignments as $a) {
                        fputcsv($handle, [
                            $a->id,
                            $a->license->software_name ?? 'N/A',
                            $a->license->vendor->name ?? 'N/A',
                            $a->employee->name ?? 'N/A',
                            $a->employee->employee_id ?? 'N/A',
                            $a->employee->department ?? 'N/A',
                            $a->device_info ?? 'Unspecified',
                            $a->assigned_date ? $a->assigned_date->format('Y-m-d') : '',
                            $a->revoked_date ? $a->revoked_date->format('Y-m-d') : '',
                            $a->status,
                        ]);
                    }
                });
            } elseif ($type === 'vendors') {
                fputcsv($handle, [
                    'ID', 'Vendor Name', 'Website', 'Contact Name',
                    'Contact Email', 'Contact Phone', 'Support URL',
                ]);

                Vendor::chunk(100, function ($vendors) use ($handle) {
                    foreach ($vendors as $v) {
                        fputcsv($handle, [
                            $v->id,
                            $v->name,
                            $v->website ?? '',
                            $v->contact_name ?? '',
                            $v->contact_email ?? '',
                            $v->contact_phone ?? '',
                            $v->support_url ?? '',
                        ]);
                    }
                });
            } elseif ($type === 'employees') {
                fputcsv($handle, [
                    'ID', 'Employee ID', 'Name', 'Email',
                    'Department', 'Job Title', 'Phone', 'Status',
                ]);

                Employee::chunk(100, function ($employees) use ($handle) {
                    foreach ($employees as $e) {
                        fputcsv($handle, [
                            $e->id,
                            $e->employee_id,
                            $e->name,
                            $e->email,
                            $e->department,
                            $e->job_title,
                            $e->phone ?? '',
                            $e->status,
                        ]);
                    }
                });
            }

            fclose($handle);
        }, 200, $headers);
    }
}
