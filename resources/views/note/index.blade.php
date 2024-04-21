@extends('layouts.admin')
@section('title')
    {{ __('Note') }}
@endsection
@section('breadcrumb')
    {{ __('Note') }}
@endsection
@section('action-btn')
    @if (Auth::user()->type == 'company' || Auth::user()->type == 'employee' || Auth::user()->type == 'client')
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('note.create') }}" data-title="{{ __('Create New Note') }}"> <span class="text-white">
                <i class="fa fa-plus text-white" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Create') }}"></i></span>
        </a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row notes-list">
                @forelse ($notes as $note)
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $note->title }}</h6>
                                    </div>
                                    <div class="text-right">
                                        <div class="actions">
                                            <div class="dropdown action-item">
                                                <div class="btn sharp btn-primary tp-btn sharp-sm" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item" data-ajax-popup="true"
                                                        data-url="{{ route('note.edit', $note->id) }}"
                                                        data-title="{{ __('Edit Note') }}">
                                                        <i class="fa fa-edit"> </i>{{ __('Edit') }}</a>

                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['note.destroy', $note->id]]) !!}
                                                        <a href="#!" class="js-sweetalert dropdown-item">
                                                            <i class="fa fa-trash"></i>{{ __('Delete') }}
                                                        </a>
                                                        {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-justify">{{ $note->description }}</p>
                                <div class="media align-items-center mt-2">
                                    <div class="media-body">
                                        <span class="h6 mb-0">{{ __('Created Date') }}</span><br>
                                        <span
                                            class="text-sm text-muted">{{ Auth::user()->dateFormat($note->created_at) }}</span>
                                    </div>
                                    @if (!empty($note->file))
                                        @php
                                            $x = pathinfo($note->file, PATHINFO_FILENAME);

                                            $extension = pathinfo($note->file, PATHINFO_EXTENSION);
                                            $result = str_replace(['#', "'", ';'], '', $note->file);
                                            $notes = \App\Models\Utility::get_file('uploads/notes/');
                                        @endphp
                                        <div class="media-body text-end">
                                            <a href="{{ route('note.receipt', [$x, "$extension"]) }}" data-toggle="tooltip"
                                                class="btn btn-sm btn-primary btn-icon rounded-pill">
                                                <i class="fa fa-download" data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Download') }}"></i>
                                            </a>
                                            <a href="{{ $notes . $x . '.' . $extension }}" data-toggle="tooltip" target="_blank"
                                                class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                                <i class="fa-solid fa-crosshairs" data-bs-toggle="tooltip"
                                                data-bs-original-title="{{ __('Preview') }}"></i>
                                            </a>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    @include('layouts.nodatafound')
                @endforelse
            </div>
        </div>
    </div>
@endsection
