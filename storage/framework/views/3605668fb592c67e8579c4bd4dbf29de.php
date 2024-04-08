<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title><?php echo $__env->yieldContent('page-title'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/auth/css/style.css')); ?>" />
</head>

<body>
    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="<?php echo e(asset('assets/js/custom.min.js')); ?>"></script>

    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>

    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');

        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.querySelector('.fa-eye-slash').style.display = 'none';
                togglePassword.querySelector('.fa-eye').style.display = 'block';
            } else {
                passwordInput.type = 'password';
                togglePassword.querySelector('.fa-eye-slash').style.display = 'block';
                togglePassword.querySelector('.fa-eye').style.display = 'none';
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\new_crm\resources\views/layouts/auth.blade.php ENDPATH**/ ?>