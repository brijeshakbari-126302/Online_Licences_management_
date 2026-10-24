<?php $__env->startSection('title', 'Software Licenses'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Software Licenses</h1>
        <p class="page-subtitle">Track, audit, and allocate enterprise application subscriptions and software keys.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('licenses.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New License
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="toolbar-card">
    <form action="<?php echo e(route('licenses.index')); ?>" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search software, key, or vendor..." value="<?php echo e($searchTerm); ?>">
        </div>

        <select name="status" class="form-select" style="width: auto; min-width: 140px;">
            <option value="">All Statuses</option>
            <option value="active" <?php echo e($selectedStatus === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="expiring_soon" <?php echo e($selectedStatus === 'expiring_soon' ? 'selected' : ''); ?>>Expiring Soon</option>
            <option value="expired" <?php echo e($selectedStatus === 'expired' ? 'selected' : ''); ?>>Expired</option>
            <option value="suspended" <?php echo e($selectedStatus === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
        </select>

        <select name="vendor_id" class="form-select" style="width: auto; min-width: 160px;">
            <option value="">All Vendors</option>
            <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($vendor->id); ?>" <?php echo e($selectedVendor == $vendor->id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="category" class="form-select" style="width: auto; min-width: 140px;">
            <option value="">All Categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat); ?>" <?php echo e($selectedCategory === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>

        <?php if($searchTerm || $selectedStatus || $selectedVendor || $selectedCategory): ?>
            <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- License Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Software Application</th>
                <th>Vendor</th>
                <th>License Key / ID</th>
                <th>Seat Capacity</th>
                <th>Cost & Billing</th>
                <th>Expiration</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $assignedCount = $license->activeAssignments->count();
                    $utilization = $license->total_seats > 0 ? round(($assignedCount / $license->total_seats) * 100) : 0;
                ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('licenses.show', $license)); ?>" class="table-cell-main">
                            <?php echo e($license->software_name); ?>

                        </a>
                        <div class="table-cell-sub">
                            <span class="badge badge-primary" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;"><?php echo e($license->category ?? 'General'); ?></span>
                            <span style="margin-left: 0.35rem;"><?php echo e($license->license_type); ?></span>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo e(route('vendors.show', $license->vendor)); ?>" style="color: var(--text-muted); font-weight: 500;">
                            <?php echo e($license->vendor->name); ?>

                        </a>
                    </td>
                    <td>
                        <?php if($license->license_key): ?>
                            <code class="license-key-tag"><?php echo e(Str::limit($license->license_key, 18)); ?></code>
                        <?php else: ?>
                            <span style="color: var(--text-dim); font-size: 0.8rem;">Auto-provisioned</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="seat-meter">
                            <div class="seat-meter-info">
                                <span><strong><?php echo e($assignedCount); ?></strong> of <?php echo e($license->total_seats); ?></span>
                                <span><?php echo e($utilization); ?>%</span>
                            </div>
                            <div class="seat-meter-bar">
                                <div class="seat-meter-fill <?php echo e($utilization >= 90 ? 'warning' : 'normal'); ?>" style="width: <?php echo e(min(100, $utilization)); ?>%;"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-cell-main">$<?php echo e(number_format($license->cost_per_seat, 2)); ?> <span style="font-size: 0.75rem; color: var(--text-dim); font-weight: 400;">/ seat</span></div>
                        <div class="table-cell-sub"><?php echo e(ucfirst($license->billing_cycle)); ?></div>
                    </td>
                    <td>
                        <?php if($license->expiration_date): ?>
                            <div style="font-weight: 500; color: <?php echo e($license->isExpired() ? '#dc2626' : ($license->isExpiringSoon() ? '#d97706' : 'var(--text-muted)')); ?>;">
                                <?php echo e($license->expiration_date->format('M d, Y')); ?>

                            </div>
                            <div class="table-cell-sub">
                                <?php if($license->isExpired()): ?>
                                    Expired <?php echo e($license->expiration_date->diffForHumans()); ?>

                                <?php else: ?>
                                    <?php echo e($license->expiration_date->diffInDays(now())); ?> days left
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span style="color: var(--text-dim); font-size: 0.82rem;">Perpetual / Lifetime</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($license->status === 'active'): ?>
                            <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                        <?php elseif($license->status === 'expiring_soon'): ?>
                            <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring</span>
                        <?php elseif($license->status === 'expired'): ?>
                            <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                        <?php else: ?>
                            <span class="badge badge-neutral"><span class="badge-dot"></span> <?php echo e(ucfirst($license->status)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                            <a href="<?php echo e(route('licenses.show', $license)); ?>" class="btn btn-secondary btn-icon" title="View Details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="<?php echo e(route('licenses.edit', $license)); ?>" class="btn btn-secondary btn-icon" title="Edit License">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            </div>
                            <div class="empty-state-title">No licenses found</div>
                            <div class="empty-state-desc">Try clearing the search filters or add a new software license to get started.</div>
                            <a href="<?php echo e(route('licenses.create')); ?>" class="btn btn-primary btn-sm">Add Software License</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    <?php echo e($licenses->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/licenses/index.blade.php ENDPATH**/ ?>