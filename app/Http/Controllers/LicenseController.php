<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the licenses.
     */
    public function index(Request $request): View
    {
        $query = License::with(['vendor', 'activeAssignments']);

        if ($request->filled('search')) {
            $searchTerm = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('software_name', 'like', $searchTerm)
                    ->orWhere('license_key', 'like', $searchTerm)
                    ->orWhereHas('vendor', function ($vq) use ($searchTerm) {
                        $vq->where('name', 'like', $searchTerm);
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->input('vendor_id'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $licenses = $query->latest()->paginate(10)->withQueryString();
        $vendors = Vendor::orderBy('name')->get();
        $categories = License::select('category')->whereNotNull('category')->distinct()->pluck('category');

        return view('licenses.index', [
            'licenses' => $licenses,
            'vendors' => $vendors,
            'categories' => $categories,
            'selectedStatus' => $request->input('status'),
            'selectedVendor' => $request->input('vendor_id'),
            'selectedCategory' => $request->input('category'),
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new license.
     */
    public function create(): View
    {
        $vendors = Vendor::orderBy('name')->get();

        return view('licenses.create', [
            'vendors' => $vendors,
        ]);
    }

    /**
     * Store a newly created license in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'software_name' => ['required', 'string', 'max:255'],
            'license_key' => ['nullable', 'string', 'max:255'],
            'license_type' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'total_seats' => ['required', 'integer', 'min:1'],
            'cost_per_seat' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'billing_cycle' => ['required', 'string', 'in:monthly,annually,quarterly,one-time'],
            'purchase_date' => ['required', 'date'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'status' => ['required', 'string', 'in:active,expiring_soon,expired,suspended'],
            'notes' => ['nullable', 'string'],
        ]);

        $license = License::create($validated);

        return redirect()->route('licenses.show', $license)
            ->with('success', 'Software license added successfully.');
    }

    /**
     * Display the specified license.
     */
    public function show(License $license): View
    {
        $license->load(['vendor', 'assignments.employee']);

        return view('licenses.show', [
            'license' => $license,
        ]);
    }

    /**
     * Show the form for editing the specified license.
     */
    public function edit(License $license): View
    {
        $vendors = Vendor::orderBy('name')->get();

        return view('licenses.edit', [
            'license' => $license,
            'vendors' => $vendors,
        ]);
    }

    /**
     * Update the specified license in storage.
     */
    public function update(Request $request, License $license): RedirectResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'software_name' => ['required', 'string', 'max:255'],
            'license_key' => ['nullable', 'string', 'max:255'],
            'license_type' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'total_seats' => ['required', 'integer', 'min:1'],
            'cost_per_seat' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'billing_cycle' => ['required', 'string', 'in:monthly,annually,quarterly,one-time'],
            'purchase_date' => ['required', 'date'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'status' => ['required', 'string', 'in:active,expiring_soon,expired,suspended'],
            'notes' => ['nullable', 'string'],
        ]);

        $license->update($validated);

        return redirect()->route('licenses.show', $license)
            ->with('success', 'Software license updated successfully.');
    }

    /**
     * Remove the specified license from storage.
     */
    public function destroy(License $license): RedirectResponse
    {
        $softwareName = $license->software_name;
        $license->delete();

        return redirect()->route('licenses.index')
            ->with('success', "License '{$softwareName}' was deleted successfully.");
    }
}
