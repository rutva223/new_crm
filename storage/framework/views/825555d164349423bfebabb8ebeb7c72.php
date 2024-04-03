<?php
$profile = asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on("click", ".status", function() {
            var status = $(this).attr('data-id');
            var url = $(this).attr('data-url');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    status: status,
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#change-project-status').submit();
                    location.reload();
                }
            });
        });
    </script>
    <script>


      

        $(document).on('change', '#project', function() {
            var project_id = $(this).val();

            $.ajax({
                url: '<?php echo e(route('project.getMilestone')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    $('#milestone_id').empty();
                    $('#milestone_id').append('<option value="0"> -- </option>');
                    $.each(data, function(key, value) {
                        $('#milestone_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });

            $.ajax({
                url: '<?php echo e(route('project.getUser')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    $('#assign_to').empty();
                    $.each(data, function(key, value) {
                        $('#assign_to').append('<option value="' + key + '">' + value +
                            '</option>');
                    });

                }
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Task')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Task')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Task')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

    <a href="<?php echo e(route('task.calendar')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="Calendar View" >
        <i class="ti ti-calendar text-white"></i>
    </a>

    <a href="<?php echo e(route('project.all.task.gantt.chart')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="<?php echo e(__('Gantt Chart')); ?>">
        <i class="ti ti-chart-bar text-white"></i>
    </a>

    <a href="<?php echo e(route('project.all.task.kanban')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="<?php echo e(__('Task Kanban')); ?>">
        <i class="ti ti-layout-kanban text-white"></i>
    </a>
    <a href="#" data-size="lg" data-url="<?php echo e(route('project.task.create', 0)); ?>" data-bs-toggle="modal" data-bs-whatever="<?php echo e(__('Create New Task')); ?>"
    data-bs-target="#exampleModal" title="<?php echo e(__('Create New Task')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
        <i class="ti ti-plus text-white" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="col-xl-12">
    <div class=" <?php echo e(isset($_GET['status']) ? 'show' : ''); ?>" >
        <div class="card card-body">
            <?php echo e(Form::open([ 'method' => 'get'])); ?>

            <div class="row filter-css">
                <?php if(\Auth::user()->type == 'company'): ?>
                    <div class="col-md-3">
                        <?php echo e(Form::select('project', $projectList, !empty($_GET['project']) ? $_GET['project'] : '', ['class' => 'form-control','data-toggle' => 'select'])); ?>

                    </div>
                <?php endif; ?>
                <div class="col-md-2">
                    <select class="form-control" data-toggle="select" name="status">
                        <option value=""><?php echo e(__('Select status')); ?></option>
                        <?php $__currentLoopData = $stageList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>"
                                <?php echo e(isset($_GET['status']) && $_GET['status'] == $k ? 'selected' : ''); ?>>
                                <?php echo e($val); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" data-toggle="select" name="priority">
                        <option value=""><?php echo e(__('Select priority')); ?></option>
                        <?php $__currentLoopData = $priority; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>"
                                <?php echo e(isset($_GET['priority']) && $_GET['priority'] == $val ? 'selected' : ''); ?>>
                                <?php echo e($val); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-auto">
                    <?php echo e(Form::date('due_date',isset($_GET['due_date']) ? $_GET['due_date'] : new \DateTime(),array('class'=>'form-control'))); ?>

                </div>
                <div class="action-btn bg-info ms-2 col-auto">
                    <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center"
                    data-bs-toggle="tooltip" data-title="<?php echo e(__('Apply')); ?>"><i
                            class="ti ti-search text-white"></i></button>
                </div>
                <div class="action-btn bg-danger ms-2 col-auto">
                    <a href="<?php echo e(route('project.all.task')); ?>" data-toggle="tooltip"
                        data-title="<?php echo e(__('Reset')); ?>"
                        class="mx-3 btn btn-sm d-flex align-items-center"><i
                            class="ti ti-trash-off text-white"></i></a>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th scope="col" class="sort"><?php echo e(__('Project')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Title')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Start date')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Due date')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Assigned to')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Priority')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Status')); ?></th>
                                <th scope="col" class="sort text-end"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if (empty($_GET['status']) && empty($_GET['priority']) && empty($_GET['due_date'])) {
                                        $tasks = $project->tasks;
                                    } else {
                                        $tasks = $project->taskFilter($_GET['status'], $_GET['priority'], $_GET['due_date']);
                                    }
                                    
                                ?>

                                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td> <?php echo e($project->title); ?></td>
                                        <td><?php echo e($task->title); ?></td>
                                        <td> <?php echo e(\Auth::user()->dateFormat($task->start_date)); ?></td>
                                        <td> <?php echo e(\Auth::user()->dateFormat($task->due_date)); ?></td>
                                        <td> <?php echo e(!empty($task->taskUser) ? $task->taskUser->name : '-'); ?></td>
                                        <td>
                                            <?php if($task->priority == 'low'): ?>
                                                <div class="badge fix_badge bg-success p-2 px-3 rounded"> <?php echo e($task->priority); ?></div>
                                            <?php elseif($task->priority == 'medium'): ?>
                                                <div class="badge fix_badge bg-warning p-2 px-3 rounded"> <?php echo e($task->priority); ?></div>
                                            <?php elseif($task->priority == 'high'): ?>
                                                <div class="badge fix_badge bg-danger p-2 px-3 rounded"> <?php echo e($task->priority); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td> <?php echo e(!empty($task->stages) ? $task->stages->name : '-'); ?></td>
                                        <td class="text-end">
                                            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="#" data-size="lg" data-url="<?php echo e(route('project.task.show', $task->id)); ?>"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="<?php echo e(__('Task Detail')); ?>"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                                                    data-bs-whatever="<?php echo e(__('View Task')); ?>">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                            <?php endif; ?>
                                            <?php if(\Auth::user()->type == 'company'): ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" data-size="lg" data-url="<?php echo e(route('project.task.edit', $task->id)); ?>"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="<?php echo e(__('Edit Task')); ?>"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip" data-bs-whatever="<?php echo e(__('Edit Task')); ?>"
                                                    data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-edit text-white"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn bg-danger ms-2">
                                            <span class="">
                                                    <?php echo Form::open(['method' => 'POST', 'route' => ['project.task.destroy', $task->id],'id'=>'task-delete-form-'.$task->id]); ?>

                                                    <?php echo method_field('DELETE'); ?>
                                                    <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-toggle="tooltip" title='Delete'>
                                                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                </span>
                   
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/project/allTask.blade.php ENDPATH**/ ?>