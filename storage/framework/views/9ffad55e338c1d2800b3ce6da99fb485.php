    
<?php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
    // $profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Project Reports')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Project Reports')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('All Project')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/custom/css/datatables.min.css')); ?>">

<style>
.table.dataTable.no-footer {
    border-bottom: none !important;
} 
.display-none {
    display: none !important;
}
.dataTables_length {
    margin: 20px;
}
.dataTables_filter {
    margin: 20px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="col-sm-12">
            <div class=" <?php echo e(isset($_GET['start_month'])?'show':''); ?>" >
                <div class="card card-body">
                    <div class="row filter-css ">
                        <div class="form-group col-2">
                            <select class="select2 form-select" name="all_users" id="all_users">
                                <option value="" class="px-4"><?php echo e(__('All Users')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <select class="select form-select" name="status" id="status">
                                    <option value="" class="px-4"><?php echo e(__('All Status')); ?></option>
                                    <option value="not_started"><?php echo e(__('Not Started')); ?></option>
                                    <option value="in_progress"><?php echo e(__('In Progress')); ?></option>
                                    <option value="on_hold"><?php echo e(__('On Hold')); ?></option>
                                    <option value="canceled"><?php echo e(__('Canceled')); ?></option>
                                    <option value="finished"><?php echo e(__('Finished')); ?></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">  
                                <div class="input-group date ">
                                <input class="form-control" type="date" id="start_date" name="start_date" value="" autocomplete="off" required="required"  placeholder="<?php echo e(__('Start Date')); ?>">
                            </div>
                        </div>
                            <div class="form-group col-md-3">
                            <div class="input-group date ">
                                    <input class="form-control" type="date" id="due_date" name="due_date" value="" autocomplete="off" required="required" placeholder="<?php echo e(__('End Date')); ?>">
                                </div>
                            </div>
                            <div class="action-btn bg-info mb-3 ms-2">
                            <div class="col-auto">
                                <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center btn-filter apply" data-bs-toggle="tooltip"
                                title="<?php echo e(__('Apply')); ?>"><i class="ti ti-search text-white"></i></button>
                            </div>
                        </div>
                
                        <div class="action-btn bg-danger mb-3 ms-2">
                            <div class="col-auto">
                                <a href="<?php echo e(route('project_report.index')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>" 
                                class="mx-3 btn btn-sm d-flex align-items-center"><i class="ti ti-trash-off text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="col-xl-12 mt-3 ">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="selection-datatable1">
                        <thead class="">
                            <tr>
                                <th><?php echo e(__('Projects')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('Due Date')); ?></th>
                                <th><?php echo e(__('Projects Members')); ?></th>
                                <th><?php echo e(__('Completion')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-page'); ?>
    <!-- <script>
        (function () {
        const d_week = new Datepicker(document.querySelector(''), {
            buttonClass: 'btn',
            todayBtn: true,
            clearBtn: true,
            format: 'yyyy-mm-dd',
        });
    })();
    </script> -->

   <script src="<?php echo e(asset('public/custom/js/jquery.dataTables.min.js')); ?>"></script>
   <script>

    var dataTableLang = {
        paginate: {previous: "<i class='fas fa-angle-left'>", next: "<i class='fas fa-angle-right'>"},
        lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
        zeroRecords: "<?php echo e(__('No data available in table.')); ?>",
        info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
        infoEmpty: "<?php echo e(__('Showing 0 to 0 of 0 entries')); ?>",
        infoFiltered: "<?php echo e(__('(filtered from _MAX_ total entries)')); ?>",
        search: "<?php echo e(__('Search:')); ?>",
        thousands: ",",
        loadingRecords: "<?php echo e(__('Loading...')); ?>",
        processing: "<?php echo e(__('Processing...')); ?>"
    }
    </script>
    <script type="text/javascript">
        $(".filter").click(function() {
            $("#show_filter").toggleClass('display-none');
        });
    </script>
    <script>

$(document).on('click', '#form-comment', function(e) {
            var comment = $.trim($("#form-comment input[name='comment']").val());
            var name = '<?php echo e(\Auth::user()->name); ?>';
            if (comment != '') {
                $.ajax({
                    url: $("#form-comment").data('action'),
                    data: {
                        comment: comment,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(data) {
                        data = JSON.parse(data);
                        console.log(data);
                        var html = '<div class="list-group-item">\n' +
                            '                            <div class="row">\n' +
                            '                                <div class="col ml-n2">\n' +
                            '                                    <a href="#!" class="d-block h6 mb-0">' +
                            name + '</a>\n' +
                            '                                    <div>\n' +
                            '                                        <small>' + data.comment +
                            '</small>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                                <div class="col-auto">\n' +
                            '                                    <a href="#" class="action-item  delete-comment" data-url="' +
                            data.deleteUrl + '">\n' +
                            '                                        <i class="ti ti-trash"></i>\n' +
                            '                                    </a>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>';


                        $("#comments").prepend(html);
                        $("#form-comment textarea[name='comment']").val('');
                        toastrs('Success', '<?php echo e(__('Comment successfully created.')); ?>', 'success');
                    },
                    error: function(data) {
                        toastrs('Error', '<?php echo e(__('Some thing is wrong.')); ?>', 'error');
                    }
                });
            } else {
                toastrs('Error', '<?php echo e(__('Please write comment.')); ?>', 'error');
            }
        });
        $(document).on("click", ".delete-comment", function() {
            if (confirm('Are You Sure ?')) {
                var comment = $(this).parent().parent().parent();


                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastrs('Success', '<?php echo e(__('Comment Deleted Successfully!')); ?>', 'success');
                        comment.remove();
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        if (data.message) {
                            toastrs('Error', data.message, 'error');
                        } else {
                            toastrs('Error', '<?php echo e(__('Some Thing Is Wrong!')); ?>', 'error');
                        }
                    }
                });
            }
        });
    </script>
    <script>
            $(document).ready(function() {

                    var table = $("#selection-datatable1").DataTable({
                    order: [],
                    select: {
                        style: "multi"
                    },
                    "language": dataTableLang,
                    drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }
                    });
                    $(document).on("click", ".btn-filter", function() {

                    getData();
                    });

                    function getData() {
                        table.clear().draw();
                        $("#selection-datatable1 tbody tr").html('<td colspan="11" class="text-center"> <?php echo e(__('Loading ...')); ?></td>');

                        var data = {
                            status: $("#status").val(),
                            start_date: $("#start_date").val(),
                            due_date  : $("#due_date").val(),
                            all_users :$("#all_users").val(),
                           
                        };
                        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                        $.ajax({
                            url: '<?php echo e(route('projects.ajax')); ?>',
                            type: 'POST',
                            data: data,
                            success: function(data) {  
                                table.rows.add(data.data).draw(true);
                               
                            },
                            error: function(data) {
                                toastrs('Info', data.error, 'error')
                            }
                        })
                    }

                getData();

            });
   </script>

<?php $__env->stopPush(); ?>





<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/project_report/index.blade.php ENDPATH**/ ?>