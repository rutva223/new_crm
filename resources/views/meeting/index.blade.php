@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Meeting') }}
@endsection
@section('title')
     {{ __('Meeting') }}
@endsection
@section('breadcrumb')
    {{ __('Meeting') }}
@endsection
@section('action-btn')
    <a href="{{ route('meeting.calendar') }}" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Calendar View"> <span class="text-white">
            <i class="fa fa-calendar text-white"></i></span>
    </a>

    @if (\Auth::user()->type == 'company'|| \Auth::user()->type == 'employee')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('meeting.create') }}" data-title="{{ __('Create New Meeting') }}"
            data-bs-placement="top">
            <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i>
        </a>
    @endif
@endsection

@section('content')
    <div class="col-xl-12">
        <div class=" {{ isset($_GET['department']) ? 'show' : '' }}">
            <div class="card card-body">
                {{ Form::open(['url' => 'meeting', 'method' => 'get']) }}
                <div class="row filter-css">

                    @if (\Auth::user()->type == 'company')
                        <div class="col-md-2">
                            {{ Form::select('department', $departments, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control', 'data-toggle' => 'select']) }}
                        </div>
                        <div class="col-md-2">
                            {{ Form::select('designation', $designations, isset($_GET['designation']) ? $_GET['designation'] : '', ['class' => 'form-control', 'data-toggle' => 'select']) }}
                        </div>
                    @endif

                    <div class="col-auto">
                        {{ Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : new \DateTime(), ['class' => 'form-control']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : new \DateTime(), ['class' => 'form-control']) }}
                    </div>
                    <div class="col-auto my-1 p-0 ">
                        <button type="submit" class=" btn btn-primary me-2"
                            data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fa-sharp fa-solid fa-filter me-2"></i>Filter</button>
                    </div>
                    <div class="col-auto my-1 p-0  px-2">
                        <a href="{{ route('meeting.index') }}" data-bs-toggle="tooltip"
                            title="{{ __('Reset') }}" class=" btn btn-danger light ">Remove Filter</a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="example" >
                        <thead>
                            <th>{{ __('title') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Time') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('Designation') }}</th>
                            @if (\Auth::user()->type == 'company')
                                <th class="text-right" width="200px">{{ __('Action') }}</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                    <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                    <td>{{ !empty($meeting->departments) ? $meeting->departments->name : 'All' }}</td>
                                    <td>{{ !empty($meeting->designations) ? $meeting->designations->name : 'All' }}</td>
                                    @if (\Auth::user()->type == 'company')
                                        <td class="text-right">
                                            <div class="d-flex">

                                                <a href="#" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('meeting.edit', $meeting->id) }}"
                                                    data-title="{{ __('Edit Meeting') }}" data-bs-placement="top"
                                                    title="Edit"> <span class="text-white"> <i class="fa fa-edit"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="
                                                            {{ __('Edit') }}">
                                                        </i>
                                                    </span>
                                                </a>

                                                {!! Form::open(['method' => 'DELETE', 'route' => ['meeting.destroy', $meeting->id]]) !!}
                                                <a href="#!"
                                                    class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert">
                                                    <i class="fa fa-trash text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Delete') }}">
                                                    </i>
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
