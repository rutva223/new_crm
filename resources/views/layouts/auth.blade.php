<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>@yield('page-title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qQXrjv0Uk9xm4xSUYVK2u3rTshM/+j84DXofEW rk5jMAtGpNT5G3wQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" />
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/custom.min.js') }}"></script>

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
