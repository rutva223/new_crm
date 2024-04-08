@extends('layouts.admin')

@section('page-title')
    {{ $formBuilder->name.__("'s Form Field") }}
@endsection
@section('title')
      {{ $formBuilder->name.__("'s Form Field") }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('form_builder.index')}}">{{__('Form Builder')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Add Field')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true" data-size="md"
          data-url="{{ route('form.field.create',$formBuilder->id) }}"
        data-title="{{__('Create New Field')}}"data-bs-toggle="tooltip" title="Create New Field"
        data-bs-original-title="{{__('Create New Field')}}">
            <i class="fa fa-plus text-white"></i>
        </a>
    @endif
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Type')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right" width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($formBuilder->form_field->count())
                            @foreach ($formBuilder->form_field as $field)
                                <tr>
                                    <td>{{ $field->name }}</td>
                                    <td>{{ ucfirst($field->type) }}</td>
                                    <td class="text-right">
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                              data-url="{{ route('form.field.edit',[$formBuilder->id,$field->id]) }}"
                                            data-title="{{__('Edit Field')}}" data-bs-toggle="tooltip" title="{{ __('Edit Field') }}" > <span class="text-white"> <i
                                                    class="fa fa-edit" data-bs-original-title="{{__('Edit Field')}}" data-bs-toggle="tooltip"></i></span></a>
                                        </div>

                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['form.field.destroy', $formBuilder->id, $field->id]]) !!}
                                            <a href="#!"
                                                class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                <i class="fa fa-trash text-white" data-bs-original-title="{{__('Delete Field')}}" data-bs-toggle="tooltip"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">{{__('No data available in table')}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

