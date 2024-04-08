@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Items')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Items')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Items')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="{{ route('item.index') }}" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="List View" >
        <i class="fa fa-list text-white"></i>

    </a>

    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('item.file.import') }}"
    data-title="{{__('Import item CSV file')}}"> <span class="text-white">
        <i class="fa fa-file-import" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Import') }}"></i></span>
    </a>

    <a href="{{route('item.export')}}" class="btn btn-sm btn-primary btn-icon m-1" data-title="{{__('Export item CSV file')}}"
     data-bs-toggle="tooltip" data-bs-original-title="{{__('Export')}}">
        <i class="fa fa-file-export"></i>
    </a>

    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('item.create') }}" data-size="lg"
    data-title="{{__('Create New Item')}}" > <span class="text-white">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i></span>
    </a>
    @endif
@endsection
@section('filter')

@endsection
@section('content')

    <div class="row">
        @foreach ($items as $item)
        <div class="col-md-3">
            <div class="card card-product">
                <div class="card-header border-0">
                    <h2 class="h6">
                        <a href="#">{{ $item->name}}</a><br>
                    </h2>
                    <span class="text-capitalize badge bg-{{$item->type=='product' ? 'success':'danger'}} p-1 px-3 rounded" data-bs-toggle="tooltip" title="{{__('Type')}}">
                            {{ $item->type }}
                    </span>
                </div>
                <div class="card-body item">
                    <div class="d-flex align-items-center ">
                        <span class="h6 mb-0" data-bs-toggle="tooltip" title="{{__('Category')}}">{{ !empty($item->categories)?$item->categories->name:'' }}</span>
                        <span class="badge rounded-pill bg-primary ms-2 ml-auto" data-bs-toggle="tooltip" title="{{__('SKU')}}"> {{ $item->sku }}</span>
                    </div>
                </div>
                <div class="pl-4 ms-4 pt-2 pb-2 border-top">
                    <div class="row">
                        <div class="col">
                            <span class="h6 mb-0" data-bs-toggle="tooltip" title="{{__('Purchase Price')}}">{{  \Auth::user()->priceFormat($item->purchase_price )}}</span>
                        </div>
                        <div class="col text-right">
                            <span class="h6 mb-0" data-bs-toggle="tooltip" title="{{__('Sale Price')}}">{{ \Auth::user()->priceFormat($item->sale_price) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="actions d-flex justify-content-between">
                        <a href="#" class="action-item">
                            @if(!empty($item->tax))
                                @foreach(explode(',', $item->tax) as $tax)
                                    <span class="badge rounded-pill bg-primary ms-1" data-bs-toggle="tooltip" title="{{__('Taxes')}}">
                                {{ !empty($getTaxData[$tax])?$getTaxData[$tax]['name']:'--'   }}
                                </span>
                                @endforeach

                            @else
                                -
                            @endif
                        </a>
                        <div class="action-btn bg-info ms-2">
                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true" data-size="lg"
                              data-url="{{ route('item.edit',$item->id) }}"
                            data-title="{{__('Edit Item   ')}}"> <span class="text-white"> <i
                                    class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                        </div>

                        <div class="action-btn bg-danger ms-2">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['item.destroy', $item->id]]) !!}
                            <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                <i class="fa fa-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Delete') }}"></i>
                            </a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>

@endsection

