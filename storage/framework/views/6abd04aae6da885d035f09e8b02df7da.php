<?php echo e(Form::open(array('url' => 'invoice'))); ?>

<div class="row">
    <div class="form-group col-md-6">
        <?php echo e(Form::label('issue_date', __('Issue Date'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::date('issue_date', new \DateTime(), array('class' => 'form-control','required'=>'required'))); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('due_date', __('Due Date'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::date('due_date', new \DateTime(), array('class' => 'form-control','required'=>'required'))); ?>

    </div>
  
    <div class="form-group col-md-6">
            <label class="d-block col-form-label"><?php echo e(__('Type')); ?></label>
            <div class="row">
                <div class="form-check col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="form-check-input type" id="customRadio5" name="type" value="Product" checked="checked">
                        <label class="custom-control-label" for="customRadio5"><?php echo e(__('Product')); ?></label>
                    </div>
                </div>
                <div class="form-check col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="form-check-input type" id="customRadio6" name="type" value="Project">
                        <label class="custom-control-label" for="customRadio6"><?php echo e(__('Project')); ?></label>
                    </div>
                </div>
            </div>
    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('client', __('Client'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('client', $clients,null, array('class' => 'form-control multi-select','required'=>'required'))); ?>

    </div>

    <div class="form-group col-md-6 project-field d-none">
        <?php echo e(Form::label('project', __('Project'),['class' => 'col-form-label'])); ?>

        <select class="form-control  user" data-toggle="select" name="project" id="project">
        </select>
    </div>
    <div class="form-group col-md-6 project-field d-none">
        <?php echo e(Form::label('tax', __('Tax'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('tax[]', $taxes,null, array('class' => 'form-control multi-select','id'=>'choices-multiple','multiple'=>''))); ?>

    </div>
    
</div>

<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'),['class' => 'col-form-label'])); ?>

        <?php echo Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']); ?>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn  btn-primary'))); ?>

</div>

<?php echo e(Form::close()); ?>



<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
<script>
    if ($(".multi-select").length > 0) {
              $( $(".multi-select") ).each(function( index,element ) {
                  var id = $(element).attr('id');
                     var multipleCancelButton = new Choices(
                          '#'+id, {
                              removeItemButton: true,
                          }
                      );
              });
         }
  </script><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/invoice/create.blade.php ENDPATH**/ ?>