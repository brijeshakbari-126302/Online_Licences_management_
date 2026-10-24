<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Account / Sign In - LicenseHub Pro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-wrapper">
    <div class="auth-card" style="max-width: 480px;">
        <div class="auth-header">
            <a href="{{ route('home') }}" class="brand-link" style="justify-content: center;">
                <div class="brand-logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <span>License<span style="color: var(--primary);">Hub</span></span>
                <span class="brand-badge">PRO</span>
            </a>
            <h1>Create Your Account</h1>
            <p>Start managing your team's software licenses in minutes</p>
        </div>

        <!-- Flash alerts -->
        @if (session('error'))
            <div class="alert alert-danger" style="margin-bottom: 1.25rem; padding: 0.75rem 1rem;">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" novalidate id="register-form">
            @csrf

            <!-- Full Name -->
            <div class="form-group">
                <label class="form-label" for="register-name">Full Name <span class="required">*</span></label>
                <input type="text" id="register-name" name="name" class="form-input @error('name') is-invalid @enderror" placeholder="Alex Morgan" value="{{ old('name') }}" required autofocus>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="register-email">Corporate Work Email <span class="required">*</span></label>
                <input type="email" id="register-email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="alex.morgan@company.com" value="{{ old('email') }}" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="register-password">Password <span class="required">*</span></label>
                <input type="password" id="register-password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="At least 8 characters" required>
                @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label" for="register-password-confirmation">Confirm Password <span class="required">*</span></label>
                <input type="password" id="register-password-confirmation" name="password_confirmation" class="form-input" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem; margin-top: 0.5rem;">
                Create Account & Sign In &rarr;
            </button>
        </form>

        <div class="auth-divider">
            <span>or</span>
        </div>

        <div style="text-align: center; font-size: 0.88rem; color: var(--text-muted);">
            Already have an account?
            <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">Log In here</a>
        </div>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}" style="color: var(--text-dim); font-size: 0.82rem;">
                &larr; Back to Homepage
            </a>
        </div>
    </div>

    <!-- jQuery & Form Validation -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/form-validation.js') }}"></script>
</body>
</html>
