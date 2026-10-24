<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Log In - LicenseHub Pro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-wrapper">
    <div class="auth-card">
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
            <h1>Sign In to Dashboard</h1>
            <p>Access your organization's software license inventory</p>
        </div>

        <!-- Demo Credentials Callout -->
        <div class="demo-credentials-callout">
            <div class="demo-credentials-text">
                <div><strong>Demo Admin Account:</strong></div>
                <div>admin@licensehub.pro &bull; password</div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="fillDemoCredentials()" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">
                Auto-fill
            </button>
        </div>

        <!-- Flash alerts -->
        @if (session('error'))
            <div class="alert alert-danger" style="margin-bottom: 1.25rem; padding: 0.75rem 1rem;">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" novalidate id="login-form">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="login-email">Corporate Work Email <span class="required">*</span></label>
                <input type="email" id="login-email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="admin@licensehub.pro" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                    <label class="form-label" for="login-password" style="margin-bottom: 0;">Password <span class="required">*</span></label>
                </div>
                <input type="password" id="login-password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Remember Me -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; font-size: 0.86rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--text-muted);">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember my session</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                Log In to Dashboard &rarr;
            </button>
        </form>

        <div class="auth-divider">
            <span>or</span>
        </div>

        <div style="text-align: center; font-size: 0.88rem; color: var(--text-muted);">
            Need an account?
            <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Sign In / Register here</a>
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

    <script>
        function fillDemoCredentials() {
            $('#login-email').val('admin@licensehub.pro').removeClass('is-invalid').trigger('input');
            $('#login-password').val('password').removeClass('is-invalid').trigger('input');
            $('.jquery-validation-error').remove();
        }
    </script>
</body>
</html>
