<?php
$settings = \App\Models\Utility::settings(1);
?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Referral')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Referral')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Referral')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('pre-purpose-css-page'); ?>
    <link rel="stylesheet"
        href="<?php echo e(Module::asset('LandingPage:Resources/assets/js/plugins/summernote/summernote-bs4.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/js/plugins/summernote/summernote-bs4.js')); ?>"></script>
    <script type="text/javascript">
        summernote()
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>



<?php if(Auth::user()->type == 'company'): ?>



        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card sticky-top" style="top:30px">
                            <div class="list-group list-group-flush" id="useradd-sidenav">

                                <a href="#guideline" data-target="guideline"
                                    class="list-group-item list-group-item-action border-0 menu-btn active"><?php echo e(__('GuideLine')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#ref_transaction" data-target="ref_transaction"
                                    class="list-group-item list-group-item-action border-0 menu-btn"><?php echo e(__('Referral Transaction')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#payout" data-target="payout"
                                    class="list-group-item list-group-item-action border-0 menu-btn"><?php echo e(__('Payout')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        
                        <div class="card menu-section" id="guideline">
                            <?php echo e(Form::model(null, ['route' => ['landingpage.store'], 'method' => 'POST'])); ?>

                            <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="mb-2"><?php echo e(__('GuideLine')); ?></h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="form-control p-3 border-2">
                                                <h4><b> Refer Rajodiya.com and Earn $20 perpaid signup ! </b>  </h4>

                                                    <?php echo e(!empty($referralProgram['guideline']) ? strip_tags($referralProgram['guideline']) : ''); ?>




                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-control p-3 border-2">


                                                        <h4 class="text-center"><?php echo e(__('Share Your Link')); ?></h4>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="#" class="btn btn-sm btn-light-primary w-100 cp_link"
                                                               data-link="<?php echo e(route('register', ['ref_id' => \Auth::user()->referral_code])); ?>"
                                                               data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                               data-bs-original-title="Click to copy business link">
                                                                <?php echo e(route('register', ['ref' => \Auth::user()->referral_code])); ?>


                                                                <i class="ti ti-copy"></i>

                                                                
                                                            </a>
                                                        </div>





                                            </div>
                                        </div>


                                    </div>
                                </div>


                            <?php echo e(Form::close()); ?>

                        </div>

                        <div class="card menu-section d-none" id="ref_transaction">

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



                    <?php echo e(Form::close()); ?>

                            </div>
                        </div>

                        

                        <div class="menu-section d-none" id="payout">
                            <div class="card">

                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                            <h5><?php echo e(__('Payout')); ?></h5>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 text-end">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon m-1"
                                                data-bs-toggle="modal"data-bs-target="#bonus" data-size="lg"
                                                data-bs-whatever="Amount PayOut">
                                                <span class="text-white">
                                                    <i class="ti ti-arrow-forward-up text-end" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Amount PayOut')); ?>"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="d-flex border p-3">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                                <div style="margin-left: 3%">
                                                    <small><?php echo e(__('Total')); ?></small>
                                                    <h5><?php echo e(__('Commission Amount')); ?></h5>
                                                </div>
                                                <h4 class="pt-3" style="margin-left: auto">$ <?php echo e($totalCommission ?? ''); ?></h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex border p-3">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                                <div style="margin-left: 3%">
                                                    <small><?php echo e(__('Paid')); ?></small>
                                                    <h5><?php echo e(__('Commission Amount')); ?></h5>
                                                </div>
                                                <h4 class="pt-3" style="margin-left: auto"> $ <?php echo e($totalpaidCommission ?? ''); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <h5 class="mb-2"><?php echo e(__('Payout History')); ?></h5>
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
                                                        <th scope="col"><?php echo e(__('STATUS ')); ?></th>
                                                        <th scope="col"><?php echo e(__('REQUEST AMOUNT')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $paidCommission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td class="budget"><?php echo e($transaction->id); ?> </td>
                                                            <td><?php echo e($transaction->company_name); ?></td>
                                                            <td>
                                                                <?php echo e($transaction->date); ?>

                                                            </td>
                                                            <td>
                                                            <?php if($transaction->status == "reject"): ?>
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded"><?php echo e($transaction->status); ?></span>
                                                        <?php elseif($transaction->status == ""): ?>
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">Pending..</span>
                                                        <?php elseif($transaction->status == "accept"): ?>
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded"><?php echo e($transaction->status); ?></span>
                                                        <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e($transaction->amount); ?></td>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    <div class="modal fade " id="bonus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog moda">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel"><?php echo e(__('Send Request')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('payout.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group" id="site-name-div">
                            <label class="form-label"><?php echo e(__('Request Amount')); ?></label>
                            <input type="number" class="form-control" placeholder="<?php echo e(__('Enter Amount')); ?>"
                                name="amount" id="amount">

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn  btn-light"
                            data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button class="btn btn-primary me-2"><?php echo e(__('Create')); ?></button>
                    </div>
                </form>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/referral/company/index.blade.php ENDPATH**/ ?>