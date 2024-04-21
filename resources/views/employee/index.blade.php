@extends('layouts.admin')
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    // $profile=asset(Storage::url('uploads/avatar'));
@endphp
@push('script-page')
@endpush
@section('page-title')
    {{ __('Employee') }}
@endsection
@section('title')
     {{ __('Employee') }}
@endsection
@section('breadcrumb')
    {{ __('Employee') }}
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        <a href="{{ route('user.userlog') }}" class="btn btn-primary btn-sm {{ Request::segment(1) == 'user' }}"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Employee Logs History') }}">
            <i class="fa fa-user-check"></i>
        </a>
    @endif

    <a href="#" class="btn btn-sm btn-primary " data-ajax-popup="true"
        data-url="{{ route('employee.create') }}" data-title="{{ __('Create New Employee') }}">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="collapse {{ isset($_GET['department']) ? 'show' : '' }}" id="collapseExample">
                <div class="card card-body">
                    {{ Form::open(['url' => 'employee', 'method' => 'get']) }}
                    <div class="row filter-css">
                        <div class="col-md-2">
                            {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', [
                                'class' => 'form-control',
                                'data-toggle' => 'select',
                            ]) }}
                        </div>
                        <div class="col-md-2">
                            {{ Form::select('designation', $designation, isset($_GET['designation']) ? $_GET['designation'] : '', [
                                'class' => 'form-control',
                                'data-toggle' => 'select',
                            ]) }}
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-xs btn-primary btn-icon-only rounded-circle"
                                data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('employee.index') }}" data-toggle="tooltip" data-title="{{ __('Reset') }}"
                                class="btn btn-xs btn-danger btn-icon-only rounded-circle"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="row">
            @forelse ($employees as $employee)
            <div class="col-xl-4 col-md-6">
                <div class="card contact_list ">
                    <div class="card-body">
                        <div class="user-content">
                            <div class="user-info">
                                <div class="user-img position-relative">
                                    <img  @if (!empty($employee->avatar)) src="{{ $profile . '/' . $employee->avatar }}" @else
                                avatar="{{ $employee->name }}" @endif class="avatar avatar-lg me-3" alt="">
                                </div>
                                <div class="user-details">
                                    <h5 class="mb-0">{{ $employee->name }}</h5>
                                    <p class="mb-0 text-primary">{{ $employee->email }}</p>
                                    <p class="mb-0">{{ $employee->created_at }}</p>
                                </div>
                            </div>
                            <div class="dropdown ">
                                <div class="btn sharp btn-primary tp-btn sharp-sm" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                </div>
                                @if ($employee->is_disable == 1)
                                    @if ($employee->is_active == 1 && (\Auth::user()->id == $employee->id || \Auth::user()->type == 'company'))
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('employee.edit', \Crypt::encrypt($employee->id)) }}" class="dropdown-item">
                                                <i class="ti ti-pencil"></i>
                                                <span>{{ __('Edit') }}</span>
                                            </a>
                                            <a href="{{ route('employee.show', \Crypt::encrypt($employee->id)) }}"
                                                class="dropdown-item" data-title="{{ __('View Employee') }}">
                                                <i class="fa fa-eye"></i> {{ __('View') }}</a>


                                            <a href="#"
                                                data-url="{{ route('employee.reset', \Crypt::encrypt($employee->id)) }}"
                                                data-ajax-popup="true"
                                                class="dropdown-item"
                                                data-title="{{ __('Reset Password') }}">
                                                <i class="fa fa-lock"> </i> {{ __('Reset Password') }}
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id]]) !!}
                                            <a href="#!" class=" js-sweetalert dropdown-item">
                                                <i class="fa fa-trash"></i>{{ __('Delete') }}
                                            </a>
                                            {!! Form::close() !!}
                                            @if ($employee->is_enable_login == 1)
                                                <a href="{{ route('employee.login', \Crypt::encrypt($employee->id)) }}"
                                                    class="dropdown-item">
                                                    <i class="fa fa-road-sign"></i>
                                                    <span class="text-danger"> {{ __('Login Disable') }}</span>
                                                </a>
                                            @elseif ($employee->is_enable_login == 0 && $employee->password == null)
                                                <a href="#"
                                                    data-url="{{ route('employee.reset', \Crypt::encrypt($employee->id)) }}"
                                                    data-ajax-popup="true" data-size="md"
                                                    class="dropdown-item login_enable"
                                                    data-title="{{ __('New Password') }}" class="dropdown-item">
                                                    <i class="fa fa-road-sign"></i>
                                                    <span class="text-success"> {{ __('Login Enable') }}</span>
                                                </a>
                                            @else
                                                <a href="{{ route('employee.login', \Crypt::encrypt($employee->id)) }}"
                                                    class="dropdown-item">
                                                    <i class="fa fa-road-sign"></i>
                                                    <span class="text-success"> {{ __('Login Enable') }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                @include('layouts.nodatafound')
            @endforelse
        </div>
    </div>

@endsection
@push('script-page')
    <script>
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.modal-body').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
@endpush
