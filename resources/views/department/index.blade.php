@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Department') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Department') }}
@endsection
@section('breadcrumb')

    <li class="breadcrumb-item active" aria-current="page">{{ __('Department') }}</li>
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('department.create') }}" data-title="{{ __('Create New Department') }}"> <span
                class="text-white">
                <i class="fa fa-plus text-white" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Create') }}"></i></span>
        </a>
    @endif
@endsection
@section('filter')
@endsection
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Branch') }}</th>
                                <th scope="col">{{ __('Department') }}</th>
                                @if (\Auth::user()->type == 'company')
                                    <th scope="col" class="text-right">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                 <tr class="font-style">
                                    <td>{{ !empty($department->branch_id)?$department->branch->name:'' }}</td>
                                    <td>{{ $department->name }} </td>
                                    @if (\Auth::user()->type == 'company')
                                        <td class="action text-right">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('department.edit', $department->id) }}"
                                                    data-title="{{ __('Edit Department') }}"> <span
                                                        class="text-white"> <i class="fa fa-edit" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['department.destroy', $department->id]]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                    <i class="fa fa-trash text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Delete') }}"></i>
                                                </a>
                                                {!! Form::close() !!}
                                            </div>
                                         </td>
                                      @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
