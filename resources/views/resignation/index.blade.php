@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Resignation')}}
@endsection
@section('title')
     {{__('Resignation')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Resignation')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
          data-url="{{ route('resignation.create') }}"
        data-title="{{__('Create New Resignation')}}">
            <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{__('Create')}}"></i>
        </a>
    @endif
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
                                @if(\Auth::user()->type=='company')
                                    <th>{{__('Employee Name')}}</th>
                                @endif
                                <th>{{__('Department')}}</th>
                                <th>{{__('Transfer Date')}}</th>
                                <th>{{__('Reason')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resignations as $resignation)
                                <tr>
                                @if(\Auth::user()->type=='company')
                                        <td>{{ !empty($resignation->employee)?$resignation->employee->name:'' }}</td>
                                    @endif
                                    @php
                                    $employee = !empty($resignation->employee)? $resignation->employee :'' ;
                                    @endphp
                                    <td>{{ !empty($employee->employeeDetail) ? (!empty($employee->employeeDetail->departments) ? $employee->employeeDetail->departments->name : '-') : '-' }}</td>
                                    <td>{{  \Auth::user()->dateFormat($resignation->resignation_date) }}</td>
                                    <td>{{ $resignation->description }}</td>
                                    @if(\Auth::user()->type=='company')
                                        <td class="text-right">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                                      data-url="{{ route('resignation.edit',$resignation->id) }}"
                                                    data-title="{{__('Edit Resignation')}}"> <span class="text-white"> <i
                                                            class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                                </div>

                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['resignation.destroy', $resignation->id]]) !!}
                                                    <a href="#!" class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                                        <i class="fa fa-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="{{__('Delete')}}"></i>
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

