/**
 * LicenseHub Pro - Global jQuery Form Validation
 * Completely suppresses browser/bootstrap native tooltips (novalidate)
 * and provides responsive, real-time jQuery validation across all forms.
 */
(function ($) {
    'use strict';

    if (typeof $ === 'undefined') {
        console.warn('LicenseHub Pro: jQuery is required for client-side form validation.');
        return;
    }

    /**
     * Disable browser native balloon/tooltip validation project-wide.
     */
    function disableBrowserValidation() {
        $('form').attr('novalidate', 'novalidate');
        $(document).on('invalid', 'input, select, textarea', function (e) {
            e.preventDefault();
        });
    }

    /**
     * Get a human-readable label for a field.
     */
    function getFieldLabel($field) {
        const id = $field.attr('id');
        if (id) {
            const $label = $('label[for="' + id + '"]');
            if ($label.length) {
                return $label.text().replace('*', '').trim();
            }
        }

        const $parentLabel = $field.closest('.form-group').find('.form-label');
        if ($parentLabel.length) {
            return $parentLabel.text().replace('*', '').trim();
        }

        const placeholder = $field.attr('placeholder');
        if (placeholder && !placeholder.includes('•')) {
            return placeholder.trim();
        }

        const name = $field.attr('name') || 'This field';
        return name.replace(/_/g, ' ').replace(/\b\w/g, function (l) { return l.toUpperCase(); });
    }

    /**
     * Check a single input against core business validation rules.
     */
    function validateInput($field) {
        if ($field.prop('disabled') || $field.attr('type') === 'hidden') {
            return true;
        }

        const val = $field.val();
        const trimmedVal = typeof val === 'string' ? $.trim(val) : val;
        const name = ($field.attr('name') || '').toLowerCase();
        const type = ($field.attr('type') || '').toLowerCase();
        const isRequired = $field.prop('required') ||
            $field.hasClass('required') ||
            $field.closest('.form-group').find('.required').length > 0;

        const label = getFieldLabel($field);

        // 1. Mandatory Required check
        if (isRequired) {
            if (trimmedVal === '' || trimmedVal === null || trimmedVal === undefined) {
                if ($field.is('select')) {
                    return 'Please select an option for ' + label + '.';
                }
                return label + ' is required.';
            }
        }

        // If field is optional and left blank, it is valid
        if (trimmedVal === '' || trimmedVal === null) {
            return true;
        }

        // 2. Email format validation
        if (type === 'email' || name.includes('email')) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            if (!emailRegex.test(trimmedVal)) {
                return 'Please enter a valid email address (e.g. name@company.com).';
            }
        }

        // 3. Password Confirmation Match
        if (name === 'password_confirmation') {
            const $form = $field.closest('form');
            const $pwd = $form.find('input[name="password"]');
            if ($pwd.length && trimmedVal !== $pwd.val()) {
                return 'Passwords do not match. Please re-enter identical passwords.';
            }
        }

        // 4. Password Length
        if (type === 'password' && name === 'password') {
            const $form = $field.closest('form');
            const isRegister = $form.attr('action') && $form.attr('action').includes('register');
            if (isRegister && trimmedVal.length < 8) {
                return 'Password must contain at least 8 characters.';
            }
        }

        // 5. Website / URL
        if (type === 'url' || name.includes('website') || name.includes('url')) {
            const urlRegex = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/.*)?$/i;
            if (!urlRegex.test(trimmedVal)) {
                return 'Please enter a valid website URL (e.g. https://vendor.com).';
            }
        }

        // 6. Total Seats
        if (name === 'total_seats' || name === 'seats') {
            const num = parseInt(trimmedVal, 10);
            if (isNaN(num) || num < 1) {
                return 'Total seats must be a whole number of at least 1.';
            }
        }

        // 7. Cost Per Seat
        if (name === 'cost_per_seat' || name === 'cost') {
            const cost = parseFloat(trimmedVal);
            if (isNaN(cost) || cost < 0) {
                return 'Cost must be a valid positive amount (e.g. 29.99).';
            }
        }

        // 8. Renewal Alert Window
        if (name === 'renewal_alert_days') {
            const days = parseInt(trimmedVal, 10);
            if (isNaN(days) || days < 1) {
                return 'Renewal notification window must be at least 1 day.';
            }
        }

        // 9. Date chronological order
        if (name === 'expiration_date') {
            const $form = $field.closest('form');
            const $purchase = $form.find('input[name="purchase_date"]');
            if ($purchase.length && $purchase.val() && trimmedVal) {
                const purchaseDate = new Date($purchase.val());
                const expirationDate = new Date(trimmedVal);
                if (expirationDate < purchaseDate) {
                    return 'Expiration date cannot be earlier than the purchase date.';
                }
            }
        }

        // 10. Message length
        if (name === 'message' && trimmedVal.length < 10) {
            return 'Message must contain at least 10 characters.';
        }

        return true;
    }

    /**
     * Show custom jQuery error badge beneath input.
     */
    function showError($field, message) {
        $field.addClass('is-invalid shake-input');
        setTimeout(function () {
            $field.removeClass('shake-input');
        }, 400);

        const $group = $field.closest('.form-group, .auth-field-group, div');
        let $err = $group.find('.jquery-validation-error');

        if (!$err.length) {
            $err = $('<div class="form-error jquery-validation-error"></div>');
            const $serverErr = $group.find('.form-error:not(.jquery-validation-error)');
            if ($serverErr.length) {
                $serverErr.hide();
            }

            if ($field.parent().hasClass('input-group')) {
                $field.parent().after($err);
            } else {
                $field.after($err);
            }
        }

        $err.html(
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">' +
            '<circle cx="12" cy="12" r="10"></circle>' +
            '<line x1="12" y1="8" x2="12" y2="12"></line>' +
            '<line x1="12" y1="16" x2="12.01" y2="16"></line>' +
            '</svg> <span>' + message + '</span>'
        ).show();
    }

    /**
     * Clear custom error message.
     */
    function clearError($field) {
        $field.removeClass('is-invalid');
        const $group = $field.closest('.form-group, .auth-field-group, div');
        $group.find('.jquery-validation-error').remove();
    }

    /**
     * Initialize jQuery Validation Plugin defaults if loaded.
     */
    function setupJqueryValidatePlugin() {
        if (typeof $.validator === 'undefined') {
            return;
        }

        $.validator.setDefaults({
            errorElement: 'div',
            errorClass: 'form-error jquery-validation-error',
            errorPlacement: function (error, element) {
                const $icon = $(
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">' +
                    '<circle cx="12" cy="12" r="10"></circle>' +
                    '<line x1="12" y1="8" x2="12" y2="12"></line>' +
                    '<line x1="12" y1="16" x2="12.01" y2="16"></line>' +
                    '</svg>'
                );
                error.prepend($icon);

                if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass('is-invalid shake-input');
                setTimeout(function () {
                    $(element).removeClass('shake-input');
                }, 400);
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    }

    /**
     * Bind form validation handlers.
     */
    function initFormValidation() {
        disableBrowserValidation();
        setupJqueryValidatePlugin();

        $('form').each(function () {
            const $form = $(this);

            // Skip simple search filters and hidden delete triggers
            if ($form.attr('method') && $form.attr('method').toUpperCase() === 'GET') {
                return;
            }
            if ($form.hasClass('filter-form') || $form.attr('id')?.includes('delete-')) {
                return;
            }

            // Ensure browser validation is permanently disabled on this form
            $form.attr('novalidate', 'novalidate');

            let submitAttempted = false;

            // Real-time evaluation on user typing or changing fields
            $form.on('input change blur', 'input, select, textarea', function () {
                const $input = $(this);
                if (submitAttempted || $input.hasClass('is-invalid')) {
                    const result = validateInput($input);
                    if (result === true) {
                        clearError($input);
                    } else {
                        showError($input, result);
                    }
                }
            });

            // Password confirmation link
            $form.on('input change', 'input[name="password"]', function () {
                const $confirm = $form.find('input[name="password_confirmation"]');
                if ($confirm.length && ($confirm.val() || submitAttempted)) {
                    const result = validateInput($confirm);
                    if (result === true) {
                        clearError($confirm);
                    } else {
                        showError($confirm, result);
                    }
                }
            });

            // On Form Submit: Validate all inputs
            $form.on('submit', function (e) {
                submitAttempted = true;
                let hasErrors = false;
                let $firstInvalid = null;

                $form.find('input, select, textarea').each(function () {
                    const $field = $(this);
                    const result = validateInput($field);

                    if (result !== true) {
                        showError($field, result);
                        hasErrors = true;
                        if (!$firstInvalid) {
                            $firstInvalid = $field;
                        }
                    } else {
                        clearError($field);
                    }
                });

                if (hasErrors) {
                    e.preventDefault();
                    e.stopPropagation();

                    if ($firstInvalid) {
                        $firstInvalid.focus();
                        if ($firstInvalid[0] && typeof $firstInvalid[0].scrollIntoView === 'function') {
                            $firstInvalid[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }

                    return false;
                }
            });
        });
    }

    $(document).ready(function () {
        initFormValidation();
    });

})(jQuery);
