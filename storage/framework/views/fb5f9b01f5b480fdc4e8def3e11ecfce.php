<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Forget Password')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="forms-container">
        <div class="signin-signup">
            <?php echo e(Form::open(['route' => 'password.email', 'method' => 'post', 'id' => 'loginForm', 'class' => 'sign-in-form'])); ?>

                <?php echo csrf_field(); ?>
                <h2 class="title">Forgot Password</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter Your Email" />
                </div>
                <p class="social-text" style="margin-left: 200px;">
                    <a href="<?php echo e(route('login')); ?>">Sign in</a>
                </p>

                <form action="<?php echo e(route('password.request')); ?>" method="GET">
                    <input type="submit" value="Submit" class="btn solid" />
                </form>

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

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\new_crm\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>