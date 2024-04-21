@extends('layouts.admin')
@push('after-scripts')
    <script>
        $(document).on('click', '.type', function() {
            var type = $(this).val();
            if (type == 'Employee') {
                $('.department').addClass('d-block');
                $('.department').removeClass('d-none')
            } else {
                $('.department').addClass('d-none')
                $('.department').removeClass('d-block');
            }
        });
    </script>
@endpush
@section('title')
    {{ __('Notice Board') }}
@endsection

@section('breadcrumb')
    {{ __('Notice Board') }}
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        {{-- <a href="{{ route('noticeBoard.grid') }}" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="fa fa-layout-grid text-white" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Grid VIew') }}"></i>
        </a> --}}

        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-ajax-popup="true"
            data-url="{{ route('noticeBoard.create') }}" data-title="{{ __('Create Notice Board') }}">
            <span class="text-white">
                <i class="fa fa-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}"></i>
            </span>
        </a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row notes-list">
                @forelse ($noticeBoards as $noticeBoard)
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $noticeBoard->heading }}</h6>
                                    </div>
                                    <div class="text-right">
                                        <div class="actions">
                                            <div class="dropdown action-item">
                                                <div class="btn sharp btn-primary tp-btn sharp-sm"
                                                    data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                        height="18px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <circle fill="#000000" cx="12" cy="5" r="2">
                                                            </circle>
                                                            <circle fill="#000000" cx="12" cy="12" r="2">
                                                            </circle>
                                                            <circle fill="#000000" cx="12" cy="19" r="2">
                                                            </circle>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item" data-ajax-popup="true"
                                                        data-url="{{ route('note.edit', $noticeBoard->id) }}"
                                                        data-title="{{ __('Edit Note') }}">
                                                        <i class="fa fa-edit"> </i>{{ __('Edit') }}</a>

                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['note.destroy', $noticeBoard->id]]) !!}
                                                    <a href="#!" class="js-sweetalert dropdown-item">
                                                        <i class="fa fa-trash"></i>{{ __('Delete') }}
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-justify">{{ $noticeBoard->description }}</p>
                                <div class="media align-items-center mt-2">
                                    <div class="media-body">
                                        <span class="h6 mb-0">{{ __('Created Date') }}</span><br>
                                        <span
                                            class="text-sm text-muted">{{ Auth::user()->dateFormat($noticeBoard->created_at) }}</span>
                                    </div>
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

<script>
    function openAnswer(answer) {
        const detailsHtml = `<span style="font-weight: 800;"></span> ${answer} <br>`;
        Swal.fire({
            title: "<h5>Description :</h5>",
            html: detailsHtml,
            type: "warning",
            confirmButtonText: "Ok",
        });
    }
</script>
