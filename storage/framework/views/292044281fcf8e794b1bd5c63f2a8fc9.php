<?php  
 $profile = \App\Models\Utility::get_file('uploads/avatar/');
 ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Invoice')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Invoice')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type=='company'): ?>

        <a href="<?php echo e(route('invoice.export')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-title="<?php echo e(__('Export invoice CSV file')); ?>" data-toggle="tooltip">
            <i class="ti ti-file-export"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Export')); ?>"></i>
        </a>
        <a href="<?php echo e(route('invoice.grid')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-layout-grid" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Grid View')); ?>"></i>
        </a>
        
        <a href="#" data-size="lg" data-url="<?php echo e(route('invoice.create')); ?>" data-bs-toggle="modal" 
        data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Create Invoice')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-plus"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
        </a>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', 'select[name=client]', function () {
            var client_id = $(this).val();
            getClientProject(client_id);
        });

        function getClientProject(client_id) {
            $.ajax({
                url: '<?php echo e(route('invoice.client.project')); ?>',
                type: 'POST',
                data: {
                    "client_id": client_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#project').empty();
                    $.each(data, function (key, value) {
                        $('#project').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        $(document).on('click', '.type', function () {
            var type = $(this).val();
            if (type == 'Project') {
                $('.project-field').removeClass('d-none')
                $('.project-field').addClass('d-block');
            } else {
                $('.project-field').addClass('d-none')
                $('.project-field').removeClass('d-block');
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
        <div class="col-xl-12">
            <div class=" <?php echo e(isset($_GET['status'])?'show':''); ?>" >
                <div class="card card-body">
                    <?php echo e(Form::open(array('url' => 'invoice','method'=>'get'))); ?>

                    <div class="row filter-css">
                        <div class="col-md-2">
                            <select class="form-control" data-toggle="select" name="status">
                                <option value=""><?php echo e(__('Select Status')); ?></option>
                                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k); ?>" <?php echo e(isset($_GET['status']) && $_GET['status'] == $k?'selected':''); ?>> <?php echo e($val); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']: new \DateTime() ,array('class'=>'form-control'))); ?>

                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']: new \DateTime() ,array('class'=>'form-control'))); ?>

                        </div>
                        <div class="action-btn bg-info ms-2">
                            <div class="col-auto">
                                <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center" data-bs-toggle="tooltip" 
                                data-title="<?php echo e(__('Apply')); ?>"><i class="ti ti-search text-white" ></i></button>
                            </div>
                        </div>
                        <div class="action-btn bg-danger ms-2">
                            <div class="col-auto">
                                <a href="<?php echo e(route('invoice.index')); ?>" data-toggle="tooltip" data-title="<?php echo e(__('Reset')); ?>" 
                                class="mx-3 btn btn-sm d-flex align-items-center"><i class="ti ti-trash text-white"></i></a>
                            </div>
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
                                <th scope="col"><?php echo e(__('Invoice')); ?></th>
                                <th scope="col"><?php echo e(__('Issue Date')); ?></th>
                                <th scope="col"><?php echo e(__('Due Date')); ?></th>
                                <th scope="col"><?php echo e(__('Total')); ?></th>
                                <th scope="col"><?php echo e(__('Due')); ?></th>
                                <th scope="col"><?php echo e(__('Status')); ?></th>
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                                    <th scope="col" class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div>
                                                <div class="user-group1">
                                                    <?php if(\Auth::user()->type!='client'): ?>
                                                        <img alt="" <?php if(!empty($invoice->clients) && !empty($invoice->clients->avatar)): ?> src="<?php echo e($profile.'/'.$invoice->clients->avatar); ?>" <?php else: ?>  avatar="<?php echo e(!empty($invoice->clients)?$invoice->clients->name:''); ?>" <?php endif; ?> data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(!empty($invoice->clients)?$invoice->clients->name:''); ?>" class="avatar  rounded-circle">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="media-body ms-2 pt-2">
                                                <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>" class="name h6 mb-0 text-sm text-primary"><?php echo e(\Auth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></a><br>
                                                <span class="text-capitalize badge bg-<?php echo e($invoice->type=='product' ? 'success':'danger'); ?> p-1 px-2 rounded" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Type')); ?>">
                                                    <?php echo e($invoice->type); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </th>

                                    <td><?php echo e(\Auth::user()->dateFormat($invoice->issue_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?></td>
                                    <td>
                                        <?php if($invoice->status == 0): ?>
                                            <span class="badge fix_badges bg-primary p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 1): ?>
                                            <span class="badge fix_badges bg-info p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 2): ?>
                                            <span class="badge fix_badges bg-secondary p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 3): ?>
                                            <span class="badge fix_badges bg-danger p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 4): ?>
                                            <span class="badge fix_badges bg-warning p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 5): ?>
                                            <span class="badge fix_badges bg-success p-2 px-3 rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                                        <td class="text-right">
                                            <div class="actions ml-3">
                                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-whatever="<?php echo e(__('Edit Invoice')); ?>"> <span class="text-white"> <i
                                                                class="ti ti-eye"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('View')); ?>"></i></span></a>
                                                    </div>
                                                <?php endif; ?>

                                                
                                                <?php if(\Auth::user()->type=='company'): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" data-url="<?php echo e(route('invoice.edit',$invoice->id)); ?>"
                                                    data-bs-whatever="<?php echo e(__('Edit Invoice')); ?>"> <span class="text-white"> <i
                                                            class="ti ti-edit"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"></i></span></a>
                                                </div>

                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['invoice.destroy', $invoice->id]]); ?>

                                                    <a href="#!" class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                                        <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                                    

                                                
                                                <?php endif; ?>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/invoice/index.blade.php ENDPATH**/ ?>