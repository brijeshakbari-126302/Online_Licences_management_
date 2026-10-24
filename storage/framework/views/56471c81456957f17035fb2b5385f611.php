<?php $__env->startSection('title', 'System Settings'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>System Settings & Preferences</h1>
        <p class="page-subtitle">Configure organization metadata, default currencies, notification thresholds, and inspect runtime diagnostics.</p>
    </div>
</div>

<div class="dashboard-grid-2">
    <!-- Left: Settings Form -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span>Organizational Preferences</span>
            </div>
        </div>
        <div class="panel-body">
            <form action="<?php echo e(route('settings.update')); ?>" method="POST" novalidate id="settings-form">
                <?php echo csrf_field(); ?>

                <!-- Company Info -->
                <div class="form-group">
                    <label class="form-label">Enterprise / Company Name <span class="required">*</span></label>
                    <input type="text" name="company_name" class="form-input <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('company_name', session('settings.company_name', config('app.name', 'LicenseHub Enterprise')))); ?>" required>
                    <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Displayed across navigation, reports, and generated export audit documents.</div>
                </div>

                <!-- Admin Email -->
                <div class="form-group">
                    <label class="form-label">IT License Administrator Email <span class="required">*</span></label>
                    <input type="email" name="admin_email" class="form-input <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('admin_email', session('settings.admin_email', 'admin@licensehub.pro'))); ?>" required>
                    <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Recipient for expiration alerts and license seat threshold notifications.</div>
                </div>

                <div class="form-grid-2">
                    <!-- Default Currency -->
                    <div class="form-group">
                        <label class="form-label">Default Currency Symbol / Code <span class="required">*</span></label>
                        <select name="default_currency" class="form-select <?php $__errorArgs = ['default_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="USD" <?php echo e(old('default_currency', session('settings.default_currency', 'USD')) === 'USD' ? 'selected' : ''); ?>>USD ($ - US Dollar)</option>
                            <option value="EUR" <?php echo e(old('default_currency', session('settings.default_currency', 'USD')) === 'EUR' ? 'selected' : ''); ?>>EUR (€ - Euro)</option>
                            <option value="GBP" <?php echo e(old('default_currency', session('settings.default_currency', 'USD')) === 'GBP' ? 'selected' : ''); ?>>GBP (£ - British Pound)</option>
                            <option value="INR" <?php echo e(old('default_currency', session('settings.default_currency', 'USD')) === 'INR' ? 'selected' : ''); ?>>INR (₹ - Indian Rupee)</option>
                            <option value="CAD" <?php echo e(old('default_currency', session('settings.default_currency', 'USD')) === 'CAD' ? 'selected' : ''); ?>>CAD ($ - Canadian Dollar)</option>
                        </select>
                        <?php $__errorArgs = ['default_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Alert Threshold -->
                    <div class="form-group">
                        <label class="form-label">Expiration Warning Window <span class="required">*</span></label>
                        <select name="alert_lead_days" class="form-select <?php $__errorArgs = ['alert_lead_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="15" <?php echo e(old('alert_lead_days', session('settings.alert_lead_days', 30)) == 15 ? 'selected' : ''); ?>>15 Days Before Expiry</option>
                            <option value="30" <?php echo e(old('alert_lead_days', session('settings.alert_lead_days', 30)) == 30 ? 'selected' : ''); ?>>30 Days Before Expiry (Recommended)</option>
                            <option value="60" <?php echo e(old('alert_lead_days', session('settings.alert_lead_days', 30)) == 60 ? 'selected' : ''); ?>>60 Days Before Expiry</option>
                            <option value="90" <?php echo e(old('alert_lead_days', session('settings.alert_lead_days', 30)) == 90 ? 'selected' : ''); ?>>90 Days Before Expiry</option>
                        </select>
                        <?php $__errorArgs = ['alert_lead_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                    <button type="submit" class="btn btn-primary">Save Preferences</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right: System Diagnostics & Health -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- System Health Card -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    <span>System Runtime Diagnostics</span>
                </div>
            </div>
            <div class="panel-body" style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding-bottom: 0.65rem; border-bottom: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">Application Edition</span>
                    <span style="font-weight: 700; color: var(--text-main);"><?php echo e($systemInfo['app_version']); ?></span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding-bottom: 0.65rem; border-bottom: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">Laravel Framework</span>
                    <span style="font-weight: 600; color: var(--primary);">v<?php echo e($systemInfo['laravel_version']); ?></span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding-bottom: 0.65rem; border-bottom: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">PHP Runtime</span>
                    <span style="font-weight: 600; color: var(--text-main);">PHP <?php echo e($systemInfo['php_version']); ?></span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding-bottom: 0.65rem; border-bottom: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">Database Connection</span>
                    <span class="badge badge-active"><span class="badge-dot"></span> <?php echo e($systemInfo['database_driver']); ?> (<?php echo e($systemInfo['database_status']); ?>)</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem; padding-bottom: 0.65rem; border-bottom: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">Application Environment</span>
                    <span class="badge badge-neutral"><?php echo e(ucfirst($systemInfo['environment'])); ?></span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.88rem;">
                    <span style="color: var(--text-muted);">Storage Writable</span>
                    <span style="color: var(--success); font-weight: 600;">✓ Ready (Read/Write)</span>
                </div>
            </div>
        </div>

        <!-- Inventory Database Counts -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Database Record Inventory</span>
                </div>
            </div>
            <div class="panel-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="padding: 0.75rem; background: var(--bg-surface-hover); border-radius: var(--radius-md); text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);"><?php echo e($systemInfo['total_licenses']); ?></div>
                        <div style="font-size: 0.78rem; color: var(--text-dim); text-transform: uppercase;">Software Licenses</div>
                    </div>
                    <div style="padding: 0.75rem; background: var(--bg-surface-hover); border-radius: var(--radius-md); text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--success);"><?php echo e($systemInfo['total_assignments']); ?></div>
                        <div style="font-size: 0.78rem; color: var(--text-dim); text-transform: uppercase;">Seat Allocations</div>
                    </div>
                    <div style="padding: 0.75rem; background: var(--bg-surface-hover); border-radius: var(--radius-md); text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--info);"><?php echo e($systemInfo['total_vendors']); ?></div>
                        <div style="font-size: 0.78rem; color: var(--text-dim); text-transform: uppercase;">Software Vendors</div>
                    </div>
                    <div style="padding: 0.75rem; background: var(--bg-surface-hover); border-radius: var(--radius-md); text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--warning);"><?php echo e($systemInfo['total_employees']); ?></div>
                        <div style="font-size: 0.78rem; color: var(--text-dim); text-transform: uppercase;">Employee Staff</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/settings/index.blade.php ENDPATH**/ ?>