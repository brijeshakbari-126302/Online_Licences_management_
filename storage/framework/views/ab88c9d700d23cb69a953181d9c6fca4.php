<?php $__env->startSection('title', 'Assign License Seat'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title-group">
        <h1>Assign License Seat</h1>
        <p class="page-subtitle">Allocate an available software license seat to an active company employee.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-secondary">
            &larr; Back to Assignments
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            <span>Assignment Allocation</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="<?php echo e(route('assignments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Software License Selection -->
            <div class="form-group">
                <label class="form-label">Software License <span class="required">*</span></label>
                <select name="license_id" class="form-select <?php $__errorArgs = ['license_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Select a software license...</option>
                    <?php $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $available = $lic->available_seats_count;
                            $isSelected = old('license_id', $preselectedLicenseId) == $lic->id;
                        ?>
                        <option value="<?php echo e($lic->id); ?>" <?php echo e($isSelected ? 'selected' : ''); ?> <?php echo e($available <= 0 && !$isSelected ? 'disabled' : ''); ?>>
                            <?php echo e($lic->software_name); ?> (<?php echo e($lic->vendor->name); ?>) &mdash; <?php echo e($available); ?> available of <?php echo e($lic->total_seats); ?> seats <?php echo e($available <= 0 ? '[FULL]' : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['license_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="form-hint">Only licenses with available remaining capacity can be allocated.</div>
            </div>

            <!-- Employee Selection -->
            <div class="form-group">
                <label class="form-label">Employee Recipient <span class="required">*</span></label>
                <select name="employee_id" class="form-select <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Select an employee...</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id', $preselectedEmployeeId) == $emp->id ? 'selected' : ''); ?>>
                            <?php echo e($emp->name); ?> (<?php echo e($emp->employee_id); ?>) &mdash; <?php echo e($emp->department); ?> &bull; <?php echo e($emp->job_title); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-grid-2">
                <!-- Assigned Date -->
                <div class="form-group">
                    <label class="form-label">Date Assigned <span class="required">*</span></label>
                    <input type="date" name="assigned_date" class="form-input <?php $__errorArgs = ['assigned_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('assigned_date', date('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['assigned_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Hardware Device / Station Info -->
                <div class="form-group">
                    <label class="form-label">Hardware Device / Workstation Info</label>
                    <input type="text" name="device_info" class="form-input <?php $__errorArgs = ['device_info'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. MacBook Pro 16 (Asset IT-104)" value="<?php echo e(old('device_info')); ?>">
                    <?php $__errorArgs = ['device_info'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-hint">Hardware device ID, laptop serial, or cloud VM name.</div>
                </div>
            </div>

            <!-- Assignment Notes -->
            <div class="form-group">
                <label class="form-label">Allocation Notes & Justification</label>
                <textarea name="notes" rows="3" class="form-textarea <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Project name, manager approval, or temporary assignment details..."><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Allocate Seat</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/assignments/create.blade.php ENDPATH**/ ?>