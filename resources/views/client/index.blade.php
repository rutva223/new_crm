@extends('layouts.admin')
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    // $profile=asset(Storage::url('uploads/avatar'));
@endphp
@push('script-page')
@endpush
@section('page-title')
    {{ __('Client') }}
@endsection
@section('title')
     {{ __('Client') }}
@endsection
@section('breadcrumb')
    {{ __('Client') }}
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        <a href="{{ route('client.clientlog') }}" class="btn btn-primary btn-sm {{ Request::segment(1) == 'user' }}"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Client Logs History') }}"><i
                class="fa fa-user-check"></i>
        </a>
    @endif
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
        data-url="{{ route('client.create') }}" data-title="{{ __('Create New Client') }}"> <i
            class="fa fa-plus text-white" data-bs-toggle="tooltip"
            data-bs-original-title="{{ __('Create') }}"></i></span></a>
@endsection
@section('content')
    <div class="col-xl-12">
        <div class="row">
            @forelse ($clients as $client)
            <div class="col-xl-4 col-md-6">
                <div class="card contact_list ">
                    <div class="card-body">
                        <div class="user-content">
                            <div class="user-info">
                                <div class="user-img position-relative">
                                    <img  @if (!empty($client->avatar)) src="{{ $profile . '/' . $client->avatar }}" @else
                                avatar="{{ $client->name }}" @endif class="avatar avatar-lg me-3" alt="">
                                </div>
                                <div class="user-details">
                                    <h5 class="mb-0">{{ $client->name }}</h5>
                                    <p class="mb-0 text-primary">{{ $client->email }}</p>
                                    <p class="mb-0">{{ $client->created_at }}</p>
                                </div>
                            </div>
                            <div class="dropdown ">
                                <div class="btn sharp btn-primary tp-btn sharp-sm" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                </div>
                                @if ($client->is_disable == 1)
                                    @if ($client->is_active == 1 && (\Auth::user()->id == $client->id || \Auth::user()->type == 'company'))
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('client.edit', $client->id) }}" class="dropdown-item">
                                                <i class="ti ti-pencil"></i>
                                                <span>{{ __('Edit') }}</span>
                                            </a>
                                            <a href="{{ route('client.show', \Crypt::encrypt($client->id)) }}"
                                                class="dropdown-item" data-title="{{ __('View Client') }}">
                                                <i class="fa fa-eye"></i> {{ __('View') }}</a>
                                            <a href="#"
                                                data-url="{{ route('client.reset', \Crypt::encrypt($client->id)) }}"
                                                data-ajax-popup="true"
                                                class="dropdown-item"
                                                data-title="{{ __('Reset Password') }}">
                                                <i class="fa fa-lock"> </i> {{ __('Reset Password') }}
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' =>['client.destroy', $client->id]]) !!}
                                            <a href="#!" class=" js-sweetalert dropdown-item">
                                                <i class="fa fa-trash"></i>{{ __('Delete') }}
                                            </a>
                                            {!! Form::close() !!}
                                            @if ($client->is_enable_login == 1)
                                                <a href="{{ route('client.login', \Crypt::encrypt($client->id)) }}"
                                                    class="dropdown-item">
                                                    <i class="fa fa-road-sign"></i>
                                                    <span class="text-danger"> {{ __('Login Disable') }}</span>
                                                </a>
                                            @elseif ($client->is_enable_login == 0 && $client->password == null)
                                                <a href="#"
                                                    data-url="{{  route('client.reset', \Crypt::encrypt($client->id)) }}"
                                                    data-ajax-popup="true" data-size="md"
                                                    class="dropdown-item login_enable"
                                                    data-title="{{ __('New Password') }}" class="dropdown-item">
                                                    <i class="fa fa-road-sign"></i>
                                                    <span class="text-success"> {{ __('Login Enable') }}</span>
                                                </a>
                                            @else
                                                <a href="{{ route('client.login', \Crypt::encrypt($client->id)) }}"
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
