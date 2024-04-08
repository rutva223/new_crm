@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Transfer')}}
@endsection
@section('title')
     {{__('Transfer')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Transfer')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('transfer.create') }}"
    data-title="{{__('Create New Transfer')}}">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i>
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
                                <th>{{__('Description')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfers as $transfer)
                            <tr>
                                @if(\Auth::user()->type=='company')
                                    <td>{{ !empty($transfer->employee)?$transfer->employee->name:'' }}</td>
                                @endif
                                <td>{{ !empty($transfer->department)?$transfer->department->name:'' }}</td>
                                <td>{{  \Auth::user()->dateFormat($transfer->transfer_date) }}</td>
                                <td>{{ $transfer->description }}</td>
                                @if(\Auth::user()->type=='company')
                                    <td class="text-right">
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                                  data-url="{{ route('transfer.edit',$transfer->id) }}"
                                                data-title="{{__('Edit Transfer')}}" > <span class="text-white"> <i
                                                        class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                            </div>
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $transfer->id]]) !!}
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

