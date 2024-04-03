<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('click', '.code', function () {
            var type = $(this).attr('value');
            var ele = $('#'+type+'')
            if (type == 'manual') {
                $('#manual').removeClass('d-none');
                $('#manual').addClass('d-block');
                $('#auto').removeClass('d-block');
                $('#auto').addClass('d-none');
            } else {
                $('#auto').removeClass('d-none');
                $('#auto').addClass('d-block');
                $('#manual').removeClass('d-block');
                $('#manual').addClass('d-none');
            }
        });

        $(document).on('click', '#code-generate', function () {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Coupon')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Coupon')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Coupon')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="#" data-url="<?php echo e(route('coupon.create')); ?>" data-size="lg" data-bs-toggle="modal" data-bs-target="#exampleModal"
      data-bs-whatever="<?php echo e(__('Create Coupon')); ?>" data-title="<?php echo e(__('Create New Coupon')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-toggle="tooltip">
        <span class="btn-inner--icon"><i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i></span>
    </a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header card-body table-border-style">
            <h5></h5>
            <div class="table-responsive">
                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo e(__('Name')); ?></th>
                            <th scope="col"><?php echo e(__('Code')); ?></th>
                            <th scope="col"><?php echo e(__('Discount (%)')); ?></th>
                            <th scope="col"><?php echo e(__('Limit')); ?></th>
                            <th scope="col"><?php echo e(__('Used')); ?></th>
                            <th scope="col"><?php echo e(__('Action')); ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td class="budget"><?php echo e($coupon->name); ?> </td>
                                <td><?php echo e($coupon->code); ?></td>
                                <td>
                                    <?php echo e($coupon->discount); ?>

                                </td>
                                <td><?php echo e($coupon->limit); ?></td>
                                <td><?php echo e($coupon->used_coupon()); ?></td>
                                <td class="text-right">
                                    <div class="actions ml-3">
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="<?php echo e(route('coupon.show',$coupon->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('View')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#!"  data-size="lg" data-url="<?php echo e(route('coupon.edit',$coupon->id)); ?>"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal"  data-bs-whatever="<?php echo e(__('Edit Coupon')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                <i class="ti ti-edit text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-danger ms-2">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['coupon.destroy', $coupon->id]]); ?>

                                            <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>


                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/coupon/index.blade.php ENDPATH**/ ?>