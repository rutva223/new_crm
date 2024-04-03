<?php
        $attachment=\App\Models\Utility::get_file('uploads/attachment/');
?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payment')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Payment')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Payment')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type=='company'): ?>
        <a href="#" data-size="lg" data-url="<?php echo e(route('payment.create')); ?>" data-bs-toggle="modal"
        data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Create Payment')); ?>"
         class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('filter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo e(__('Date')); ?></th>
                                <th scope="col"><?php echo e(__('Payment')); ?></th>
                                <?php if(\Auth::user()->type!='client'): ?>
                                    <th scope="col"><?php echo e(__('Client')); ?></th>
                                <?php endif; ?>
                                <th scope="col"><?php echo e(__('Reference')); ?></th>
                                <th scope="col"><?php echo e(__('Description')); ?></th>
                                <th scope="col"><?php echo e(__('Attachment')); ?></th>
                                <?php if(\Auth::user()->type=='company'): ?>
                                    <th scope="col" class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Auth::user()->dateFormat($payment->date)); ?></td>
                                    <!-- <td><?php echo e(Auth::user()->priceFormat($payment->amount)); ?></td> -->
                                    <td scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="#" class="name  mb-1 text-md"><?php echo e(Auth::user()->priceFormat($payment->amount)); ?></a><br>
                                                <span class="text-capitalize badge bg-info rounded-pill badge-sm">
                                                <?php echo e(!empty($payment->paymentMethods)?$payment->paymentMethods->name:'-'); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <?php if(\Auth::user()->type!='client'): ?>
                                        <td><?php echo e((!empty($payment->clients)?$payment->clients->name:'-')); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e($payment->reference); ?></td>
                                    <td><?php echo e($payment->description); ?></td>
                                    <td>
                                        <?php if(!empty($payment->receipt)): ?>
                                        <?php
                                            $x = pathinfo($payment->receipt, PATHINFO_FILENAME);
                                            $extension = pathinfo($payment->receipt, PATHINFO_EXTENSION);
                                            $result = str_replace(array("#", "'", ";"), '', $payment->receipt);
                                            
                                        ?>
                                        <a  href="<?php echo e(route('payment.receipt' , [$x,"$extension"])); ?>"  data-toggle="tooltip" class="btn btn-sm btn-primary btn-icon rounded-pill">
                                            <i class="ti ti-download" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Download')); ?>"></i>
                                        </a>
                                        <a  href="<?php echo e($attachment.$x.'.'.$extension); ?>"  target="_blank" data-toggle="tooltip" class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                            <i class="ti ti-crosshair" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Preview')); ?>"></i>
                                        </a>
                                        
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <td class="text-right">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#"  data-size="lg" data-url="<?php echo e(route('payment.edit',$payment->id)); ?>" 
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-whatever="<?php echo e(__('Edit ')); ?>">
                                                    <i class="ti ti-edit text-white"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn bg-danger ">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['payment.destroy', $payment->id]]); ?>

                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                </a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                           
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/payment/index.blade.php ENDPATH**/ ?>