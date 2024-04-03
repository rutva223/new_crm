<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Budgets')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Budget Planner')); ?></h5>
</div>
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Budget Planner')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>

    <a href="<?php echo e(route('budget.create')); ?>" class="btn btn-sm btn-primary btn-icon m-1" 
    data-bs-whatever="<?php echo e(__('Create Budget Plannner')); ?>" data-bs-toggle="tooltip" 
    data-bs-original-title="<?php echo e(__('Create ')); ?>"> <span class="text-white"> 
        <i class="ti ti-plus text-white"></i></span>
    </a>

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
                                <th> <?php echo e(__('Name')); ?></th>
                                <th> <?php echo e(__('Year')); ?></th>
                                <th> <?php echo e(__('Budget Period')); ?></th>
                                <th> <?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="font-style"><?php echo e($budget->name); ?></td>
                                    <td class="font-style"><?php echo e($budget->from); ?></td>
                                    <td class="font-style"><?php echo e(__(\App\Models\Budget::$period[$budget->period])); ?></td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(route('budget.edit',Crypt::encrypt($budget->id))); ?>"
                                                     class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                data-bs-whatever="<?php echo e(__('Edit Budget Planner')); ?>" data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('Edit')); ?>"> <span class="text-white"> <i
                                                        class="ti ti-edit"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('budget.show',\Crypt::encrypt($budget->id))); ?>"
                                                     class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                data-bs-whatever="<?php echo e(__('View Budget Planner')); ?>" data-bs-toggle="tooltip" 
                                                data-bs-original-title="<?php echo e(__('View')); ?>"> <span class="text-white"> <i
                                                        class="ti ti-eye"></i></span></a>
                                            </div>


                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['budget.destroy', $budget->id]]); ?>

                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                </a>
                                                <?php echo Form::close(); ?>


                                            </div>
                                         </span>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/budget/index.blade.php ENDPATH**/ ?>