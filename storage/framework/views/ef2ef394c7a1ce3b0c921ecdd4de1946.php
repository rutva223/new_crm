<?php
    $users=\Auth::user();
     if(isset($users)){ 
    $currantLang = $users->currentLanguage();
     }
     $languages=\App\Models\Utility::languages();
    $footer_text=isset(\App\Models\Utility::settings()['footer_text']) ? \App\Models\Utility::settings()['footer_text'] : '';
    $header_text = (!empty(\App\Models\Utility::settings()['company_name'])) ? \App\Models\Utility::settings()['company_name'] : env('APP_NAME');
    $setting = App\Models\Utility::colorset();
    $SITE_RTL = isset($site_setting['SITE_RTL']) ? $site_setting['SITE_RTL'] : '';
    $color = isset($site_setting['color']) ? $site_setting['color'] : 'theme-3';
      
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($SITE_RTL == 'on'?'rtl':''); ?>">

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php echo $__env->make('partials.admin.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if($site_setting['cust_darklayout'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>"  id="style">
<?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="style">
<?php endif; ?>

<!-- <body class="application application-offset"> -->
<body class="<?php echo e($color); ?>">
<div class="container">
<div class="main-content position-relative">
    <nav class="navbar navbar-main navbar-expand-lg navbar-border n-top-header">
    <div class="container align-items-lg-center">
       <h4><?php echo e($header_text); ?></h4>
    </div>
    </nav>
    <div class="page-content">
        <?php echo $__env->make('partials.admin.invoice_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    </div>
</div>
</div>


<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<?php echo $__env->make('partials.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(Session::has('success')): ?>
    <script>
        toastrs('<?php echo e(__('Success')); ?>', '<?php echo session('success'); ?>', 'success');
    </script>
    <?php echo e(Session::forget('success')); ?>

<?php endif; ?>
<?php if(Session::has('error')): ?>
    <script>
        toastrs('<?php echo e(__('Error')); ?>', '<?php echo session('error'); ?>', 'error');
    </script>
    <?php echo e(Session::forget('error')); ?>

<?php endif; ?>


<?php
$settings = \App\Models\Utility::settings();
?>
​    <?php if($settings['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>


</body>
</html>




<?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/layouts/invoicepayheader.blade.php ENDPATH**/ ?>