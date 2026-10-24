<?php $__env->startSection('title', 'Contact & IT Support'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="pub-hero" style="padding-bottom: 2rem;">
    <div class="pub-hero-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        Direct Customer & Enterprise Help Desk
    </div>

    <h1>
        We're Here to Help with Your <br>
        <span class="gradient-text">License Management</span>
    </h1>

    <p class="pub-hero-subtitle">
        Have questions about license tracking, vendor integration, or custom compliance reports? Our dedicated engineering and support team is ready to assist.
    </p>
</section>

<!-- Contact Content Grid -->
<section style="max-width: 1100px; margin: 0 auto; padding: 1rem 1.5rem 5rem;">
    <div class="contact-grid">
        <!-- Left Column: Contact Information -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="panel-card" style="padding: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem;">Support Headquarters</h3>

                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <!-- Email -->
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <div class="pub-feature-icon" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Direct Email</div>
                            <a href="mailto:support@licensehub.pro" style="font-weight: 600; color: var(--primary); font-size: 0.95rem;">support@licensehub.pro</a>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">Priority queue for license administrators</div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <div class="pub-feature-icon" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Direct Phone Line</div>
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">+1 (800) 555-0199</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">Toll-free across North America</div>
                        </div>
                    </div>

                    <!-- Hours -->
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <div class="pub-feature-icon" style="width: 40px; height: 40px; margin-bottom: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Operational Hours</div>
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">Monday – Friday: 9:00 AM – 6:00 PM EST</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">24/7 automated monitoring for license renewals</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Guarantee Badge -->
            <div class="panel-card" style="padding: 1.5rem; background: #ecfdf5; border-color: rgba(16, 185, 129, 0.3);">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--success);"></span>
                    <strong style="color: #065f46; font-size: 0.92rem;">Guaranteed Response SLA</strong>
                </div>
                <p style="font-size: 0.84rem; color: #065f46; margin-top: 0.35rem; line-height: 1.5;">
                    All inquiries submitted through this portal receive a human response within 2 business hours.
                </p>
            </div>
        </div>

        <!-- Right Column: Interactive Contact Form -->
        <div class="panel-card" style="padding: 2.25rem;">
            <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">Send Us an Inquiry</h3>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1.75rem;">Fill out the form below and our license specialists will get back to you promptly.</p>

            <form action="<?php echo e(route('contact.store')); ?>" method="POST" novalidate id="contact-form">
                <?php echo csrf_field(); ?>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Jane Doe" value="<?php echo e(old('name')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Corporate Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="jane@company.com" value="<?php echo e(old('email')); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Inquiry Category <span class="required">*</span></label>
                        <select name="category" class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="General Inquiry" <?php echo e(old('category') === 'General Inquiry' ? 'selected' : ''); ?>>General Product Inquiry</option>
                            <option value="Enterprise License Help" <?php echo e(old('category') === 'Enterprise License Help' ? 'selected' : ''); ?>>Enterprise License Help</option>
                            <option value="Vendor Integration" <?php echo e(old('category') === 'Vendor Integration' ? 'selected' : ''); ?>>Vendor Publisher Partnership</option>
                            <option value="Technical Support" <?php echo e(old('category') === 'Technical Support' ? 'selected' : ''); ?>>Technical Support</option>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subject <span class="required">*</span></label>
                        <input type="text" name="subject" class="form-input <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Brief summary of request" value="<?php echo e(old('subject')); ?>" required>
                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Detailed Message <span class="required">*</span></label>
                    <textarea name="message" rows="5" class="form-textarea <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="How can we assist your software license management team? Please include any relevant details..." required><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        Send Inquiry Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\software-license-management\resources\views/contact.blade.php ENDPATH**/ ?>