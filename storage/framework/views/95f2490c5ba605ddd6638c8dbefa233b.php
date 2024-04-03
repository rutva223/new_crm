<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Goal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Goal')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Goal')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type=='company'): ?>
    
    <a href="<?php echo e(route('goal.export')); ?>" class="btn btn-sm btn-primary btn-icon m-1" title="<?php echo e(__('Export goal CSV file')); ?>" data-bs-toggle="tooltip">
        <i class="ti ti-file-export"></i>
    </a>
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal"
        data-bs-target="#exampleModal" data-url="<?php echo e(route('goal.create')); ?>"
        data-bs-whatever="<?php echo e(__('Create New Goal')); ?>"> <span class="text-white"> 
            <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i></span>
    </a>
       
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3">
                <div class="card card-fluid">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col ml-md-n2">
                                <a href="#!" class="d-block h6 mb-0"><?php echo e($goal->name); ?></a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 mb-0"><?php echo e(\Auth::user()->dateFormat($goal->from)); ?></span>
                                <span class="d-block text-sm"><?php echo e(__('From')); ?></span>
                            </div>
                            <div class="col-auto text-right">
                                <span class="h6 mb-0"><?php echo e(\Auth::user()->dateFormat($goal->to)); ?></span>
                                <span class="d-block text-sm"><?php echo e(__('To')); ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="h6 mb-0"><?php echo e(\Auth::user()->priceFormat($goal->amount)); ?></span>
                                <span class="d-block text-sm"><?php echo e(__('Amount')); ?></span>
                            </div>
                            <div class="col-auto text-end">
                                <span class="h6 mb-0"><?php echo e($goal->display==1 ? __('Yes') :__('No')); ?></span>
                                <span class="d-block text-sm"><?php echo e(__('Display on dashboard')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="badge bg-primary fix_badge p-2 px-3 rounded" data-bs-toggle="tooltip" title="<?php echo e(__('Goal Type')); ?>"><?php echo e(__(\App\Models\Goal::$goalType[$goal->goal_type])); ?></span>
                            </div>
                            <div class="col-6 text-end">
                                <div class="actions">
                                    <div class="dropdown action-item" >
                                        <a href="#" class="action-item" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-url="<?php echo e(route('goal.edit',$goal->id)); ?>"
                                            data-bs-whatever="<?php echo e(__('Edit Goal')); ?>" >
                                            <i class="ti ti-edit"></i>  <?php echo e(__('Edit')); ?></a>
                                            

                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['goal.destroy', $goal->id]]); ?>

                                            <a href="#!" class=" show_confirm dropdown-item">
                                                <i class="ti ti-trash"></i><?php echo e(__('Delete')); ?>

                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="card text-center">
            <div class="pt-10 card-body">
                <span> <?php echo e(__('No Entry Found')); ?> </span> 
             </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/goal/index.blade.php ENDPATH**/ ?>