@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Designation')}}
@endsection
@section('title')
    {{__('Designation')}}
@endsection
@section('breadcrumb')
    {{__('Designation')}}
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('designation.create')}}"
    data-title="{{__('Create New Designation')}}"> <span class="text-white">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i></span>
    </a>

    @endif
@endsection
@section('filter')
@endsection
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Designation List</h4>
            </div>
            <div class="card-body">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="display" id="example">
                        <thead>
                            <tr>
                                <th scope="col">{{__('Designation')}}</th>
                                <th scope="col">{{__('Department')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th scope="col" class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designations as $designation)
                                <tr>
                                    <td>{{$designation->name}}</td>
                                    <td>{{!empty($designation->departments)?$designation->departments->name:''}}</td>
                                    @if(\Auth::user()->type=='company')
                                        <td class="">
                                            <div class="d-flex ">
                                                <a class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                    data-url="{{ route('designation.edit',$designation->id) }}"
                                                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                    title="" data-title="{{ __('Edit Designation') }}"
                                                    data-bs-original-title="{{ __('Edit') }}">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                {{ Form::open(['route' => ['designation.destroy', $designation->id], 'class' => 'm-0']) }}
                                                @method('DELETE')
                                                <a class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                    aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="delete-form-{{ $designation->id }}"><i
                                                        class="ti ti-trash text-white text-white"></i></a>
                                                {{ Form::close() }}
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

