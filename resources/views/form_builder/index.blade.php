@extends('layouts.admin')
@push('script-page')
    <script>
        $(document).ready(function() {
            $('.cp_link').on('click', function() {
                var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('Success', '{{ __('Link Copy on Clipboard') }}', 'success')
            });
        });

        $(document).ready(function() {
            $('.iframe_link').on('click', function() {
                var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('Success', '{{ __('Link Copy on Clipboard') }}', 'success')
            });
        });
    </script>
@endpush
@section('page-title')
    {{ __('Form Builder') }}
@endsection
@section('title')
     {{ __('Form Builder') }}
@endsection
@section('breadcrumb')

    <li class="breadcrumb-item active" aria-current="page">{{ __('Form Builder') }}</li>
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true" data-size="md"
              data-url="{{ route('form_builder.create') }}"
            data-title="{{ __('Create New Form') }}" title="Create New Form"
            data-bs-original-title="{{ __('Create New Form') }}">
            <i class="fa fa-plus text-white"></i>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Response') }}</th>
                                @if (\Auth::user()->type == 'company')
                                    <th class="text-right" width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forms as $form)
                                <tr>
                                    <td>{{ $form->name }}</td>
                                    <td>
                                        {{ $form->response->count() }}
                                    </td>

                                    @if (\Auth::user()->type == 'company')
                                        <td class="text-right">

                                            <div class="action-btn bg-dark ms-2">
                                                <a href="#"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center iframe_link"
                                                    data-link="{{ url('/form/' . $form->code) }}"
                                                    data-title="{{ __('Click to copy iframe link') }}"
                                                    data-bs-toggle="tooltip" title="{{ __('Click to copy iframe link') }}"
                                                    data-bs-original-title="{{ __('Click to copy iframe link') }}"> <span
                                                        class="text-white"> <i class="fa fa-frame"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-success ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('form.field.bind', $form->id) }}"
                                                    data-title="{{ __('Convert into Lead Setting') }}"
                                                    title="{{ __('Convert into Lead Setting') }}"> <span
                                                        class="text-white"> <i data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Convert into Lead Setting') }}"
                                                            class="fa fa-arrows-left-right"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-secondary ms-2">
                                                <a href="{{ route('form_builder.show', $form->id) }}"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-title="{{ __('Form field') }}" data-bs-toggle="tooltip"
                                                    title="{{ __('Form field') }}"
                                                    data-bs-original-title="{{ __('Form field') }}"> <span
                                                        class="text-white"> <i class="fa fa-table"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
                                                    data-link="{{ url('/form/' . $form->code) }}"
                                                    data-bs-original-title="{{ __('Click to copy Form Builder') }}"
                                                    data-bs-toggle="tooltip"
                                                    title="{{ __('Click to copy Form Builder') }}"> <span
                                                        class="text-white"> <i class="fa fa-link"></i></span></a>
                                            </div>


                                            <div class="action-btn bg-warning ms-2">
                                                <a href="{{ route('form.response', $form->id) }}"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-title="{{ __('View Response') }}" data-bs-toggle="tooltip"
                                                    title="{{ __('View Response') }}"
                                                    data-bs-original-title="{{ __('View Response') }}"> <span
                                                        class="text-white"> <i class="fa fa-eye"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-ajax-popup="true"
                                                    data-url="{{ route('form_builder.edit', $form->id) }}"
                                                    data-title="{{ __('Edit Form') }}"
                                                    title="{{ __('Edit Form') }}"> <span class="text-white"> <i
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit Form') }}"
                                                            class="fa fa-edit"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['form_builder.destroy', $form->id]]) !!}
                                                <a href="#!"
                                                    class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                                    <i data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Delete Form') }}"
                                                        class="fa fa-trash text-white"></i>
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
