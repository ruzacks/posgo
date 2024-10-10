<?php $__env->startSection('content'); ?>
    <div class="col-xl-6">
        <div class="card-body">
            <div class="">
                <h2 class="mb-3 f-w-600"><?php echo e(__('Reset Password')); ?></h2>
            </div>
             <?php if(session('status')): ?>
                <div class="alert alert-primary">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            <p class="mb-4 text-muted"><?php echo e(__('We will send a link to reset your password')); ?></p>
            <form method="POST" action="<?php echo e(route('password.email')); ?>">
            <?php echo csrf_field(); ?>
                <div class="">
                    
                    <div class="form-group mb-3">
                        <label class="form-label"><?php echo e(__('Email')); ?></label>
                        <input id="email" type="email" placeholder="<?php echo e(__('Email')); ?>"
                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                        value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <small><?php echo e($message); ?></small>
                        </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
                     <div class="form-group ">
                         <?php echo NoCaptcha::display(); ?>

                         <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                         <span class="small text-danger" role="alert">
                             <strong><?php echo e($message); ?></strong>
                         </span>
                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <?php endif; ?>
                   
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block mt-2" id="login_button">Send Password Reset Link</button>
                    </div>
                    <?php if(Utility::getValByName('disable_signup_button')=='on'): ?>
                   
                    <div class="my-4 text-xs text-muted text-center">
                        <p><?php echo e(__("Back To")); ?> <a href="<?php echo e(route('login',$lang)); ?>"><?php echo e(__('Login')); ?></a></p>
                    </div>
                    <?php endif; ?> 
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>