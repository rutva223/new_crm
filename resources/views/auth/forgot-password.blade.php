@extends('layouts.auth')
@section('page-title')
    {{ __('Forget Password') }}
@endsection

@section('content')
    <div class="forms-container">
        <div class="signin-signup">
            {{ Form::open(['route' => 'password.email', 'method' => 'post', 'id' => 'loginForm', 'class' => 'sign-in-form']) }}
                @csrf
                <h2 class="title">Forgot Password</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter Your Email" />
                </div>
                <p class="social-text" style="margin-left: 200px;">
                    <a href="{{ route('login') }}">Sign in</a>
                </p>

                <form action="{{ route('password.request') }}" method="GET">
                    <input type="submit" value="Submit" class="btn solid" />
                </form>

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
            </div>
            <img src="img/log.svg" class="image" alt="" />
        </div>
    </div>
@endsection
