<?php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    // $profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('User')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('User')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('User')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="#" data-url="<?php echo e(route('user.create')); ?>" data-size="md" data-bs-whatever="<?php echo e(__('Create New User')); ?>"
        class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
        data-bs-whatever="<?php echo e(__('Create New User')); ?>">
        <i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
    </a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-sm-6">
                <div class="card hover-shadow-lg">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="text-end">
                                <div class="actions">
                                    <div class="dropdown action-item">
                                        <a href="#" class="action-item " data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a href="#" data-url="<?php echo e(route('user.edit', $user->id)); ?>"
                                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                data-bs-whatever="<?php echo e(__('Edit User')); ?>">
                                                <i class="ti ti-edit"> </i> <?php echo e(__('Edit')); ?></a>


                                            <a href="#" class="dropdown-item"
                                                data-url="<?php echo e(route('plan.upgrade', $user->id)); ?>" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Upgrade Plan')); ?>">
                                                <i class="ti ti-trophy"></i> <?php echo e(__('Upgrade Plan')); ?></a>


                                            <a href="<?php echo e(route('login.with.company', $user->id)); ?>" class="dropdown-item"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('Login As Company')); ?>"> <i
                                                    class="ti ti-replace"></i> <?php echo e(__('Login As Company')); ?> </a>

                                            <a href="#"
                                                data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal" class="dropdown-item"
                                                data-bs-whatever="<?php echo e(__('Reset Password')); ?>">
                                                <i class="ti ti-lock"> </i> <?php echo e(__('Reset Password')); ?>

                                            </a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]); ?>

                                            <a href="#!" class=" show_confirm dropdown-item">
                                                <i class="ti ti-trash"></i><?php echo e(__('Delete')); ?>

                                            </a>
                                            <?php echo Form::close(); ?>

                                            <?php if($user->is_enable_login == 1): ?>
                                                <a href="<?php echo e(route('user.login', \Crypt::encrypt($user->id))); ?>"
                                                    class="dropdown-item">
                                                    <i class="ti ti-road-sign"></i>
                                                    <span class="text-danger"> <?php echo e(__('Login Disable')); ?></span>
                                                </a>
                                            <?php elseif($user->is_enable_login == 0 && $user->password == null): ?>
                                                <a href="#"
                                                    data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"
                                                    data-ajax-popup="true" data-size="md" class="dropdown-item login_enable"
                                                    data-title="<?php echo e(__('New Password')); ?>" class="dropdown-item">
                                                    <i class="ti ti-road-sign"></i>
                                                    <span class="text-success"> <?php echo e(__('Login Enable')); ?></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('user.login', \Crypt::encrypt($user->id))); ?>"
                                                    class="dropdown-item">
                                                    <i class="ti ti-road-sign"></i>
                                                    <span class="text-success"> <?php echo e(__('Login Enable')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="avatar-parent-child">


                                <img alt="<?php echo e($user->name); ?>"
                                    src="<?php echo e(!empty($user->avatar) ? $profile . $user->avatar : $profile . 'avatar.png'); ?>"
                                    class=" wid-30 rounded-circle avatar-lg" alt="image" width="100px">
                            </div>
                        </div>


                        <h5 class="h6 mt-4 mb-2"> <?php echo e($user->name); ?></h5>
                        <a href="#" class="d-block text-sm text-muted "> <?php echo e($user->email); ?></a>

                        <div class="col-12 text-center Id ">
                            <a href="#" data-url="<?php echo e(route('company.info', $user->id)); ?>" data-size="lg"
                                data-ajax-popup="true" class="btn btn-outline-primary mt-3"
                                data-title="<?php echo e(__('Company Info')); ?>"><?php echo e(__('AdminHub')); ?></a>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6 text-center">
                                <span class="d-block h4 mb-0"><?php echo e($user->countEmployees($user->id)); ?></span>
                                <span class="d-block text-sm text-muted"><?php echo e(__('Employees')); ?></span>
                            </div>
                            <div class="col-6 text-center">
                                <span class="d-block h4 mb-0"><?php echo e($user->countClients($user->id)); ?></span>
                                <span class="d-block text-sm text-muted"><?php echo e(__('Clients')); ?></span>
                            </div>
                            <div class="col-5 text-center pt-3">
                                <span
                                    class="d-block h5 mb-0"><?php echo e(!empty($user->currentPlan) ? $user->currentPlan->name : __('Free')); ?></span>
                                <span class="d-block text-sm text-muted"><?php echo e(__('Plan')); ?></span>
                            </div>
                            <div class="col-7 text-center pt-3">
                                <span
                                    class="d-block h5 mb-0"><?php echo e(!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : 'Lifetime'); ?></span>
                                <span class="d-block text-sm text-muted"><?php echo e(__('Plan Expired')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <a href="#" class="btn-addnew-project " data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-url="<?php echo e(route('user.create')); ?>" data-size="lg" data-bs-whatever="<?php echo e(__('Create New User')); ?>">
                <div class="bg-primary proj-add-icon">
                    <i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
                </div>
                <h6 class="mt-4 mb-2"><?php echo e(__('New User')); ?></h6>
                <p class="text-muted text-center"><?php echo e(__('Click here to add New User')); ?></p>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.modal-body').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/user/index.blade.php ENDPATH**/ ?>