<?php echo e(Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT'))); ?>

<div class="form-group">
    <?php echo e(Form::label('name',__('Name'),['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))); ?>

</div>
<div class="form-group">
    <?php echo e(Form::label('email',__('Email'),['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))); ?>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'),array('class'=>'btn  btn-primary'))); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/user/edit.blade.php ENDPATH**/ ?>