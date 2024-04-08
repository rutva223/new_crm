<?php echo e(Form::open(['route' => ['employee.import'], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

<div class="col-md-12 mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <?php echo e(Form::label('file', __('Download sample employee CSV file'), ['class' => 'form-control-label w-auto m-0'])); ?>

        <div>
            <a href="<?php echo e(asset(Storage::url('uploads/sample')) . '/sample-employee.csv'); ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-download"></i> <?php echo e(__('Download')); ?>

            </a>
        </div>
    </div>
</div>
<div class="col-md-12">
    <?php echo e(Form::label('file', __('Select CSV File'), ['class' => 'form-control-label'])); ?>

    <div class="choose-file form-group">
        <label for="file" class="form-control-label">
            <div></div>
            <input type="file" class="form-control" name="file" id="file" data-filename="upload_file"
                required>
        </label>
        <p class="upload_file"></p>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Upload'), ['class' => 'btn  btn-primary'])); ?>

</div>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\new_crm\resources\views/employee/import.blade.php ENDPATH**/ ?>
