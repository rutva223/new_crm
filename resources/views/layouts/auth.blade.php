<<<<<<< Updated upstream
@php
    $settings = Utility::settings();
    $color = !empty($settings['color']) ? $settings['color'] : 'theme-3';


    if (isset($settings['color_flag']) && $settings['color_flag'] == 'true') {
        $themeColor = 'custom-color';
    } else {
        $themeColor = $color;
    }

    //$logo = asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_favicon = $settings['favicon'];
    $setting = App\Models\Utility::colorset();

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $settings['SITE_RTL'] = 'on';
    }
    $SITE_RTL = !empty($settings['SITE_RTL']) ? $settings['SITE_RTL'] : '';

    $logos = Utility::get_superadmin_logo();
    //meta tag
    // $meta = DB::table('settings')
    //     ->where('created_by', '=', 1)
    //     ->get();
    // foreach ($meta as $row) {
    //     $settings[$row->name] = $row->value;
    // }
@endphp

=======
>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>@yield('page-title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<<<<<<< Updated upstream
    <meta name="author" content="RR Solution">
    {{-- <meta name="description" content="CRMGo SaaS - Projects, Accounting, Leads, Deals & HRM Tool"> --}}
    {{-- SEO Module --}}
    <meta name="keyword" content="{{ !empty($settings['meta_keyword']) ? $settings['meta_keyword'] : '' }}">
    <meta name="description" content="{{ !empty($settings['meta_description']) ? $settings['meta_description'] : '' }}">
    {{-- (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') --}}
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ !empty($settings['meta_keyword']) ? $settings['meta_keyword'] : '' }}">
    <meta property="og:description"
        content="{{ !empty($settings['meta_description']) ? $settings['meta_description'] : '' }}">
    <meta property="og:image"
        content="{{ asset('storage/meta/' . (isset($settings['meta_image']) && !empty($settings['meta_image']) ? $settings['meta_image'] : '')) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ !empty($settings['meta_keyword']) ? $settings['meta_keyword'] : '' }}">
    <meta property="twitter:description"
        content="{{ !empty($settings['meta_description']) ? $settings['meta_description'] : 'meta_image.png' }}">
    <meta property="twitter:image"
        content="{{ isset($settings['meta_image']) && !empty($settings['meta_image']) ? $settings['meta_image'] : '' }}">
    {{-- <link rel="icon" href="{{\App\Models\Utility::get_file('uploads/logo/favicon.png') }}" type="image" sizes="16x16"> --}}

    <link rel="icon"
        href="{{ $logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"type="image/x-icon" />
    {{-- <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon" /> --}}

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    @if($setting['cust_darklayout']=='on')
        @if(isset($SITE_RTL) && $SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css')}}" id="main-style-link">
        @endif
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css')}}">
    @else
        @if(isset($SITE_RTL) && $SITE_RTL == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css')}}" id="main-style-link">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link">
        @endif
    @endif
    @if(isset($SITE_RTL) && $SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/custom/auth/css/custom-auth-rtl.css')}}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('assets/custom/auth/css/custom-auth.css')}}" id="main-style-link">
    @endif
    @if($setting['cust_darklayout']=='on')
        <link rel="stylesheet" href="{{ asset('assets/custom/auth/css/custom-dark.css')}}" id="main-style-link">
    @endif

    @if(isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('public/custom_assets/css/custom.css') }}">

    <style type="text/css">
        img.navbar-brand-img {
            width: 245px;
            height: 61px;
        }
    </style>
     <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
    <style>
        :root {
            --color-customColor: <?= $color ?>;
        }
    </style>
=======
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qQXrjv0Uk9xm4xSUYVK2u3rTshM/+j84DXofEW rk5jMAtGpNT5G3wQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" />
>>>>>>> Stashed changes
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
