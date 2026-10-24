<?php $__env->startSection('title', $license->software_name . ' - Software License'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary btn-icon" title="Back to licenses">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1><?php echo e($license->software_name); ?></h1>
        </div>
        <p class="page-subtitle">Provided by <a href="<?php echo e(route('vendors.show', $license->vendor)); ?>" style="color: var(--primary); font-weight: 600;"><?php echo e($license->vendor->name); ?></a> &bull; <?php echo e($license->license_type); ?></p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('assignments.create', ['license_id' => $license->id])); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            Assign Seat to Staff
        </a>
        <a href="<?php echo e(route('licenses.edit', $license)); ?>" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit License
        </a>
    </div>
</div>

<!-- Hero Information Card -->
<div class="detail-hero-card">
    <div class="detail-hero-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.5rem;">
                <span class="badge badge-primary"><?php echo e($license->category ?? 'Software Asset'); ?></span>
                <?php if($license->status === 'active'): ?>
                    <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                <?php elseif($license->status === 'expiring_soon'): ?>
                    <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring Soon</span>
                <?php elseif($license->status === 'expired'): ?>
                    <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                <?php else: ?>
                    <span class="badge badge-neutral"><span class="badge-dot"></span> <?php echo e(ucfirst($license->status)); ?></span>
                <?php endif; ?>
            </div>
            <div style="font-size: 1.15rem; color: var(--text-muted);">
                Vendor Publisher: <a href="<?php echo e(route('vendors.show', $license->vendor)); ?>" style="color: var(--text-main); font-weight: 600;"><?php echo e($license->vendor->name); ?></a>
            </div>
        </div>

        <div style="min-width: 200px;">
            <div class="seat-meter-info" style="margin-bottom: 0.35rem;">
                <span style="font-weight: 600; color: var(--text-main);">Seats In Use: <?php echo e($license->assigned_seats_count); ?> / <?php echo e($license->total_seats); ?></span>
                <span style="font-weight: 700; color: var(--primary);"><?php echo e($license->utilization_percentage); ?>%</span>
            </div>
            <div class="seat-meter-bar" style="height: 10px;">
                <div class="seat-meter-fill <?php echo e($license->utilization_percentage >= 90 ? 'warning' : 'normal'); ?>" style="width: <?php echo e($license->utilization_percentage); ?>%;"></div>
            </div>
            <div style="font-size: 0.78rem; color: var(--text-dim); margin-top: 0.35rem;"><?php echo e($license->available_seats_count); ?> remaining seats available for assignment</div>
        </div>
    </div>

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-item-label">License Key / Serial</span>
            <span class="meta-item-value">
                <?php if($license->license_key): ?>
                    <code class="license-key-tag" style="font-size: 0.85rem;"><?php echo e($license->license_key); ?></code>
                <?php else: ?>
                    <span style="color: var(--text-dim);">Cloud Single Sign-On</span>
                <?php endif; ?>
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Cost Per Seat</span>
            <span class="meta-item-value">$<?php echo e(number_format($license->cost_per_seat, 2)); ?> <?php echo e($license->currency); ?></span>
            <span style="font-size: 0.76rem; color: var(--text-dim);">Billed <?php echo e(ucfirst($license->billing_cycle)); ?></span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Total Agreement Spend</span>
            <span class="meta-item-value" style="color: var(--primary);">$<?php echo e(number_format($license->total_cost, 2)); ?> <?php echo e($license->currency); ?></span>
            <span style="font-size: 0.76rem; color: var(--text-dim);">For <?php echo e($license->total_seats); ?> total seats</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Purchase Date</span>
            <span class="meta-item-value"><?php echo e($license->purchase_date ? $license->purchase_date->format('M d, Y') : '-'); ?></span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Expiration / Renewal</span>
            <span class="meta-item-value" style="color: <?php echo e($license->isExpired() ? '#dc2626' : ($license->isExpiringSoon() ? '#d97706' : 'var(--text-main)')); ?>;">
                <?php echo e($license->expiration_date ? $license->expiration_date->format('M d, Y') : 'Never (Perpetual)'); ?>

            </span>
            <?php if($license->expiration_date): ?>
                <span style="font-size: 0.76rem; color: var(--text-dim);">
                    <?php if($license->isExpired()): ?>
                        Expired <?php echo e($license->expiration_date->diffForHumans()); ?>

                    <?php else: ?>
                        <?php echo e($license->expiration_date->diffInDays(now())); ?> days remaining
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- License Notes -->
<?php if($license->notes): ?>
    <div class="panel-card" style="margin-bottom: 2rem;">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <span>Contract Provisions & Notes</span>
            </div>
        </div>
        <div class="panel-body">
            <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; white-space: pre-line;"><?php echo e($license->notes); ?></p>
        </div>
    </div>
<?php endif; ?>

<!-- Allocated Employee Seats Table -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Allocated Seat Members (<?php echo e($license->assignments->count()); ?>)</span>
        </div>
        <a href="<?php echo e(route('assignments.create', ['license_id' => $license->id])); ?>" class="btn btn-primary btn-sm">
            + Assign Seat
        </a>
    </div>
    <div class="panel-body" style="padding: 0;">
        <?php if($license->assignments->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                </div>
                <div class="empty-state-title">No employees assigned yet</div>
                <div class="empty-state-desc">You have <?php echo e($license->total_seats); ?> seats available to distribute to team members.</div>
                <a href="<?php echo e(route('assignments.create', ['license_id' => $license->id])); ?>" class="btn btn-primary btn-sm">Assign First Seat</a>
            </div>
        <?php else: ?>
            <div class="table-responsive" style="border: none; border-radius: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Department</th>
                            <th>Device / Station</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $license->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('employees.show', $assignment->employee)); ?>" class="table-cell-main">
                                        <?php echo e($assignment->employee->name); ?>

                                    </a>
                                    <div class="table-cell-sub"><?php echo e($assignment->employee->email); ?> &bull; <?php echo e($assignment->employee->employee_id); ?></div>
                                </td>
                                <td><?php echo e($assignment->employee->department); ?></td>
                                <td>
                                    <?php if($assignment->device_info): ?>
                                        <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-muted);"><?php echo e($assignment->device_info); ?></span>
                                    <?php else: ?>
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">Unspecified</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($assignment->assigned_date ? $assignment->assigned_date->format('M d, Y') : '-'); ?></td>
                                <td>
                                    <?php if($assignment->status === 'active'): ?>
                                        <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-neutral"><span class="badge-dot"></span> Revoked</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="<?php echo e(route('assignments.show', $assignment)); ?>" class="btn btn-secondary btn-sm">Manage</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/licenses/show.blade.php ENDPATH**/ ?>