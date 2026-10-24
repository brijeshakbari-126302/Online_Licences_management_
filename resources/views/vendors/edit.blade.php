@extends('layouts.app')

@section('title', 'Edit Vendor: ' . $vendor->name)

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Edit Software Vendor</h1>
        <p class="page-subtitle">Update vendor contact information, support links, or partnership terms.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-secondary">
            &larr; View Vendor
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Update {{ $vendor->name }}</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('vendors.update', $vendor) }}" method="POST" novalidate id="vendor-edit-form">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Vendor / Publisher Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $vendor->name) }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Corporate Website URL</label>
                    <input type="url" name="website" class="form-input @error('website') is-invalid @enderror" value="{{ old('website', $vendor->website) }}">
                    @error('website') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Primary Account Contact</label>
                    <input type="text" name="contact_name" class="form-input @error('contact_name') is-invalid @enderror" value="{{ old('contact_name', $vendor->contact_name) }}">
                    @error('contact_name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-input @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $vendor->contact_email) }}">
                    @error('contact_email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-input @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $vendor->contact_phone) }}">
                    @error('contact_phone') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Help Desk / Support Portal URL</label>
                <input type="url" name="support_url" class="form-input @error('support_url') is-invalid @enderror" value="{{ old('support_url', $vendor->support_url) }}">
                @error('support_url') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Vendor Partnership Notes & Terms</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror">{{ old('notes', $vendor->notes) }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this vendor? All associated software licenses will also be deleted.')) { document.getElementById('delete-vendor-form').submit(); }">
                        Delete Vendor
                    </button>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Vendor</button>
                </div>
            </div>
        </form>

        <form id="delete-vendor-form" action="{{ route('vendors.destroy', $vendor) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
