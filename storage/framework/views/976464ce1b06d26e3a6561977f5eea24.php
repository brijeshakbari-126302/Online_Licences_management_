<?php $__env->startSection('title', 'Software Vendors'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Software Vendors & Publishers</h1>
        <p class="page-subtitle">Manage corporate software suppliers, vendor support portals, and contract representatives.</p>
    </div>
    <div class="page-actions">
        <a href="<?php echo e(route('vendors.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New Vendor
        </a>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="toolbar-card">
    <form action="<?php echo e(route('vendors.index')); ?>" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search vendor name or contact person..." value="<?php echo e($searchTerm); ?>">
        </div>

        <button type="submit" class="btn btn-secondary">Search</button>

        <?php if($searchTerm): ?>
            <a href="<?php echo e(route('vendors.index')); ?>" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Vendors Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Vendor / Publisher</th>
                <th>Primary Contact</th>
                <th>Contact Email & Phone</th>
                <th>Website & Support</th>
                <th>Active Licenses</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('vendors.show', $vendor)); ?>" class="table-cell-main">
                            <?php echo e($vendor->name); ?>

                        </a>
                        <?php if($vendor->notes): ?>
                            <div class="table-cell-sub"><?php echo e(Str::limit($vendor->notes, 40)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($vendor->contact_name): ?>
                            <div style="font-weight: 500; color: var(--text-main);"><?php echo e($vendor->contact_name); ?></div>
                        <?php else: ?>
                            <span style="color: var(--text-dim); font-size: 0.8rem;">Direct Organization</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($vendor->contact_email): ?>
                            <div><a href="mailto:<?php echo e($vendor->contact_email); ?>" style="color: var(--primary);"><?php echo e($vendor->contact_email); ?></a></div>
                        <?php endif; ?>
                        <?php if($vendor->contact_phone): ?>
                            <div class="table-cell-sub"><?php echo e($vendor->contact_phone); ?></div>
                        <?php endif; ?>
                        <?php if(!$vendor->contact_email && !$vendor->contact_phone): ?>
                            <span style="color: var(--text-dim); font-size: 0.8rem;">No contact listed</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <?php if($vendor->website): ?>
                                <a href="<?php echo e($vendor->website); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; padding: 0.25rem 0.55rem;">
                                    Website &nearr;
                                </a>
                            <?php endif; ?>
                            <?php if($vendor->support_url): ?>
                                <a href="<?php echo e($vendor->support_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; padding: 0.25rem 0.55rem; color: #0284c7;">
                                    Support &nearr;
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <?php echo e($vendor->licenses_count); ?> <?php echo e(Str::plural('License', $vendor->licenses_count)); ?>

                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                            <a href="<?php echo e(route('vendors.show', $vendor)); ?>" class="btn btn-secondary btn-icon" title="View Details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="<?php echo e(route('vendors.edit', $vendor)); ?>" class="btn btn-secondary btn-icon" title="Edit Vendor">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <div class="empty-state-title">No software vendors registered</div>
                            <div class="empty-state-desc">Add vendors like Microsoft, JetBrains, Adobe, or AWS to associate with software licenses.</div>
                            <a href="<?php echo e(route('vendors.create')); ?>" class="btn btn-primary btn-sm">Add First Vendor</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    <?php echo e($vendors->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/vendors/index.blade.php ENDPATH**/ ?>