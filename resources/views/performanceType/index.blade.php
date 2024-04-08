@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Performance Type')}}
@endsection
@section('title')
     {{__('Performance Type')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Performance Type')}}</li>
@endsection
@section('action-btn')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('performanceType.create') }}"
    data-title="{{__('Create New Performance Type')}}"> <span class="text-white">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i></span>
    </a>
        {{-- <a href="#" data-url="{{ route('performanceType.create') }}" data-size="md" data-ajax-popup="true" data-title="{{__('Create New Meeting')}}" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-toggle="tooltip">
            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
        </a>
  --}}
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
                                <th scope="col">{{__('Name')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th scope="col" class="text-end">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr class="font-style">
                                    <td>{{ $type->name }}</td>
                                    @if(\Auth::user()->type=='company')
                                        <td class="text-end">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                                      data-url="{{ route('performanceType.edit',$type->id) }}"
                                                    data-title="{{__('Edit Performance Type')}}"> <span class="text-white"> <i
                                                            class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['performanceType.destroy', $type->id]]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
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

