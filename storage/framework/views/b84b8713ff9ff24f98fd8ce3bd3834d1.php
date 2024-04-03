<?php echo e(Form::open(['url' => 'employee'])); ?>

<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Name'])); ?>

    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('email', __('Email'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('email', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Email'])); ?>

    </div>
    <div class="col-md-5 mb-3 form-group mt-4">
        <label for="password_switch"><?php echo e(__('Login is enable')); ?></label>
        <div class="form-check form-switch custom-switch-v1 float-end">
            <input type="checkbox" name="password_switch" class="form-check-input input-primary pointer" value="on" id="password_switch">
            <label class="form-check-label" for="password_switch"></label>
        </div>
    </div>
    <div class="form-group col-md-12 ps_div d-none">
        <div class="form-group">
            <?php echo e(Form::label('password', __('Password'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Company Password'), 'minlength' => '6'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/employee/create.blade.php ENDPATH**/ ?>