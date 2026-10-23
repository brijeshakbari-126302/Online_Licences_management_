@extends('layouts.app')

@section('title', 'Add Software License')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Add Software License</h1>
        <p class="page-subtitle">Register a newly purchased license or subscription into the corporate inventory.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('licenses.index') }}" class="btn btn-secondary">
            &larr; Back to Licenses
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 900px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
            <span>License Details</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('licenses.store') }}" method="POST">
            @csrf

            <!-- Vendor and Application Name -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Vendor / Publisher <span class="required">*</span></label>
                    <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                        <option value="">Select a vendor...</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vendor_id') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Vendor not listed? <a href="{{ route('vendors.create') }}" target="_blank">Add new vendor &rarr;</a></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Software Application Name <span class="required">*</span></label>
                    <input type="text" name="software_name" class="form-input @error('software_name') is-invalid @enderror" placeholder="e.g. JetBrains All Products Pack" value="{{ old('software_name') }}" required>
                    @error('software_name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- License Key and Category -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">License Key / Serial / Contract ID</label>
                    <input type="text" name="license_key" class="form-input @error('license_key') is-invalid @enderror" placeholder="e.g. XXXX-XXXX-XXXX-XXXX" value="{{ old('license_key') }}" style="font-family: var(--font-mono);">
                    @error('license_key') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Leave blank if auto-provisioned via SSO / cloud login.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" list="category-suggestions" class="form-input @error('category') is-invalid @enderror" placeholder="e.g. Development, Design, Productivity" value="{{ old('category', 'Development') }}">
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
                        <option value="Subscription" {{ old('license_type') === 'Subscription' ? 'selected' : '' }}>Subscription (SaaS)</option>
                        <option value="Per Seat" {{ old('license_type') === 'Per Seat' ? 'selected' : '' }}>Per Seat / Named User</option>
                        <option value="Enterprise" {{ old('license_type') === 'Enterprise' ? 'selected' : '' }}>Enterprise Agreement</option>
                        <option value="Perpetual" {{ old('license_type') === 'Perpetual' ? 'selected' : '' }}>Perpetual / Standalone</option>
                        <option value="Trial" {{ old('license_type') === 'Trial' ? 'selected' : '' }}>Evaluation / Trial</option>
                    </select>
                    @error('license_type') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Total Purchased Seats <span class="required">*</span></label>
                    <input type="number" name="total_seats" class="form-input @error('total_seats') is-invalid @enderror" min="1" step="1" value="{{ old('total_seats', 1) }}" required>
                    @error('total_seats') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Number of staff seats licensed under this agreement.</div>
                </div>
            </div>

            <!-- Pricing and Billing Details -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Cost Per Seat</label>
                    <input type="number" name="cost_per_seat" class="form-input @error('cost_per_seat') is-invalid @enderror" min="0" step="0.01" placeholder="0.00" value="{{ old('cost_per_seat', '0.00') }}">
                    @error('cost_per_seat') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Currency <span class="required">*</span></label>
                    <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                        <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="CAD" {{ old('currency') === 'CAD' ? 'selected' : '' }}>CAD ($)</option>
                        <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                    </select>
                    @error('currency') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Billing Cycle <span class="required">*</span></label>
                    <select name="billing_cycle" class="form-select @error('billing_cycle') is-invalid @enderror" required>
                        <option value="annually" {{ old('billing_cycle', 'annually') === 'annually' ? 'selected' : '' }}>Annually</option>
                        <option value="monthly" {{ old('billing_cycle') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ old('billing_cycle') === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="one-time" {{ old('billing_cycle') === 'one-time' ? 'selected' : '' }}>One-Time / Perpetual</option>
                    </select>
                    @error('billing_cycle') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Dates and Status -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Purchase Date <span class="required">*</span></label>
                    <input type="date" name="purchase_date" class="form-input @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                    @error('purchase_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Expiration / Renewal Date</label>
                    <input type="date" name="expiration_date" class="form-input @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date') }}">
                    @error('expiration_date') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Leave blank for non-expiring perpetual licenses.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expiring_soon" {{ old('status') === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="expired" {{ old('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">Contract Notes & Provisions</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror" placeholder="Terms, account manager notes, tier limits, or special conditions...">{{ old('notes') }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('licenses.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Software License</button>
            </div>
        </form>
    </div>
</div>
@endsection
