<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'LicenseHub Pro'); ?> - Software License Management</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content Area -->
        <div class="main-wrapper">
            <!-- Top Navigation Bar -->
            <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Body Content -->
            <main class="content-body">
                <!-- Flash Messages -->
                <div class="alert-container">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><?php echo e(session('success')); ?></span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span><?php echo e(session('error')); ?></span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger" role="alert">
                            <div>
                                <strong style="display: block; margin-bottom: 0.25rem;">Please review the following errors:</strong>
                                <ul style="padding-left: 1.25rem; font-size: 0.85rem;">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    <?php endif; ?>
                </div>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <!-- jQuery & Form Validation -->
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/additional-methods.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/form-validation.js')); ?>"></script>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto dismiss success alerts after 6 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => successAlert.remove(), 400);
                }, 6000);
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\software-license-management\resources\views/layouts/app.blade.php ENDPATH**/ ?>