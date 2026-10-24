<?php $__env->startSection('title', 'Seat Assignments'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>License Seat Assignments</h1>
        <p class="page-subtitle">Audit trail of software seat allocations, hardware workstation links, and revocations.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            Assign License Seat
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="toolbar-card">
    <form action="<?php echo e(route('assignments.index')); ?>" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search employee, license, device..." value="<?php echo e($searchTerm); ?>">
        </div>

        <select name="status" class="form-select" style="width: auto; min-width: 140px;">
            <option value="">All Statuses</option>
            <option value="active" <?php echo e($selectedStatus === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="revoked" <?php echo e($selectedStatus === 'revoked' ? 'selected' : ''); ?>>Revoked</option>
        </select>

        <select name="license_id" class="form-select" style="width: auto; min-width: 180px;">
            <option value="">All Licenses</option>
            <?php $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($lic->id); ?>" <?php echo e($selectedLicense == $lic->id ? 'selected' : ''); ?>><?php echo e($lic->software_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="employee_id" class="form-select" style="width: auto; min-width: 180px;">
            <option value="">All Employees</option>
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($emp->id); ?>" <?php echo e($selectedEmployee == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>

        <?php if($searchTerm || $selectedStatus || $selectedLicense || $selectedEmployee): ?>
            <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Assignments Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Software License</th>
                <th>Assigned Staff Member</th>
                <th>Device / Station Info</th>
                <th>Assigned Date</th>
                <th>Revoked Date</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('licenses.show', $assignment->license)); ?>" class="table-cell-main">
                            <?php echo e($assignment->license->software_name); ?>

                        </a>
                        <div class="table-cell-sub"><?php echo e($assignment->license->vendor->name ?? ''); ?></div>
                    </td>
                    <td>
                        <a href="<?php echo e(route('employees.show', $assignment->employee)); ?>" class="table-cell-main">
                            <?php echo e($assignment->employee->name); ?>

                        </a>
                        <div class="table-cell-sub"><?php echo e($assignment->employee->department); ?> &bull; <?php echo e($assignment->employee->employee_id); ?></div>
                    </td>
                    <td>
                        <?php if($assignment->device_info): ?>
                            <code class="license-key-tag"><?php echo e($assignment->device_info); ?></code>
                        <?php else: ?>
                            <span style="color: var(--text-dim); font-size: 0.8rem;">Unspecified device</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($assignment->assigned_date ? $assignment->assigned_date->format('M d, Y') : '-'); ?></td>
                    <td>
                        <?php if($assignment->revoked_date): ?>
                            <span style="color: var(--text-dim); font-size: 0.84rem;"><?php echo e($assignment->revoked_date->format('M d, Y')); ?></span>
                        <?php else: ?>
                            <span style="color: var(--text-dim); font-size: 0.84rem;">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($assignment->status === 'active'): ?>
                            <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                        <?php else: ?>
                            <span class="badge badge-neutral"><span class="badge-dot"></span> Revoked</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                            <a href="<?php echo e(route('assignments.show', $assignment)); ?>" class="btn btn-secondary btn-icon" title="View Details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="<?php echo e(route('assignments.edit', $assignment)); ?>" class="btn btn-secondary btn-icon" title="Edit Assignment">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>
                            </div>
                            <div class="empty-state-title">No assignments found</div>
                            <div class="empty-state-desc">Allocate software licenses to employees to track company seat usage.</div>
                            <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-primary btn-sm">Assign License Seat</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    <?php echo e($assignments->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/assignments/index.blade.php ENDPATH**/ ?>