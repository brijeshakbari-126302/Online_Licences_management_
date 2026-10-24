<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\License;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public homepage with platform overview and live metrics.
     */
    public function index(): View
    {
        $totalLicenses = License::count();
        $totalVendors = Vendor::count();
        $licenses = License::all();
        $totalSeats = (int) $licenses->sum('total_seats');
        $assignedSeats = Assignment::where('status', 'active')->count();
        $utilizationRate = $totalSeats > 0 ? (int) round(($assignedSeats / $totalSeats) * 100) : 0;

        $annualSpend = $licenses->reduce(function (float $carry, License $license): float {
            $cost = (float) ($license->total_seats * $license->cost_per_seat);
            if ($license->billing_cycle === 'monthly') {
                $cost *= 12;
            }

            return $carry + $cost;
        }, 0.0);

        return view('home', compact(
            'totalLicenses',
            'totalVendors',
            'assignedSeats',
            'totalSeats',
            'utilizationRate',
            'annualSpend'
        ));
    }

    /**
     * Display the public About Us page.
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Display the public Contact & Support page.
     */
    public function contact(): View
    {
        return view('contact');
    }

    /**
     * Handle incoming contact inquiries.
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        return redirect()
            ->route('contact')
            ->with('success', "Thank you, {$validated['name']}! Your message regarding '{$validated['subject']}' has been received. Our support team will respond to {$validated['email']} within 2 business hours.");
    }
}
