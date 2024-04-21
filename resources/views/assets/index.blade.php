@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Asset') }}
@endsection
@section('title')
     {{ __('Asset') }}
@endsection
@section('breadcrumb')
    {{ __('Asset') }}
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('account-assets.create') }}" data-title="{{ __('Create New Asset') }}">
            <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i>
        </a>
    @endif
@endsection
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class=" card-body table-border-style">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="display" id="example" >
                        <thead>
                            <tr>
                                <th> {{ __('Name') }}</th>
                                <th> {{ __('Purchase Date') }}</th>
                                <th> {{ __('Support Until') }}</th>
                                <th> {{ __('Amount') }}</th>
                                <th> {{ __('Description') }}</th>
                                @if (\Auth::user()->type == 'company')
                                    <th class="text-right">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr>
                                    <td class="font-style">{{ $asset->name }}</td>
                                    <td class="font-style">{{ \Auth::user()->dateFormat($asset->purchase_date) }}</td>
                                    <td class="font-style">{{ \Auth::user()->dateFormat($asset->supported_date) }}</td>
                                    <td class="font-style">{{ \Auth::user()->priceFormat($asset->amount) }}</td>
                                    <td class="font-style">{{ $asset->description }}</td>
                                    @if (\Auth::user()->type == 'company')
                                        <td class="text-right">
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('account-assets.edit', $asset->id) }}"
                                                    data-title="{{ __('Edit Asset') }}"> <span class="text-white"> <i
                                                            class="fa fa-edit" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit') }}"></i></span></a>

                                                {!! Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id]]) !!}
                                                <a href="#!"
                                                    class=" btn btn-danger shadow btn-sm sharp text-white js-sweetalert">
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
