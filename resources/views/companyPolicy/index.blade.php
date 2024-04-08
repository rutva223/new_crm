@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Company Policy')}}
@endsection
@section('title')
     {{__('Company Policy')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Company Policy')}}</li>
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')

    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('company-policy.create') }}"
    data-title="{{__('Create New Company Policy')}}">
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
                                <th>{{__('Title')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Attachment')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companyPolicy as $policy)
                            @php
                              $policyPath=\App\Models\Utility::get_file('uploads/companyPolicy');
                                // $policyPath=asset(Storage::url('uploads/companyPolicy'));
                            @endphp
                            <tr>
                                <td>{{ $policy->title }}</td>
                                <td>{{ $policy->description }}</td>
                                <td>
                                    @if(!empty($policy->attachment))
                                        <a class="btn btn-sm btn-primary btn-icon rounded-pill" href="{{$policyPath.'/'.$policy->attachment}}" target="_blank" download="">
                                            <i data-bs-toggle="tooltip" data-bs-original-title="{{__('Download')}}" class="fa fa-download"></i>
                                        </a>
                                        <a class="btn btn-sm btn-secondary btn-icon rounded-pill" href="{{$policyPath.'/'.$policy->attachment}}" target="_blank" >
                                            <i data-bs-toggle="tooltip" data-bs-original-title="{{__('preview')}}" class="fa fa-crosshair"></i>
                                        </a>

                                    @else
                                        <p>-</p>
                                    @endif
                                </td>
                                @if(\Auth::user()->type=='company')
                                    <td class="text-right">
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                                                  data-url="{{ route('company-policy.edit',$policy->id) }}"
                                                data-title="{{__('Edit Company Policy')}}"> <i
                                                        class="fa fa-edit text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i>
                                            </a>
                                        </div>

                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['company-policy.destroy', $policy->id]]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm m-2">
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

