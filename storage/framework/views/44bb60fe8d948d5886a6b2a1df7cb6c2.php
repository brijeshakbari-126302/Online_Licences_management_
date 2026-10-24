<?php $__env->startSection('title', 'Employee Staff'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Employee Directory</h1>
        <p class="page-subtitle">Corporate staff roster, departmental positions, and assigned software seats.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="11" x2="19" y2="17"></line><line x1="22" y1="14" x2="16" y2="14"></line></svg>
            Register Employee
        </a>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="toolbar-card">
    <form action="<?php echo e(route('employees.index')); ?>" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search name, ID (EMP-XXXX), email, or title..." value="<?php echo e($searchTerm); ?>">
        </div>

        <select name="department" class="form-select" style="width: auto; min-width: 170px;">
            <option value="">All Departments</option>
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept); ?>" <?php echo e($selectedDepartment === $dept ? 'selected' : ''); ?>><?php echo e($dept); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="status" class="form-select" style="width: auto; min-width: 130px;">
            <option value="">All Statuses</option>
            <option value="active" <?php echo e($selectedStatus === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e($selectedStatus === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            <option value="on_leave" <?php echo e($selectedStatus === 'on_leave' ? 'selected' : ''); ?>>On Leave</option>
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>

        <?php if($searchTerm || $selectedDepartment || $selectedStatus): ?>
            <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Employees Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Employee Staff Member</th>
                <th>Employee ID</th>
                <th>Department & Role</th>
                <th>Email & Contact</th>
                <th>Active License Seats</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('employees.show', $employee)); ?>" class="table-cell-main">
                            <?php echo e($employee->name); ?>

                        </a>
                        <div class="table-cell-sub"><?php echo e($employee->job_title); ?></div>
                    </td>
                    <td>
                        <code class="license-key-tag" style="color: var(--primary); font-weight: 600;"><?php echo e($employee->employee_id); ?></code>
                    </td>
                    <td>
                        <div style="font-weight: 500; color: var(--text-main);"><?php echo e($employee->department); ?></div>
                        <div class="table-cell-sub"><?php echo e($employee->job_title); ?></div>
                    </td>
                    <td>
                        <div><a href="mailto:<?php echo e($employee->email); ?>" style="color: var(--primary);"><?php echo e($employee->email); ?></a></div>
                        <div class="table-cell-sub"><?php echo e($employee->phone ?? '-'); ?></div>
                    </td>
                    <td>
                        <span class="badge <?php echo e($employee->active_assignments_count > 0 ? 'badge-primary' : 'badge-neutral'); ?>">
                            <?php echo e($employee->active_assignments_count); ?> <?php echo e(Str::plural('Seat', $employee->active_assignments_count)); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($employee->status === 'active'): ?>
                            <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                        <?php elseif($employee->status === 'on_leave'): ?>
                            <span class="badge badge-expiring"><span class="badge-dot"></span> On Leave</span>
                        <?php else: ?>
                            <span class="badge badge-neutral"><span class="badge-dot"></span> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                            <a href="<?php echo e(route('assignments.create', ['employee_id' => $employee->id])); ?>" class="btn btn-secondary btn-sm" title="Assign License">
                                + Assign
                            </a>
                            <a href="<?php echo e(route('employees.show', $employee)); ?>" class="btn btn-secondary btn-icon" title="View Profile">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn btn-secondary btn-icon" title="Edit Employee">
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="empty-state-title">No employees found</div>
                            <div class="empty-state-desc">Try clearing your filters or register team members to assign software seats.</div>
                            <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary btn-sm">Register First Employee</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    <?php echo e($employees->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/employees/index.blade.php ENDPATH**/ ?>