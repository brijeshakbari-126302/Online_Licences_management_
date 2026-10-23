<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors.
     */
    public function index(Request $request): View
    {
        $query = Vendor::withCount('licenses');

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('contact_name', 'like', $term)
                    ->orWhere('contact_email', 'like', $term);
            });
        }

        $vendors = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('vendors.index', [
            'vendors' => $vendors,
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new vendor.
     */
    public function create(): View
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'support_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $vendor = Vendor::create($validated);

        return redirect()->route('vendors.show', $vendor)
            ->with('success', "Vendor '{$vendor->name}' created successfully.");
    }

    /**
     * Display the specified vendor.
     */
    public function show(Vendor $vendor): View
    {
        $vendor->load(['licenses.activeAssignments']);

        return view('vendors.show', [
            'vendor' => $vendor,
        ]);
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit(Vendor $vendor): View
    {
        return view('vendors.edit', [
            'vendor' => $vendor,
        ]);
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'support_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $vendor->update($validated);

        return redirect()->route('vendors.show', $vendor)
            ->with('success', "Vendor '{$vendor->name}' updated successfully.");
    }

    /**
     * Remove the specified vendor from storage.
     */
    public function destroy(Vendor $vendor): RedirectResponse
    {
        $name = $vendor->name;
        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', "Vendor '{$name}' deleted successfully.");
    }
}
