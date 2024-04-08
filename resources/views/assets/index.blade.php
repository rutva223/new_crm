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

    <li class="breadcrumb-item active" aria-current="page">{{ __('Asset') }}</li>
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('asset.file.import') }}" data-title="{{ __('Import asset CSV file') }}">
            <i class="fa fa-file-import text-white" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Import') }}"></i>
        </a>

        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('account-assets.create') }}" data-title="{{ __('Create New Asset') }}">
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
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('account-assets.edit', $asset->id) }}"
                                                    data-title="{{ __('Edit Asset') }}"> <span class="text-white"> <i
                                                            class="fa fa-edit" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id]]) !!}
                                                <a href="#!"
                                                    class=" btn btn-sm d-inline-flex align-items-center show_confirm m-2">
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
