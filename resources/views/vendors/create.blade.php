@extends('layouts.app')

@section('title', 'Add Software Vendor')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Add Software Vendor</h1>
        <p class="page-subtitle">Register a software company, reseller, or SaaS publisher.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">
            &larr; Back to Vendors
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Vendor Company Details</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('vendors.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Vendor / Publisher Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" placeholder="e.g. JetBrains, Microsoft, Adobe" value="{{ old('name') }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Corporate Website URL</label>
                    <input type="url" name="website" class="form-input @error('website') is-invalid @enderror" placeholder="https://www.vendor.com" value="{{ old('website') }}">
                    @error('website') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Primary Account Contact</label>
                    <input type="text" name="contact_name" class="form-input @error('contact_name') is-invalid @enderror" placeholder="Account Manager name" value="{{ old('contact_name') }}">
                    @error('contact_name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-input @error('contact_email') is-invalid @enderror" placeholder="sales@vendor.com" value="{{ old('contact_email') }}">
                    @error('contact_email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-input @error('contact_phone') is-invalid @enderror" placeholder="+1 (555) 000-0000" value="{{ old('contact_phone') }}">
                    @error('contact_phone') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Help Desk / Support Portal URL</label>
                <input type="url" name="support_url" class="form-input @error('support_url') is-invalid @enderror" placeholder="https://support.vendor.com or portal login" value="{{ old('support_url') }}">
                @error('support_url') <div class="form-error">{{ $message }}</div> @enderror
                <div class="form-hint">Used by IT staff when raising license activation issues or ticket escalation.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Vendor Partnership Notes & Terms</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror" placeholder="Discount tier, renewal anniversary, contract master agreement number...">{{ old('notes') }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Vendor</button>
            </div>
        </form>
    </div>
</div>
@endsection
