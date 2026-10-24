<?php $__env->startSection('title', 'Add Software License'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title-group">
        <h1>Add Software License</h1>
        <p class="page-subtitle">Register a newly purchased license or subscription into the corporate inventory.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary">
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
        <form action="<?php echo e(route('licenses.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Vendor and Application Name -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Vendor / Publisher <span class="required">*</span></label>
                    <select name="vendor_id" class="form-select <?php $__errorArgs = ['vendor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Select a vendor...</option>
                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vendor->id); ?>" <?php echo e(old('vendor_id') == $vendor->id ? 'selected' : ''); ?>>
                                <?php echo e($vendor->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['vendor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Vendor not listed? <a href="<?php echo e(route('vendors.create')); ?>" target="_blank">Add new vendor &rarr;</a></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Software Application Name <span class="required">*</span></label>
                    <input type="text" name="software_name" class="form-input <?php $__errorArgs = ['software_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. JetBrains All Products Pack" value="<?php echo e(old('software_name')); ?>" required>
                    <?php $__errorArgs = ['software_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- License Key and Category -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">License Key / Serial / Contract ID</label>
                    <input type="text" name="license_key" class="form-input <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. XXXX-XXXX-XXXX-XXXX" value="<?php echo e(old('license_key')); ?>" style="font-family: var(--font-mono);">
                    <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Leave blank if auto-provisioned via SSO / cloud login.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" list="category-suggestions" class="form-input <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. Development, Design, Productivity" value="<?php echo e(old('category', 'Development')); ?>">
                    <datalist id="category-suggestions">
                        <option value="Development">
                        <option value="Design">
                        <option value="Productivity">
                        <option value="DevOps & IT">
                        <option value="Security">
                        <option value="Finance & Accounting">
                        <option value="Communication">
                    </datalist>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- License Type and Seat Count -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">License Type <span class="required">*</span></label>
                    <select name="license_type" class="form-select <?php $__errorArgs = ['license_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="Subscription" <?php echo e(old('license_type') === 'Subscription' ? 'selected' : ''); ?>>Subscription (SaaS)</option>
                        <option value="Per Seat" <?php echo e(old('license_type') === 'Per Seat' ? 'selected' : ''); ?>>Per Seat / Named User</option>
                        <option value="Enterprise" <?php echo e(old('license_type') === 'Enterprise' ? 'selected' : ''); ?>>Enterprise Agreement</option>
                        <option value="Perpetual" <?php echo e(old('license_type') === 'Perpetual' ? 'selected' : ''); ?>>Perpetual / Standalone</option>
                        <option value="Trial" <?php echo e(old('license_type') === 'Trial' ? 'selected' : ''); ?>>Evaluation / Trial</option>
                    </select>
                    <?php $__errorArgs = ['license_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Total Purchased Seats <span class="required">*</span></label>
                    <input type="number" name="total_seats" class="form-input <?php $__errorArgs = ['total_seats'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" step="1" value="<?php echo e(old('total_seats', 1)); ?>" required>
                    <?php $__errorArgs = ['total_seats'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Number of staff seats licensed under this agreement.</div>
                </div>
            </div>

            <!-- Pricing and Billing Details -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Cost Per Seat</label>
                    <input type="number" name="cost_per_seat" class="form-input <?php $__errorArgs = ['cost_per_seat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="0" step="0.01" placeholder="0.00" value="<?php echo e(old('cost_per_seat', '0.00')); ?>">
                    <?php $__errorArgs = ['cost_per_seat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Currency <span class="required">*</span></label>
                    <select name="currency" class="form-select <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="USD" <?php echo e(old('currency', 'USD') === 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                        <option value="EUR" <?php echo e(old('currency') === 'EUR' ? 'selected' : ''); ?>>EUR (€)</option>
                        <option value="GBP" <?php echo e(old('currency') === 'GBP' ? 'selected' : ''); ?>>GBP (£)</option>
                        <option value="CAD" <?php echo e(old('currency') === 'CAD' ? 'selected' : ''); ?>>CAD ($)</option>
                        <option value="INR" <?php echo e(old('currency') === 'INR' ? 'selected' : ''); ?>>INR (₹)</option>
                    </select>
                    <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Billing Cycle <span class="required">*</span></label>
                    <select name="billing_cycle" class="form-select <?php $__errorArgs = ['billing_cycle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="annually" <?php echo e(old('billing_cycle', 'annually') === 'annually' ? 'selected' : ''); ?>>Annually</option>
                        <option value="monthly" <?php echo e(old('billing_cycle') === 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                        <option value="quarterly" <?php echo e(old('billing_cycle') === 'quarterly' ? 'selected' : ''); ?>>Quarterly</option>
                        <option value="one-time" <?php echo e(old('billing_cycle') === 'one-time' ? 'selected' : ''); ?>>One-Time / Perpetual</option>
                    </select>
                    <?php $__errorArgs = ['billing_cycle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Dates and Status -->
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Purchase Date <span class="required">*</span></label>
                    <input type="date" name="purchase_date" class="form-input <?php $__errorArgs = ['purchase_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('purchase_date', date('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['purchase_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Expiration / Renewal Date</label>
                    <input type="date" name="expiration_date" class="form-input <?php $__errorArgs = ['expiration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('expiration_date')); ?>">
                    <?php $__errorArgs = ['expiration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Leave blank for non-expiring perpetual licenses.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="active" <?php echo e(old('status', 'active') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="expiring_soon" <?php echo e(old('status') === 'expiring_soon' ? 'selected' : ''); ?>>Expiring Soon</option>
                        <option value="expired" <?php echo e(old('status') === 'expired' ? 'selected' : ''); ?>>Expired</option>
                        <option value="suspended" <?php echo e(old('status') === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">Contract Notes & Provisions</label>
                <textarea name="notes" rows="3" class="form-textarea <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Terms, account manager notes, tier limits, or special conditions..."><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Software License</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/licenses/create.blade.php ENDPATH**/ ?>