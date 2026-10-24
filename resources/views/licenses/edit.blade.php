@extends('layouts.app')

@section('title', 'Edit License: ' . $license->software_name)

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Edit Software License</h1>
        <p class="page-subtitle">Update licensing agreement terms, seat allotments, pricing, or renewal date.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('licenses.show', $license) }}" class="btn btn-secondary">
            &larr; View Details
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 900px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Update {{ $license->software_name }}</span>
        </div>
        <div>
            @if ($license->status === 'active')
                <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
            @elseif ($license->status === 'expiring_soon')
                <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring Soon</span>
            @elseif ($license->status === 'expired')
                <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
            @else
                <span class="badge badge-neutral"><span class="badge-dot"></span> {{ ucfirst($license->status) }}</span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('licenses.update', $license) }}" method="POST" novalidate id="license-edit-form">
            @csrf
            @method('PUT')

            <!-- Vendor and Application Name -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Vendor / Publisher <span class="required">*</span></label>
                    <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $license->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vendor_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Software Application Name <span class="required">*</span></label>
                    <input type="text" name="software_name" class="form-input @error('software_name') is-invalid @enderror" value="{{ old('software_name', $license->software_name) }}" required>
                    @error('software_name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- License Key and Category -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">License Key / Serial / Contract ID</label>
                    <input type="text" name="license_key" class="form-input @error('license_key') is-invalid @enderror" value="{{ old('license_key', $license->license_key) }}" style="font-family: var(--font-mono);">
                    @error('license_key') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" list="category-suggestions" class="form-input @error('category') is-invalid @enderror" value="{{ old('category', $license->category) }}">
                    <datalist id="category-suggestions">
                        <option value="Development">
                        <option value="Design">
                        <option value="Productivity">
                        <option value="DevOps & IT">
                        <option value="Security">
                        <option value="Finance & Accounting">
                        <option value="Communication">
                    </datalist>
                    @error('category') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- License Type and Seat Count -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">License Type <span class="required">*</span></label>
                    <select name="license_type" class="form-select @error('license_type') is-invalid @enderror" required>
                        <option value="Subscription" {{ old('license_type', $license->license_type) === 'Subscription' ? 'selected' : '' }}>Subscription (SaaS)</option>
                        <option value="Per Seat" {{ old('license_type', $license->license_type) === 'Per Seat' ? 'selected' : '' }}>Per Seat / Named User</option>
                        <option value="Enterprise" {{ old('license_type', $license->license_type) === 'Enterprise' ? 'selected' : '' }}>Enterprise Agreement</option>
                        <option value="Perpetual" {{ old('license_type', $license->license_type) === 'Perpetual' ? 'selected' : '' }}>Perpetual / Standalone</option>
                        <option value="Trial" {{ old('license_type', $license->license_type) === 'Trial' ? 'selected' : '' }}>Evaluation / Trial</option>
                    </select>
                    @error('license_type') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Total Purchased Seats <span class="required">*</span></label>
                    <input type="number" name="total_seats" class="form-input @error('total_seats') is-invalid @enderror" min="{{ $license->activeAssignments->count() }}" step="1" value="{{ old('total_seats', $license->total_seats) }}" required>
                    @error('total_seats') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Currently {{ $license->activeAssignments->count() }} seats are actively deployed to employees.</div>
                </div>
            </div>

            <!-- Pricing and Billing Details -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Cost Per Seat</label>
                    <input type="number" name="cost_per_seat" class="form-input @error('cost_per_seat') is-invalid @enderror" min="0" step="0.01" value="{{ old('cost_per_seat', $license->cost_per_seat) }}">
                    @error('cost_per_seat') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Currency <span class="required">*</span></label>
                    <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                        <option value="USD" {{ old('currency', $license->currency) === 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency', $license->currency) === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ old('currency', $license->currency) === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="CAD" {{ old('currency', $license->currency) === 'CAD' ? 'selected' : '' }}>CAD ($)</option>
                        <option value="INR" {{ old('currency', $license->currency) === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                    </select>
                    @error('currency') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Billing Cycle <span class="required">*</span></label>
                    <select name="billing_cycle" class="form-select @error('billing_cycle') is-invalid @enderror" required>
                        <option value="annually" {{ old('billing_cycle', $license->billing_cycle) === 'annually' ? 'selected' : '' }}>Annually</option>
                        <option value="monthly" {{ old('billing_cycle', $license->billing_cycle) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ old('billing_cycle', $license->billing_cycle) === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="one-time" {{ old('billing_cycle', $license->billing_cycle) === 'one-time' ? 'selected' : '' }}>One-Time / Perpetual</option>
                    </select>
                    @error('billing_cycle') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Dates and Status -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Purchase Date <span class="required">*</span></label>
                    <input type="date" name="purchase_date" class="form-input @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', $license->purchase_date ? $license->purchase_date->format('Y-m-d') : '') }}" required>
                    @error('purchase_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Expiration / Renewal Date</label>
                    <input type="date" name="expiration_date" class="form-input @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', $license->expiration_date ? $license->expiration_date->format('Y-m-d') : '') }}">
                    @error('expiration_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $license->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expiring_soon" {{ old('status', $license->status) === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="expired" {{ old('status', $license->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="suspended" {{ old('status', $license->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">Contract Notes & Provisions</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror">{{ old('notes', $license->notes) }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Submit and Actions -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this software license? All its seat assignment history will be removed.')) { document.getElementById('delete-license-form').submit(); }">
                        Delete License
                    </button>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('licenses.show', $license) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Software License</button>
                </div>
            </div>
        </form>

        <form id="delete-license-form" action="{{ route('licenses.destroy', $license) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
