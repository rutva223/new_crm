@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Trainer')}}
@endsection
@section('title')
     {{__('Trainer')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Trainer')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('trainer.create') }}"
    data-title="{{__('Create New Trainer')}}">
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
                                <th>{{__('Full Name')}}</th>
                                <th>{{__('Contact')}}</th>
                                <th>{{__('Email')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    <tr>
                                        <td>{{$trainer->firstname .' '.$trainer->lastname}}</td>
                                        <td>{{$trainer->contact}}</td>
                                        <td>{{$trainer->email}}</td>
                                        @if(\Auth::user()->type=='company')
                                            <td class="text-right">
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('trainer.show',$trainer->id) }}"
                                                        data-ajax-popup="true"   data-title="{{__('View Trainer Details')}}"> <span class="text-white"> <i
                                                            class="fa fa-eye" data-bs-toggle="tooltip" data-bs-original-title="{{ __('View') }}"></i></span></a>
                                                </div>

                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                                      data-url="{{ route('trainer.edit',$trainer->id) }}"
                                                    data-title="{{__('Edit Trainer')}}"> <span class="text-white"> <i
                                                            class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                                </div>

                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['trainer.destroy', $trainer->id]]) !!}
                                                    <a href="#!" class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                                        <i class="fa fa-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('delete') }}"></i>
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

