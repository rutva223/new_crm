@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Branch') }}
@endsection

@section('action-btn')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true" data-url="{{ route('branch.create') }}"
        data-title="{{ __('Create New Branch') }}">
        <span class="text-white">
            <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i></span>
    </a>
@endsection


@section('title')
    {{ __('Branch') }}
@endsection
@section('breadcrumb')
    {{ __('Branch') }}
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Branch List</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="display" id="example">
                        <thead>
                            <tr>
                                <th>{{ __('Branch') }}</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Status</th>
                                <th>Address</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr>
                                    <td>{{ !empty($branch->name) ? $branch->name : '' }}</td>
                                    <td>{{ !empty($branch->email) ? $branch->email : '' }}</td>
                                    <td>{{ !empty($branch->phone) ? $branch->phone : '' }}</td>
                                    <td>{{ !empty($branch->address) ? $branch->address : '' }}</td>
                                    <td>
                                        @if ($branch->status == 'active')
                                            <span
                                                class="badge bg-success p-2 px-3 rounded">{{ Str::ucfirst($branch->status) }}</span>
                                        @else
                                            <span
                                                class="badge bg-danger p-2 px-3 rounded">{{ Str::ucfirst($branch->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex ">

                                                <a class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                    data-url="{{ URL::to('branch/' . $branch->id . '/edit') }}"
                                                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                    title="" data-title="{{ __('Edit Branch') }}"
                                                    data-bs-original-title="{{ __('Edit') }}">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                {{ Form::open(['route' => ['branch.destroy', $branch->id], 'class' => 'm-0']) }}
                                                @method('DELETE')
                                                <a class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                    aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="delete-form-{{ $branch->id }}"><i
                                                        class="ti ti-trash text-white text-white"></i></a>
                                                {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
