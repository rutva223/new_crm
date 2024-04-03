<?php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
    // $profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startPush('script-page'); ?>
    <script>

        $(document).on('change', 'select[name=project]', function () {
            var project_id = $(this).val();
            getTask(project_id);
            getUser(project_id);
        });
        $(document).on('change', '#project_id', function () {
            var project_id = $(this).val();
            getProjectTask(project_id);
            getProjectUser(project_id);
        });

        function getTask(project_id) {
            $.ajax({
                url: '<?php echo e(route('project.getTask')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#task').empty();
                    $('#task').append('<option value=""><?php echo e(__('Select Task')); ?></option>');
                    $.each(data, function (key, value) {
                        $('#task').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        function getUser(project_id) {
            $.ajax({
                url: '<?php echo e(route('project.getUser')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {

                    $('#user').empty();
                    $('#user').append('<option value=""><?php echo e(__('Select User')); ?></option>');
                    $.each(data, function (key, value) {

                        $('#user').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        function getProjectTask(project_id) {
            $.ajax({
                url: '<?php echo e(route('project.getTask')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#task_id').empty();
                    $('#task_id').append('<option value="">--</option>');
                    $.each(data, function (key, value) {
                        $('#task_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        function getProjectUser(project_id) {
            $.ajax({
                url: '<?php echo e(route('project.getUser')); ?>',
                type: 'POST',
                data: {
                    "project_id": project_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#users').empty();
                    $.each(data, function (key, value) {
                        $('#users').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        $("select[name=project]").trigger("change");
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Timesheet')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Timesheet')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Timesheet')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="#" data-size="lg" data-url="<?php echo e(route('project.timesheet.create',0)); ?>" data-bs-toggle="modal"
    data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Create New Timesheet')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
        <i class="ti ti-plus" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <div class="col-xl-12">
            <div class=" <?php echo e(isset($_GET['project'])?'show':''); ?>" >
                <div class="card card-body">
                    <?php echo e(Form::open(array('route' => array('project.all.timesheet'),'method'=>'get'))); ?>

                    <div class="row filter-css">
                        <?php if(\Auth::user()->type=='employee' ||\Auth::user()->type=='company'): ?>
                            <div class="col-md-3">
                                <?php echo e(Form::select('project', $projectList,!empty($_GET['project'])?$_GET['project']:'', array('class' => 'form-control','data-toggle'=>'select'))); ?>

                            </div>
                        <?php endif; ?>
                        <div class="col-md-2">
                            <select class="form-control" data-toggle="select" name="task" id="task">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" data-toggle="select" name="user" id="user">
                            </select>
                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']:'',array('class'=>'form-control'))); ?>

                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']:'',array('class'=>'form-control'))); ?>

                        </div>
                        <div class="action-btn bg-info ms-2 col-auto mt-2">
                            <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center" data-toggle="tooltip" data-title="<?php echo e(__('Apply')); ?>"><i data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Apply')); ?>" class="ti ti-search text-white"></i></button>
                        </div>
                        <div class="action-btn bg-danger ms-2 col-auto mt-2">
                            <a href="<?php echo e(route('project.all.timesheet')); ?>" data-toggle="tooltip" data-title="<?php echo e(__('Reset')); ?>" class="mx-3 btn btn-sm d-flex align-items-center"><i data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Reset')); ?>" class="ti ti-trash-off text-white"></i></a>
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
                                <th scope="col" class="sort"><?php echo e(__('Task')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('User')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Start Date')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('Start Time')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('End Date')); ?></th>
                                <th scope="col" class="sort"><?php echo e(__('End Time')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $timesheet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e(!empty($log->projects)?$log->projects->title:''); ?></td>
                                    <td><?php echo e(!empty($log->tasks)?$log->tasks->title:'-'); ?></td>
                                    <td> <?php echo e(!empty($log->users)?$log->users->name:''); ?></td>
                                    <td> <?php echo e(\Auth::user()->dateFormat($log->start_date)); ?></td>
                                    <td> <?php echo e(\Auth::user()->timeFormat($log->start_time)); ?></td>
                                    <td> <?php echo e(($log->end_date!='0000-00-00') ?\Auth::user()->dateFormat($log->end_date):'-'); ?></td>
                                    <td> <?php echo e(($log->end_date!='0000-00-00') ?\Auth::user()->timeFormat($log->end_time):'-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/project/allTimesheet.blade.php ENDPATH**/ ?>