
<!-- [ Main Content ] start -->
<div class="dash-container">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="m-b-10"> <?php echo $__env->yieldContent('title'); ?></h4>
                            </div>
                            <div class="col-auto">
                                    <?php echo $__env->yieldContent('action-btn'); ?>
                            </div>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"> </li>
                                <a href="<?php echo e(route('dashboard')); ?>"></a>
                                     <?php echo $__env->yieldContent('breadcrumb'); ?>
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
         <div class="row">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
<?php /**PATH C:\xampp\htdocs\new_crm\resources\views/partials/admin/content.blade.php ENDPATH**/ ?>