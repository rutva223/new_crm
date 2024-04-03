<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Referral Program')); ?></li>
<?php $__env->stopSection(); ?>

<?php
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href=" <?php echo e(Module::asset('LandingPage:Resources/assets/css/summernote/summernote-bs4.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<script src="<?php echo e(Module::asset('LandingPage:Resources/assets/js/plugins/summernote-bs4.js')); ?>" referrerpolicy="origin"></script>

<?php $__env->stopPush(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__(' Referral Program')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<?php if(Auth::user()->type == 'super admin'): ?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-3">
                <div class="card sticky-top" style="top:30px">
                    <div class="list-group list-group-flush" id="useradd-sidenav">

                        <a href="#transaction" data-target="transaction"
                            class="list-group-item list-group-item-action border-0 menu-btn active"><?php echo e(__('Transaction')); ?>

                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>

                        <a href="#payout_req" data-target="payout_req"
                            class="list-group-item list-group-item-action border-0 menu-btn"><?php echo e(__('Payout Request')); ?>

                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>

                        
                        <a href="#setting" data-target="setting"
                            class="list-group-item list-group-item-action border-0 menu-btn"><?php echo e(__('Settings')); ?>

                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card menu-section" id="transaction">
                    <?php echo e(Form::model(null, array('route' => array('landingpage.store'), 'method' => 'POST'))); ?>

                    <?php echo csrf_field(); ?>

                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-2"><?php echo e(__('Transaction')); ?></h5>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <table class="table" id="">
                                        <thead>
                                            <tr>
                                                <th scope="col"><?php echo e(__('#')); ?></th>
                                                <th scope="col"><?php echo e(__('COMPANY NAME')); ?></th>
                                                <th scope="col"><?php echo e(__('PLAN NAME')); ?></th>
                                                <th scope="col"><?php echo e(__('PLAN PRICE')); ?></th>
                                                <th scope="col"><?php echo e(__('COMMISSION (%)')); ?></th>
                                                <th scope="col"><?php echo e(__('COMMISSION AMOUNT')); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>

                                                    <td class="budget"><?php echo e($transaction->id); ?></td>
                                                        <td><?php echo e($transaction->company_name); ?> </td>
                                                    <td><?php echo e($transaction->plane_name); ?></td>
                                                    <td>
                                                        <?php echo e($transaction->plan_price); ?>

                                                    </td>
                                                    <td><?php echo e($transaction->commission); ?></td>
                                                    <td><?php echo e($transaction->commission_amount); ?></td>

                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>


                    <?php echo e(Form::close()); ?>

                </div>

                <div class="card menu-section d-none" id="payout_req">



                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-2"><?php echo e(__('Payout Request')); ?></h5>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <table class="table" id="">
                                        <thead>
                                            <tr>
                                                <th scope="col"><?php echo e(__('#')); ?></th>
                                                <th scope="col"><?php echo e(__('COMPANY NAME')); ?></th>
                                                <th scope="col"><?php echo e(__('REQUEST DATE')); ?></th>
                                                <th scope="col"><?php echo e(__('REQUEST AMOUNT')); ?></th>
                                                <th scope="col"><?php echo e(__('ACTION')); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payouts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($payouts->id); ?></td>
                                                    <td class="budget"><?php echo e($payouts->company_name); ?> </td>
                                                    <td><?php echo e($payouts->date); ?></td>
                                                    <td>
                                                        <?php echo e($payouts->amount); ?>

                                                    </td>

                                                    <td class="text-right">
                                                        <div class="actions ml-3">
                                                            <form action="<?php echo e(route('referral_store.status')); ?>" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <input type="hidden" name="id" value="<?php echo e($payouts->id); ?>">
                                                                <button type="submit" class="btn btn-sm btn-success" name="status" value="accept"><i class="ti ti-check" data-bs-toggle="tooltip"
                                                                    data-bs-original-title="<?php echo e(__('Accept')); ?>">
                                                                </i></button>

                                                                <button type="submit" class="btn btn-sm btn-danger" name="status" value="reject"><i class="ti ti-x" data-bs-toggle="tooltip"
                                                                    data-bs-original-title="<?php echo e(__('Reject')); ?>">
                                                                </i></button>
                                                            </form>
                                                        </div>

                                                    </td>

                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>



                </div>


                <div class="card menu-section d-none" id="setting">
                    <?php echo e(Form::model(null, array('route' => array('setting.store'), 'method' => 'POST'))); ?>

                        
                        <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="mb-2"><?php echo e(__('Settings')); ?></h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('Comission percentage (%)', __('Comission percentage (%)'), ['class' => 'form-label'])); ?>

                                                <?php echo e(Form::text('commission', $referralProgram ? $referralProgram->commission : '', ['class' => 'form-control', 'placeholder' => __(' Enter Comission percentage (%)')])); ?>


                                            </div>


                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('Minimum Theres hold Amount', __('Minimum Theres hold Amount'), ['class' => 'form-label'])); ?>

                                                <?php echo e(Form::text('holdamt', $referralProgram ? $referralProgram->hold_amount : '', ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

                                        </div>
                                    </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php echo e(Form::label('GuideLines', __('GuideLines'), ['class' => 'form-label'])); ?>


                                            <?php echo e(Form::textarea('guideline', $referralProgram ? $referralProgram->guideline : '', ['class' => 'summernote-simple form-control', 'placeholder' => __('Enter GuideLines')])); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-print-invoice btn-primary m-r-10" type="submit" ><?php echo e(__('Save Changes')); ?></button>
                                </div>

                        <?php echo e(Form::close()); ?>

                </div>


                
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('script-page'); ?>
<script>
    $(document).on('click', '.menu-btn', function() {
        var target = $(this).data('target');

        $('.menu-section').addClass('d-none'); // Hide all sections
        $('#' + target).removeClass('d-none'); // Show the targeted section
    });

    $(document).ready(function() {
        $('.menu-btn').click(function(e) {
            e.preventDefault();
            $('.menu-btn').removeClass('active');
            $(this).addClass('active');

            // Add this line to remove active class from non-active menu items
            $('.menu-btn').not(this).removeClass('active');
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var copyLinkButtons = document.querySelectorAll('.cp_link');
    copyLinkButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var link = this.getAttribute('data-link');

            // Create a temporary input element
            var input = document.createElement('input');
            input.setAttribute('value', link);
            document.body.appendChild(input);

            // Select and copy the link
            input.select();
            document.execCommand('copy');

            // Remove the temporary input element
            document.body.removeChild(input);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/referral/index.blade.php ENDPATH**/ ?>