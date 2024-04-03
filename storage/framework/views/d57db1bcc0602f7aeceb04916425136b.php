<?php $__env->startPush('script-page'); ?>

<script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/custom_assets/js/jquery-ui.min.js')); ?>"></script>

<?php if(\Auth::user()->type=='company'): ?>
<script>
    $(function() {
        $(".sortable").sortable();
        $(".sortable").disableSelection();
        $(".sortable").sortable({
            stop: function() {
                var order = [];
                $(this).find('li').each(function(index, data) {
                    order[index] = $(data).attr('data-id');
                });

                $.ajax({
                    url: "<?php echo e(route('projectStage.order')); ?>"
                    , data: {
                        order: order
                        , _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    , type: 'POST'
                    , success: function(data) {

                    }
                    , error: function(data) {
                        data = data.responseJSON;
                        toastr('Error', data.error, 'error')
                    }
                })
            }
        });
    });

</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Project Task Stage')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Project Task Stage')); ?></h5>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Project Task Stage')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php if(\Auth::user()->type=='company'): ?>
<a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-url="<?php echo e(route('projectStage.create')); ?>" data-bs-whatever="<?php echo e(__('Create New Project Stage')); ?>"> <span class="text-white">
        <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i></span>
</a>


<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('filter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">

    <div class="card-body">
        <div class="tab-pane fade show" id="tab" role="tabpanel">
            <ul class="list-group sortable">
                <?php $__empty_1 = true; $__currentLoopData = $projectStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_stages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="d-flex align-items-center justify-content-between list-group-item" data-id="<?php echo e($project_stages->id); ?>">
                    <h6 class="mb-0">
                        <i class="me-3 ti ti-arrows-maximize " data-feather="move"></i>
                        <?php echo e($project_stages->name); ?>

                    </h6>
                    <?php if(\Auth::user()->type=='company'): ?>
                    <span class="float-end">
                        <div class="action-btn bg-info ms-2">
                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="<?php echo e(route('projectStage.edit',$project_stages->id)); ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Edit Project Stage')); ?>" data-size="md">
                                <i class="ti ti-edit text-white" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"></i>
                            </a>
                        </div>

                        <div class="action-btn bg-danger ms-2">
                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['projectStage.destroy', $project_stages->id]]); ?>

                            <a href="#" class="mx-3 btn btn-sm  align-items-center show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i class="ti ti-trash text-white"></i></a>
                            <?php echo Form::close(); ?>

                        </div>
                    </span>
                    <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-md-12 text-center">
                    <h4><?php echo e(__('No data available')); ?></h4>
                </div>
                <?php endif; ?>

            </ul>
        </div>
        <p class="text-muted mt-4"><strong><?php echo e(__('Note')); ?> : </strong><?php echo e(__('You can easily order change of project task stage using drag & drop.')); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/projectStage/index.blade.php ENDPATH**/ ?>