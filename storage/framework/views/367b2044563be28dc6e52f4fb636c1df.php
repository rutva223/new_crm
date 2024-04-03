<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Order')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Order')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Order')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
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
                                <th scope="col" class="sort" data-sort="name"> <?php echo e(__('Order Id')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Date')); ?></th>
                                <th scope="col" class="sort" data-sort="status"><?php echo e(__('Name')); ?></th>
                                <th scope="col"><?php echo e(__('Plan Name')); ?></th>
                                <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Price')); ?></th>
                                <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Payment Type')); ?></th>
                                <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Status')); ?></th>
                                <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Coupon')); ?></th>
                                <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Invoice')); ?></th>
                                <?php if(\Auth::user()->type == 'super admin'): ?>
                                    <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->order_id); ?></td>
                                    <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                    <td><?php echo e($order->user_name); ?></td>
                                    <td><?php echo e($order->plan_name); ?></td>
                                    <td><?php echo e(env('CURRENCY_SYMBOL') . $order->price); ?></td>
                                    <td><?php echo e($order->payment_type); ?></td>
                                    <td>
                                        <?php if($order->payment_status == 'succeeded' || $order->payment_status == 'success'): ?>
                                            
                                            <div class="badge fix_badge bg-success p-2 px-3 rounded">
                                                <?php echo e(ucfirst('success')); ?></div>
                                        <?php elseif($order->payment_status == 'Approve'): ?>
                                            <div class="badge fix_badge bg-success p-2 px-3 rounded">
                                                <?php echo e(ucfirst('Approve')); ?></div>
                                        <?php elseif($order->payment_status == 'Pending'): ?>
                                            <div class="badge fix_badge bg-warning p-2 px-3 rounded">
                                                <?php echo e($order->payment_status); ?></div>
                                        <?php else: ?>
                                            
                                            <div class="badge fix_badge bg-danger p-2 px-3 rounded">
                                                <?php echo e(ucfirst($order->payment_status)); ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e(!empty($order->total_coupon_used) ? (!empty($order->total_coupon_used->coupon_detail) ? $order->total_coupon_used->coupon_detail->code : '-') : '-'); ?>

                                    </td>

                                    <td class="Id">
                                        <?php if(!empty($order->receipt) && $order->payment_type == 'Bank Transfer'): ?>
                                            <a href="<?php echo e(asset('storage/payment_recipt/' . $order->receipt)); ?>"
                                                class="btn  btn-outline-primary" target="_blank"><i
                                                    class="fas fa-file-invoice"></i> <?php echo e(__('Invoice')); ?></a>
                                        <?php elseif($order->payment_type == 'STRIPE'): ?>
                                            <a href="<?php echo e($order->receipt); ?>" class="btn  btn-outline-primary"
                                                target="_blank"><i class="fas fa-file-invoice"></i> <?php echo e(__('Invoice')); ?></a>
                                        <?php elseif($order->payment_type == 'Manually Upgrade By Super Admin'): ?>
                                            <?php echo e($order->receipt); ?></a>
                                        <?php else: ?>
                                            <?php echo e(__('-')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <?php if(\Auth::user()->type == 'super admin'): ?>
                                        <td>
                                            <?php if($order->payment_type == 'Bank Transfer' && $order->payment_status == 'Pending'): ?>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        data-url="<?php echo e(route('order.action', $order->id)); ?>"
                                                        data-bs-whatever="<?php echo e(__('Payment Status')); ?>"> <span
                                                            class="text-white">
                                                            <i class="ti ti-caret-right" data-bs-toggle="tooltip"
                                                                data-bs-original-title="<?php echo e(__('View')); ?>"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                                $user = App\Models\User::find($order->user_id);
                                            ?>
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id]]); ?>

                                                <a href="#!"
                                                    class="mx-3 btn d-inline-flex btn-sm d-flex wid-30 hei-30 rounded align-items-center show_confirm">
                                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                </a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                            <?php $__currentLoopData = $userOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($user->plan == $order->plan_id && $order->order_id == $userOrder->order_id && $order->is_refund == 0 && $user->plan != 1): ?>
                                                    <div class="badge bg-warning rounded p-2 px-3 ms-2">
                                                        <a href="<?php echo e(route('order.refund', [$order->id, $order->user_id])); ?>"
                                                            class="mx-3 align-items-center" data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('Delete')); ?>"
                                                            data-original-title="<?php echo e(__('Delete')); ?>">
                                                            <span class ="text-white"><?php echo e(__('Refund')); ?></span>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/order/index.blade.php ENDPATH**/ ?>