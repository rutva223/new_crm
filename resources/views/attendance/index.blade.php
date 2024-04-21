@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Attendance') }}
@endsection
@section('title')
     {{ __('Attendance') }}
@endsection
@section('breadcrumb')
    {{ __('Attendance') }}
@endsection
@section('action-btn')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
        data-url="{{ route('attendance.file.import') }}" data-title="{{ __('Import attendance CSV file') }}">
        <span class="text-white"> <i class="fa fa-file-import " data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Import attendance CSV file') }}"></i> </span></a>
@endsection

@section('content')

    <div class="col-xl-12">
        <div class="row">
            <div class="col-12">
                <div class=" {{ isset($_GET['date']) ? 'show' : '' }}" id="collapseExample">
                    <div class="card card-body">
                        {{ Form::open(['url' => 'attendance', 'method' => 'get']) }}
                        <div class="row filter-css">
                            <div class="col-md-2 my-1">
                                {{ Form::date('date', isset($_GET['date']) ? $_GET['date'] : '', ['class' => 'form-control']) }}
                            </div>
                            @if (\Auth::user()->type == 'company')
                                <div class="col-md-3 my-1">
                                    {{ Form::select('employee', $employees, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control', 'data-toggle="select"']) }}
                                </div>
                            @endif
                                <div class="col-auto my-1 p-0 pt-1">
                                    <button type="submit" class=" btn btn-primary me-2"
                                        data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fa-sharp fa-solid fa-filter me-2"></i>Filter</button>
                                </div>
                                <div class="col-auto my-1 p-0 pt-1 px-2">
                                    <a href="{{ route('attendance.index') }}" data-bs-toggle="tooltip"
                                        title="{{ __('Reset') }}" class=" btn btn-danger light ">Remove Filter</a>
                                </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header  table-border-style">
                 @if (session('status'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                    <div class="card-body pb-4">
                        <div class="table-responsive">
                            <table class="display" id="example">
                                <thead>
                                    <tr>
                                        @if (\Auth::user()->type != 'employee')
                                            <th>{{ __('Employee') }}</th>
                                        @endif
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Clock In') }}</th>
                                        <th>{{ __('Clock Out') }}</th>
                                        <th>{{ __('Late') }}</th>
                                        <th>{{ __('Early Leaving') }}</th>
                                        <th>{{ __('Overtime') }}</th>
                                        @if (\Auth::user()->type == 'company')
                                            <th class="text-right">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            @if (\Auth::user()->type != 'employee')
                                                <td>{{ !empty($attendance->user) ? $attendance->user->name : '' }}</td>
                                            @endif
                                            <td>{{ \Auth::user()->dateFormat($attendance->date) }}</td>
                                            <td>{{ $attendance->status }}</td>
                                            <td>{{ $attendance->clock_in != '00:00:00' ? \Auth::user()->timeFormat($attendance->clock_in) : '00:00:00' }}
                                            </td>
                                            <td>{{ $attendance->clock_out != '00:00:00' ? \Auth::user()->timeFormat($attendance->clock_out) : '00:00:00' }}
                                            </td>
                                            <td>{{ $attendance->late }}</td>
                                            <td>{{ $attendance->early_leaving }}</td>
                                            <td>{{ $attendance->overtime }}</td>
                                            @if (\Auth::user()->type == 'company')
                                                <td class="text-right">
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-ajax-popup="true"
                                                            data-url="{{ route('attendance.edit', $attendance->id) }}"
                                                            data-title="{{ __('Edit Attendance') }}" title="Edit Attendance">
                                                            <span class="text-white"> <i class="fa fa-edit" data-bs-toggle="tooltip"
                                                                    data-bs-original-title="{{ __('Edit Attendance') }}"></i></span></a>
                                                    </div>

                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['attendance.destroy', $attendance->id]]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
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
    </div>

@endsection
