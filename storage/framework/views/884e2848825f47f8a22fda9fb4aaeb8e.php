<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Items')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Items')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Items')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type=='company'): ?>
        <a href="<?php echo e(route('item.grid')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="<?php echo e(__('Grid View')); ?>" >
            <i class="ti ti-layout-grid text-white"></i>
        </a>

        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal"
        data-bs-target="#exampleModal" data-url="<?php echo e(route('item.file.import')); ?>"
        data-bs-whatever="<?php echo e(__('Import item CSV file')); ?>"> <span class="text-white">
            <i class="ti ti-file-import" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Import')); ?>"></i></span>
        </a>

        <a href="<?php echo e(route('item.export')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-title="<?php echo e(__('Export item CSV file')); ?>"
         data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Export')); ?>">
            <i class="ti ti-file-export"></i>
        </a>

        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal"
        data-bs-target="#exampleModal" data-url="<?php echo e(route('item.create')); ?>" data-size="lg"
        data-bs-whatever="<?php echo e(__('Create New Item')); ?>" > <span class="text-white">
            <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i></span>
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
                                <th scope="col"><?php echo e(__('Item')); ?></th>
                                <th scope="col"><?php echo e(__('Category')); ?></th>
                                <th scope="col"><?php echo e(__('Quantity')); ?></th>
                                <th scope="col"><?php echo e(__('Sale Price')); ?></th>
                                <th scope="col"><?php echo e(__('Purchase Price')); ?></th>
                                <th scope="col"><?php echo e(__('Tax')); ?></th>
                                <th scope="col"><?php echo e(__('Unit')); ?></th>
                                <th scope="col"><?php echo e(__('Description')); ?></th>
                                <?php if(\Auth::user()->type=='company'): ?>
                                    <th scope="col" class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="#" class="name h6 mb-0 text-sm"><?php echo e($item->name); ?></a><br>
                                                <span class="text-capitalize badge bg-<?php echo e($item->type=='product' ? 'success':'danger'); ?> primary p-1 px-3 rounded" data-bs-toggle="tooltip" title="<?php echo e(__('Type')); ?>">
                                                    <?php echo e($item->type); ?>

                                                </span>
                                                <span class="ml-2 badge bg-info p-1 px-3 rounded" data-bs-toggle="tooltip" title="<?php echo e(__('SKU')); ?>">
                                                <?php echo e($item->sku); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </th>
                                    <td><?php echo e(!empty($item->categories)?$item->categories->name:'--'); ?></td>
                                    <td><?php echo e(!empty($item->quantity)?$item->quantity:'--'); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($item->sale_price)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($item->purchase_price )); ?></td>
                                    <td>
                                        <?php if(!empty($item->tax)): ?>
                                            <?php $__currentLoopData = explode(',', $item->tax); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(!empty($getTaxData[$tax])?$getTaxData[$tax]['name']:'--'); ?> <br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(!empty($item->units)?$item->units->name:'--'); ?></td>
                                    <td><?php echo e($item->description); ?></td>
                                    <td class="text-right">
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-url="<?php echo e(route('item.edit',$item->id)); ?>" data-size="lg"
                                            data-bs-whatever="<?php echo e(__('Edit Item   ')); ?>"> <span class="text-white"> <i
                                                    class="ti ti-edit" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"></i></span></a>
                                        </div>

                                        <div class="action-btn bg-danger ms-2">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['item.destroy', $item->id]]); ?>

                                            <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                            </a>
                                            <?php echo Form::close(); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/item/index.blade.php ENDPATH**/ ?>