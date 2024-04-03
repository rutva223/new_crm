<?php 
$plansettings = App\Models\Utility::plansettings();
?>
<div class="row">
<?php if(isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on'): ?>
 <div class="text-end">
     <a href="#" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['category'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate')); ?>" float-end>
        <span class="btn btn-primary btn-sm"> <i class="fas fa-robot">  <?php echo e(__('Generate With AI')); ?></span></i>
    </a>
 </div>
 <?php endif; ?>
 
    <?php echo e(Form::open(array('url' => 'category'))); ?>

    <div class="form-group">
        <?php echo e(Form::label('name', __('Name'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('type', __('Category Type'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('type',$types,null, array('class' => 'form-control multi-select','required'=>'required'))); ?>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
        <?php echo e(Form::submit(__('Create'),array('class'=>'btn  btn-primary'))); ?>

    </div>
    <?php echo e(Form::close()); ?>

</div>

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
  </script><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/category/create.blade.php ENDPATH**/ ?>