@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Training')}}
@endsection
@section('title')
     {{__('Training')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Training')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('training.create') }}"
    data-title="{{__('Create New Training')}}" data-size="lg"> <span class="text-white">
        <i class="fa fa-plus" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i></span>
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
                            <th>{{__('Training Type')}}</th>
                            <th>{{__('Employee')}}</th>
                            <th>{{__('Trainer')}}</th>
                            <th>{{__('Training Duration')}}</th>
                            <th>{{__('Cost')}}</th>
                            @if(\Auth::user()->type=='company')
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                    </thead>
                        <tbody>
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{ !empty($training->types)?$training->types->name:'' }} <br>

                                        @if($training->status == 0)
                                            <span class="text-warning">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 1)
                                            <span class="text-primary">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 2)
                                            <span class="text-success">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 3)
                                            <span class="text-info">{{ __($status[$training->status]) }}</span>
                                        @endif

                                    </td>
                                    <td>{{ !empty($training->employees)?$training->employees->name:'' }} </td>
                                    <td>{{ !empty($training->trainers)?$training->trainers->firstname:'' }}</td>
                                    <td>{{\Auth::user()->dateFormat($training->start_date) .' to '.\Auth::user()->dateFormat($training->end_date)}}</td>
                                    <td>{{\Auth::user()->priceFormat($training->training_cost)}}</td>
                                    @if(\Auth::user()->type=='company')
                                        <td class="text-right">
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="{{ route('training.show',\Crypt::encrypt($training->id)) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="#"
                                                data-title="{{__('View Training')}}"> <span class="text-white"> <i
                                                        class="fa fa-eye" data-bs-toggle="tooltip" data-bs-original-title="{{ __('View') }}"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true" data-size="lg"
                                                  data-url="{{ route('training.edit',$training->id) }}"
                                                data-title="{{__('Edit Training')}}" > <span class="text-white"> <i
                                                        class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['training.destroy', $training->id]]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm m-2">
                                                    <i class="fa fa-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Delete') }}"></i>
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

