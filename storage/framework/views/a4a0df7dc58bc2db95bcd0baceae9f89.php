<?php
    // $profile=asset(Storage::url('uploads/avatar/'));
    $profile = \App\Models\Utility::get_file('uploads/avatar');
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Employee Log')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title'); ?>
     <?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>

    <li class="breadcrumb-item"><?php echo e(__('Employee Log')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-sm-12">
        <div class="mt-2 " id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['user.userlog'], 'method' => 'get', 'id' => 'user_userlog'])); ?>

                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-10">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('month', __('Month'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::month('month', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), ['class' => 'month-btn form-control'])); ?>

                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('users', __('Employee'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('users', $filteruser, isset($_GET['users']) ? $_GET['users'] : '', ['class' => 'form-control select'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <a href="#" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('user_userlog').submit(); return false;"
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                        data-original-title="<?php echo e(__('apply')); ?>">
                                        <span class="btn-inner--icon"><i class="fa fa-search"></i></span>
                                    </a>
                                    <a href="<?php echo e(route('user.userlog')); ?>" class="btn btn-sm btn-danger "
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                        data-original-title="<?php echo e(__('Reset')); ?>">
                                        <span class="btn-inner--icon"><i class="fa fa-trash-off text-white-off "></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Role')); ?></th>
                                <th><?php echo e(__('Last Login')); ?></th>
                                <th><?php echo e(__('Ip')); ?></th>
                                <th><?php echo e(__('Country')); ?></th>
                                <th><?php echo e(__('Device')); ?></th>
                                <th><?php echo e(__('OS')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $userdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $userdetail = json_decode($user->details);
                                ?>
                                <tr>
                                    <td><?php echo e($user->user_name); ?></td>
                                    <td>
                                        <span
                                            class="me-5 badge p-2 px-3 rounded bg-success status_badge"><?php echo e($user->user_type); ?></span>
                                    </td>
                                    <td><?php echo e(!empty($user->date) ? $user->date : '-'); ?></td>
                                    <td><?php echo e($user->ip); ?></td>
                                    <td><?php echo e(!empty($userdetail->country) ? $userdetail->country : '-'); ?></td>
                                    <td><?php echo e($userdetail->device_type); ?></td>
                                    <td><?php echo e($userdetail->os_name); ?></td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                data-ajax-popup="true"   data-size="md"
                                                data-url="<?php echo e(route('user.userlogview', [$user->id])); ?>"
                                                data-title="<?php echo e(__('View Employee Log')); ?>">
                                                <span class="text-white">
                                                    <i class="fa fa-eye" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('View')); ?>"></i>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-danger ms-2">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['user.userlogdestroy', $user->user_id]]); ?>

                                            <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                <i class="fa fa-trash text-white" data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\new_crm\resources\views/user/userlog.blade.php ENDPATH**/ ?>
