<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Forget Password')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="forms-container">
        <div class="signin-signup">
            <?php echo e(Form::open(['route' => 'password.update', 'method' => 'post', 'class' => 'sign-in-form'])); ?>

                <?php echo csrf_field(); ?>
                <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">
                <h2 class="title">Reset Password</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="<?php echo e($request->email); ?>" placeholder="Enter Your Email" readonly/>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password-input" class="form-control" placeholder="Enter Password">
                    <span class="show-pass eye" id="toggle-password">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" id="password-input" class="form-control"
                        placeholder="Enter Confirmation Password">
                        <span class="show-pass eye" id="toggle-password">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <input type="submit" value="Submit" class="btn solid" />
            <?php echo Form::close(); ?>

        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>VABRANT RAJASTHAN</h3>
                <p>
                    Welcome to Vabrant Rajasthan website page.. Complete your Sign Up to website access
                </p>
            </div>
            <img src="img/log.svg" class="image" alt="" />
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\new_crm\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>