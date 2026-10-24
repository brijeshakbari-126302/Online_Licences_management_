<?php $__env->startSection('title', 'Executive Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Executive License Dashboard</h1>
        <p class="page-subtitle">Real-time visibility into enterprise software assets, compliance, seats, and renewals.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('licenses.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Software License
        </a>
        <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            Assign Seat
        </a>
    </div>
</div>

<!-- KPI Metrics Grid -->
<div class="kpi-grid">
    <!-- Total Licenses -->
    <div class="kpi-card accent-primary">
        <div class="kpi-top">
            <span class="kpi-label">Active Products</span>
            <div class="kpi-icon-wrapper primary">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
            </div>
        </div>
        <div class="kpi-value"><?php echo e($totalLicenses); ?></div>
        <div class="kpi-meta">
            <span><?php echo e($totalSeats); ?> total licensed seats across <?php echo e($totalVendors); ?> vendors</span>
        </div>
    </div>

    <!-- Assigned Seats -->
    <div class="kpi-card accent-success">
        <div class="kpi-top">
            <span class="kpi-label">Seats Deployed</span>
            <div class="kpi-icon-wrapper success">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
        </div>
        <div class="kpi-value"><?php echo e($totalAssignedSeats); ?></div>
        <div class="kpi-meta">
            <span><?php echo e($totalSeats > 0 ? round(($totalAssignedSeats / $totalSeats) * 100) : 0); ?>% total seat utilization rate</span>
        </div>
    </div>

    <!-- Available Seats -->
    <div class="kpi-card accent-info">
        <div class="kpi-top">
            <span class="kpi-label">Available Capacity</span>
            <div class="kpi-icon-wrapper info">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </div>
        </div>
        <div class="kpi-value"><?php echo e($totalAvailableSeats); ?></div>
        <div class="kpi-meta">
            <span>Remaining seats available for onboarding</span>
        </div>
    </div>

    <!-- Est. Annual Spend -->
    <div class="kpi-card accent-warning">
        <div class="kpi-top">
            <span class="kpi-label">Est. Annual Software Spend</span>
            <div class="kpi-icon-wrapper warning">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
        </div>
        <div class="kpi-value">$<?php echo e(number_format($totalAnnualSpend, 2)); ?></div>
        <div class="kpi-meta">
            <span>Across monthly and annual enterprise tiers</span>
        </div>
    </div>
</div>

<!-- Urgent Expiration Alert Banner (If Any) -->
<?php if($expiringLicenses->isNotEmpty() || $expiredLicenses->isNotEmpty()): ?>
    <div class="panel-card" style="border-color: rgba(245, 158, 11, 0.4); background: #fffbeb; margin-bottom: 2rem;">
        <div class="panel-header" style="border-bottom-color: rgba(245, 158, 11, 0.25);">
            <div class="panel-title" style="color: #b45309;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <span>Attention Required: Licenses Expiring Soon or Expired</span>
            </div>
            <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary btn-sm" style="border-color: rgba(245, 158, 11, 0.4); color: #b45309;">View All Licenses</a>
        </div>
        <div class="table-responsive" style="background: transparent; border: none; border-radius: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Software</th>
                        <th>Vendor</th>
                        <th>Expiration Date</th>
                        <th>Seats</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expiringLicenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('licenses.show', $license)); ?>" class="table-cell-main"><?php echo e($license->software_name); ?></a>
                                <div class="table-cell-sub"><?php echo e($license->license_type); ?></div>
                            </td>
                            <td><?php echo e($license->vendor->name ?? 'N/A'); ?></td>
                            <td>
                                <span style="color: #b45309; font-weight: 600;"><?php echo e($license->expiration_date->format('M d, Y')); ?></span>
                                <div class="table-cell-sub">In <?php echo e($license->expiration_date->diffInDays(now())); ?> days</div>
                            </td>
                            <td><?php echo e($license->activeAssignments->count()); ?> / <?php echo e($license->total_seats); ?></td>
                            <td>
                                <span class="badge badge-expiring">
                                    <span class="badge-dot"></span>
                                    Expiring Soon
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('licenses.edit', $license)); ?>" class="btn btn-secondary btn-sm">Renew / Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $expiredLicenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('licenses.show', $license)); ?>" class="table-cell-main"><?php echo e($license->software_name); ?></a>
                                <div class="table-cell-sub"><?php echo e($license->license_type); ?></div>
                            </td>
                            <td><?php echo e($license->vendor->name ?? 'N/A'); ?></td>
                            <td>
                                <span style="color: #dc2626; font-weight: 600;"><?php echo e($license->expiration_date->format('M d, Y')); ?></span>
                                <div class="table-cell-sub">Expired <?php echo e($license->expiration_date->diffForHumans()); ?></div>
                            </td>
                            <td><?php echo e($license->activeAssignments->count()); ?> / <?php echo e($license->total_seats); ?></td>
                            <td>
                                <span class="badge badge-expired">
                                    <span class="badge-dot"></span>
                                    Expired
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('licenses.edit', $license)); ?>" class="btn btn-danger btn-sm">Renew Now</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- Dashboard 2-Column Section -->
<div class="dashboard-grid-2">
    <!-- Left Column: Recent Seat Assignments -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>
                <span>Recent License Assignments</span>
            </div>
            <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-secondary btn-sm">View All Assignments</a>
        </div>
        <div class="panel-body" style="padding: 0;">
            <?php if($recentAssignments->isEmpty()): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div class="empty-state-title">No assignments recorded yet</div>
                    <div class="empty-state-desc">Assign your active software licenses to company employees to track usage.</div>
                    <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-primary btn-sm">Assign First Seat</a>
                </div>
            <?php else: ?>
                <div class="table-responsive" style="border: none; border-radius: 0;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Software License</th>
                                <th>Assigned Date</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('employees.show', $assignment->employee)); ?>" class="table-cell-main">
                                            <?php echo e($assignment->employee->name); ?>

                                        </a>
                                        <div class="table-cell-sub"><?php echo e($assignment->employee->department); ?> &bull; <?php echo e($assignment->employee->job_title); ?></div>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('licenses.show', $assignment->license)); ?>" class="table-cell-main">
                                            <?php echo e($assignment->license->software_name); ?>

                                        </a>
                                        <div class="table-cell-sub"><?php echo e($assignment->license->vendor->name ?? ''); ?></div>
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
                                        <a href="<?php echo e(route('assignments.show', $assignment)); ?>" class="btn btn-secondary btn-sm">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column: Category Distribution & Quick Links -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Category Breakdown -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>License Categories</span>
                </div>
            </div>
            <div class="panel-body">
                <?php if($categoryStats->isEmpty()): ?>
                    <p style="color: var(--text-dim); font-size: 0.88rem;">No categories defined yet.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php $__currentLoopData = $categoryStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem; font-size: 0.86rem;">
                                    <span style="font-weight: 600; color: var(--text-main);"><?php echo e($cat->category); ?></span>
                                    <span style="color: var(--text-muted); font-size: 0.8rem;"><?php echo e($cat->count); ?> apps &bull; <?php echo e($cat->total_seats); ?> seats</span>
                                </div>
                                <div class="seat-meter-bar">
                                    <div class="seat-meter-fill normal" style="width: <?php echo e($totalSeats > 0 ? min(100, round(($cat->total_seats / $totalSeats) * 100)) : 0); ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Access Card -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Quick Management</span>
                </div>
            </div>
            <div class="panel-body" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="<?php echo e(route('licenses.create')); ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"></path></svg>
                    Register New Software License
                </a>
                <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                    Assign License Seat to Employee
                </a>
                <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="11" x2="19" y2="17"></line><line x1="22" y1="14" x2="16" y2="14"></line></svg>
                    Add Employee Member
                </a>
                <a href="<?php echo e(route('vendors.create')); ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Add Software Vendor Partner
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/dashboard.blade.php ENDPATH**/ ?>