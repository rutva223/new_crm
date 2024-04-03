<?php
    $dir = asset(Storage::url('uploads/plan'));
    $admin_payment_setting = Utility::payment_settings();
?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Plan')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Plan')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type == 'super admin'): ?>
        <a href="#" data-url="<?php echo e(route('plan.create')); ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"
            data-bs-whatever="<?php echo e(__('Create New Plan')); ?>" data-size="lg" class="btn btn-sm btn-primary btn-icon m-1"
            data-bs-toggle="tooltip" title="<?php echo e(__('Create New Plan')); ?>">
            <span class="btn-inner--icon"><i class="ti ti-plus"></i></span>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
            <div class="card price-card price-1 wow animate__fadeInUp " data-wow-delay="0.2s"
                style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="card-body">
                    <span class="price-badge bg-primary"><?php echo e($plan->name); ?></span>
                    <?php if(\Auth::user()->type == 'super admin'): ?>
                        <div class="row d-flex">
                            <div class="col-6">
                                <?php if($plan->price > 0): ?>
                                    <div class="form-check form-switch custom-switch-v1 float-left">
                                        <input type="checkbox" name="plan_active"
                                            class="form-check-input input-primary is_active" value="1"
                                            data-id='<?php echo e($plan->id); ?>' data-name="<?php echo e(__('plan')); ?>"
                                            <?php echo e($plan->is_active == 1 ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="plan_active"></label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex col-6 flex-row-reverse m-0 p-0">
                                <div class="action-btn bg-primary ms-2">
                                    <a title="Edit Plan" data-size="lg" href="#"
                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                        data-url="<?php echo e(route('plan.edit', $plan->id)); ?>" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Edit Plan')); ?>"
                                        data-size="lg" data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="ti ti-edit text-white" data-bs-title="<?php echo e(__('Edit Plan')); ?>"
                                            data-bs-toggle="tooltip">
                                        </i>
                                    </a>
                                </div>
                                <?php if($plan->price > 0): ?>
                                    <div class="action-btn bg-danger ms-2">
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['plan.destroy', $plan->id]]); ?>

                                        <a href="#!" class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                            <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('delete')); ?>"></i>
                                        </a>
                                        <?php echo Form::close(); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id): ?>
                        <div class="d-flex flex-row-reverse m-0 p-0 ">
                            <span class="d-flex align-items-center ">
                                <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                <span class="ms-2"><?php echo e(__('Active')); ?></span>
                            </span>
                        </div>
                    <?php endif; ?>
                    <h3 class=" f-w-600 ">
                        <?php echo e(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?><small
                            class="text-sm"><?php echo e(\App\Models\Plan::$arrDuration[$plan->duration]); ?></small></h3>
                    <?php if($plan->description): ?>
                        <p class="mb-0">
                            <?php echo e($plan->description); ?><br />
                        </p>
                    <?php endif; ?>
                    <p class="mb-0">
                        <?php echo e(__('Free Trial Days:')); ?> <?php echo e($plan->trial_days ? $plan->trial_days : 0); ?><br />
                    </p>
                    <ul class="list-unstyled my-3">
                        <li>
                            <span class="theme-avtar">
                                <i class="text-primary ti ti-circle-plus"></i></span>
                            <?php echo e($plan->max_employee == '-1' ? __('Unlimited') : $plan->max_employee); ?> <?php echo e(__('Employee')); ?>

                        </li>
                        <li>
                            <span class="theme-avtar">
                                <i class="text-primary ti ti-circle-plus"></i></span>
                            <?php echo e($plan->max_client == '-1' ? __('Unlimited') : $plan->max_client); ?> <?php echo e(__('Clients')); ?>

                        </li>
                        <li>
                            <span class="theme-avtar">
                                <i class="text-primary ti ti-circle-plus"></i></span>
                            <?php echo e($plan->storage_limit ? $plan->storage_limit : 0); ?> <?php echo e(__('MB')); ?> <?php echo e(__('Storage')); ?>

                        </li>
                        <li>
                            <span class="theme-avtar">
                                <i class="text-primary ti ti-circle-plus"></i></span>
                            <?php if($plan->enable_chatgpt == 'on'): ?>
                                <?php echo e('Enable Chat GPT'); ?>

                            <?php else: ?>
                                <span style="color: red;"> <?php echo e(__('Disable Chat GPT')); ?> </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-12">
                            <?php if(\Auth::user()->type == 'company' && \Auth::user()->trial_plan == $plan->id && \Auth::user()->trial_expire_date): ?>
                                <p class="display-total-time mb-0">
                                    <?php echo e(__('Plan Trial Expired : ')); ?>

                                    <?php echo e(!empty(\Auth::user()->trial_expire_date) ? \Auth::user()->trial_expire_date : 'lifetime'); ?>

                                </p>
                            <?php endif; ?>
                            <?php if(
                                \Auth::user()->plan == $plan->id &&
                                    date('Y-m-d') < \Auth::user()->plan_expire_date &&
                                    \Auth::user()->trial_expire_date == null): ?>
                                <p class="server-plan font-weight-bold text-center mx-sm-5">
                                    <?php echo e(__('Expire on ')); ?>

                                    <?php echo e(date('d M Y', strtotime(\Auth::user()->plan_expire_date))); ?>

                                </p>
                            <?php elseif(
                                \Auth::user()->plan == $plan->id &&
                                    !empty(\Auth::user()->plan_expire_date) &&
                                    \Auth::user()->plan_expire_date < date('Y-m-d')): ?>
                                <p class="server-plan font-weight-bold text-center">
                                    <?php echo e(__('Expired')); ?>

                                </p>
                            <?php elseif(\Auth::user()->plan == $plan->id && !empty(\Auth::user()->plan_expire_date) && \Auth::user()->is_trial_done == 1): ?>
                                <p class="server-plan font-weight-bold text-center mx-sm-5">
                                    <?php echo e(__('Current Trial Expire on ') . date('d M Y', strtotime(\Auth::user()->plan_expire_date))); ?>

                                </p>
                            <?php else: ?>
                                <?php if($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin'): ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <?php if($plan->price > 0 && \Auth::user()->trial_plan == 0 && \Auth::user()->plan != $plan->id && $plan->trial == 1): ?>
                                            <a href="<?php echo e(route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                class="btn btn-lg btn-primary btn-icon m-1"><?php echo e(__('Free Trial')); ?></a>
                                        <?php endif; ?>
                                        <?php if($plan->price > 0): ?>
                                            <a href="<?php echo e(route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                class="btn btn-primary btn-icon m-1"><?php echo e(__('Subscribe')); ?></a>
                                        <?php endif; ?>
                                        <?php if($plan->id != 1 && \Auth::user()->plan != $plan->id && \Auth::user()->type == 'company'): ?>
                                            <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                                <a href="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                                    class="btn btn-primary btn-icon m-1"
                                                    data-title="<?php echo e(__('Send Request')); ?>" data-toggle="tooltip">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-arrow-forward-up"></i></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('request.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-icon m-1 btn-danger"
                                                    data-title="<?php echo e(__('Cancel Request')); ?>" data-toggle="tooltip">
                                                    <span class="btn-inner-icon"><i class="ti ti-trash"></i></span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on("click", ".is_active", function() {
            var id = $(this).attr('data-id');
            var is_active = ($(this).is(':checked')) ? $(this).val() : 0;
            $.ajax({
                url: '<?php echo e(route('plan.enable')); ?>',
                type: 'POST',
                data: {
                    "is_active": is_active,
                    "id": id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    if (data.success) {
                        toastrs('success', data.success);
                    } else {
                        toastrs('error', data.error);
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/plan/index.blade.php ENDPATH**/ ?>