@extends('layouts.auth')
@section('page-title')
    {{ __('Forget Password') }}
@endsection

@section('content')
    <div class="forms-container">
        <div class="signin-signup">
            {{ Form::open(['route' => 'password.update', 'method' => 'post', 'class' => 'sign-in-form']) }}
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <h2 class="title">Reset Password</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ $request->email }}" placeholder="Enter Your Email" readonly/>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password-input" class="form-control" placeholder="Enter Password">
                    <span class="show-pass eye" id="toggle-password">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" id="password-input" class="form-control"
                        placeholder="Enter Confirmation Password">
                        <span class="show-pass eye" id="toggle-password">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <input type="submit" value="Submit" class="btn solid" />
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
