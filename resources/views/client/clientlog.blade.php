@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    $profile = \App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{ __('Manage Client Log') }}
@endsection
@push('script-page')
@endpush
@section('title')
     {{ __('Client') }}
@endsection
@section('breadcrumb')
{{ __('Client Log') }}
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="mt-2 " id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['client.clientlog'], 'method' => 'get', 'id' => 'user_userlog']) }}
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-9">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                        {{ Form::month('month', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), ['class' => 'month-btn form-control']) }}
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('users', __('Client'), ['class' => 'form-label']) }}
                                        {{ Form::select('users', $filteruser, isset($_GET['users']) ? $_GET['users'] : '', ['class' => 'form-control select']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto my-1 mt-2 p-0 ">
                            <button type="submit" class=" btn btn-primary me-2"
                                data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fa-sharp fa-solid fa-filter me-2"></i>Filter</button>
                        </div>
                        <div class="col-auto my-1 p-0 mt-2 px-2">
                                        <a href="{{ route('client.clientlog') }}" data-bs-toggle="tooltip"
                                            title="{{ __('Reset') }}" class=" btn btn-danger light ">Remove Filter</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Last Login') }}</th>
                                <th>{{ __('Ip') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Device') }}</th>
                                <th>{{ __('OS') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userdetails as $user)
                                @php
                                    $userdetail = json_decode($user->details);
                                @endphp
                                <tr>
                                    <td>{{ $user->user_name }}</td>
                                    <td>
                                        <span
                                            class="me-5 badge p-2 px-3 rounded bg-success status_badge">{{ $user->user_type }}</span>
                                    </td>
                                    <td>{{ !empty($user->date) ? $user->date : '-' }}</td>
                                    <td>{{ $user->ip }}</td>
                                    <td>{{ !empty($userdetail->country) ? $userdetail->country : '-' }}</td>
                                    <td>{{ $userdetail->device_type }}</td>
                                    <td>{{ $userdetail->os_name }}</td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                data-ajax-popup="true"   data-size="md"
                                                data-url="{{ route('user.userlogview', [$user->id]) }}"
                                                data-title="{{ __('View Client Log') }}"> <span class="text-white">
                                                    <i class="fa fa-eye" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('View') }}"></i></span></a>
                                        </div>
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['user.userlogdestroy', $user->user_id]]) !!}
                                            <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                <i class="fa fa-trash text-white" data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Delete') }}"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
