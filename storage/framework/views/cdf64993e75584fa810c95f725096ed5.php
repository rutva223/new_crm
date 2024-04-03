<?php echo e(Form::open(['url' => 'item'])); ?>

<?php
    $plansettings = App\Models\Utility::plansettings();
?>
<div class="row">
    <?php if(isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on'): ?>
        <div class="text-end">
            <a href="#" data-size="lg" data-ajax-popup-over="true" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo e(__('Generate')); ?>" data-url="<?php echo e(route('generate', ['items'])); ?>"
                data-title="<?php echo e(__('Generate')); ?>" float-end>
                <span class="btn btn-primary btn-sm"> <i class="fas fa-robot"> <?php echo e(__('Generate With AI')); ?></span></i>
            </a>
        </div>
    <?php endif; ?>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('name', __('Item Name'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Item Name')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('sku', __('SKU'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('sku', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Item SKU')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('sale_price', __('Sale Price'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('sale_price', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Sale Price')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('purchase_price', __('Purchase Price'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('purchase_price', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Purchase Price')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Quantity')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('unit', __('Unit'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('unit', $unit, null, ['class' => 'form-control multi-select'])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('tax', __('Tax'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('tax[]', $tax, null, ['class' => 'form-control multi-select', 'id' => 'choices-multiple', 'multiple' => ''])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('category', __('Category'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('category', $category, null, ['class' => 'form-control multi-select', 'placeholder' => __('Category')])); ?>

    </div>
    <div class="row"></div>

    <div class="form-group col-md-6">
        <div class="form-group">
            <label class="d-block"><?php echo e(__('Type')); ?></label>
            <div class="row">
                <div class="form-check col-md-6">
                    <input class="form-check-input" type="radio" name="type" value="product" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        <?php echo e(__('Product')); ?>

                    </label>
                </div>
                <div class="form-check col-md-6">
                    <input class="form-check-input" type="radio" name="type" value="service" id="flexCheckChecked"
                        checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        <?php echo e(__('Service')); ?>

                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

        <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']); ?>

    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn  btn-primary'])); ?>

</div>

<?php echo e(Form::close()); ?>





<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
<script>
    if ($(".multi-select").length > 0) {
        $($(".multi-select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>
<?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/item/create.blade.php ENDPATH**/ ?>