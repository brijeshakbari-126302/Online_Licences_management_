<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the executive dashboard with key metrics and activity.
     */
    public function index(): View
    {
        $totalLicenses = License::count();
        $totalVendors = Vendor::count();
        $totalEmployees = Employee::where('status', 'active')->count();

        $licenses = License::with(['vendor', 'activeAssignments'])->get();

        $totalSeats = $licenses->sum('total_seats');
        $totalAssignedSeats = Assignment::where('status', 'active')->count();
        $totalAvailableSeats = max(0, $totalSeats - $totalAssignedSeats);

        $totalAnnualSpend = $licenses->reduce(function (float $carry, License $license): float {
            $cost = (float) ($license->total_seats * $license->cost_per_seat);
            if ($license->billing_cycle === 'monthly') {
                $cost *= 12;
            }

            return $carry + $cost;
        }, 0.0);

        $now = Carbon::now();
        $thirtyDaysFromNow = Carbon::now()->addDays(30);

        $expiringLicenses = License::with('vendor')
            ->whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [$now->toDateString(), $thirtyDaysFromNow->toDateString()])
            ->orderBy('expiration_date', 'asc')
            ->get();

        $expiredLicenses = License::with('vendor')
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', $now->toDateString())
            ->orderBy('expiration_date', 'desc')
            ->get();

        $recentAssignments = Assignment::with(['license.vendor', 'employee'])
            ->latest()
            ->take(6)
            ->get();

        $categoryStats = License::selectRaw('category, COUNT(*) as count, SUM(total_seats) as total_seats')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get();

        return view('dashboard', [
            'totalLicenses' => $totalLicenses,
            'totalVendors' => $totalVendors,
            'totalEmployees' => $totalEmployees,
            'totalSeats' => $totalSeats,
            'totalAssignedSeats' => $totalAssignedSeats,
            'totalAvailableSeats' => $totalAvailableSeats,
            'totalAnnualSpend' => $totalAnnualSpend,
            'expiringLicenses' => $expiringLicenses,
            'expiredLicenses' => $expiredLicenses,
            'recentAssignments' => $recentAssignments,
            'categoryStats' => $categoryStats,
        ]);
    }
}
