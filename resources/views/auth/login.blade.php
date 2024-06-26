@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection

@section('content')
    <div class="forms-container">
        <div class="signin-signup">
            {{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'sign-in-form']) }}
                @csrf
                <h2 class="title">Sign in</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter Your Email" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password-input" class="form-control" placeholder="Enter Your Password">
                    <span class="show-pass eye" id="toggle-password">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <p class="social-text" style="margin-left: 200px;">
                    <a href="{{ route('password.request')}}">Forgot Your Password</a>
                </p>

                <input type="submit" value="Login" class="btn solid" />
                <p class="social-text">Or Sign in with social platforms</p>
                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
            {!! Form::close() !!}

            {{ Form::open(['route' => 'register', 'method' => 'post', 'id' => 'loginForm', 'class' => 'sign-up-form']) }}
                @csrf
                <h2 class="title">Sign up</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
                <input type="submit" class="btn" value="Sign up" />
                <p class="social-text">Or Sign up with social platforms</p>
                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>VABRANT RAJASTHAN</h3>
                <p>
                    Welcome to Vabrant Rajasthan website page.. Complete your Sign Up to website access
                </p>
                <button class="btn transparent" id="sign-up-btn">
                    Sign up
                </button>
            </div>
            <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>VABRANT RAJASTHAN</h3>
                <p>
                    Welcome to Vabrant Rajasthan website page.. Complete your Sign In to website access
                </p>
                <button class="btn transparent" id="sign-in-btn">
                    Sign in
                </button>
            </div>
            <img src="img/register.svg" class="image" alt="" />
        </div>
    </div>
@endsection
