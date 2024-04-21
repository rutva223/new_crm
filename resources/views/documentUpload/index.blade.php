

@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Document')}}
@endsection
@section('title')
    {{__('Document')}}
@endsection
@section('breadcrumb')
    {{__('Document')}}
@endsection
@section('action-btn')
    @if(\Auth::user()->type=='company')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
      data-url="{{ route('document-upload.create') }}"
    data-title="{{__('Create New Document')}}">
        <i class="fa fa-plus text-white" data-bs-toggle="tooltip"  data-bs-original-title="{{__('Create')}}"></i>
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
                                <th>{{__('Document')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                            @php
                                $documentPath=\App\Models\Utility::get_file('uploads/documentUpload');
                                // $documentPath=asset(Storage::url('uploads/documentUpload'));
                            @endphp
                            <tr>
                                <td>
                                    @if(!empty($document->document))
                                        <a class="btn btn-sm btn-primary btn-icon rounded-pill" href="{{$documentPath.'/'.$document->document}}" target="_blank" download="">
                                            <i class="fa fa-download" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Download') }}"></i>
                                        </a>
                                        <a class="btn btn-sm btn-secondary btn-icon rounded-pill" href="{{$documentPath.'/'.$document->document}}" target="_blank"  >
                                            <i class="fa fa-eye" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>
                                        </a>
                                    @else
                                        <p>-</p>
                                    @endif
                                </td>
                                <td>{{ $document->name }}</td>
                                <td>{{ $document->description }}</td>
                                @if(\Auth::user()->type=='company')
                                <td class="text-right">
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-primary shadow btn-sm sharp me-1 text-white" data-ajax-popup="true"
                                                data-url="{{ route('document-upload.edit',$document->id) }}"
                                            data-title="{{__('Edit Document')}}" data-bs-toggle="tooltip" title="Edit Document"
                                            data-bs-original-title="{{__('Edit Document')}}"> <span class="text-white"> <i
                                                    class="fa fa-edit" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"></i></span></a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['document-upload.destroy', $document->id]]) !!}
                                        <a href="#!" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert ">
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

