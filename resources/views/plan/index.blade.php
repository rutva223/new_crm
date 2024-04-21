@extends('layouts.admin')
@php
    $admin_payment_setting = Utility::settings();
@endphp
@section('breadcrumb')
    {{ __('Plan') }}
@endsection
@section('title')
    {{ __('Plan') }}
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'super admin')
        <a href="#" data-url="{{ route('plan.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Plan') }}"
            data-size="lg" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip"
            title="{{ __('Create New Plan') }}">
            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
        </a>
    @endif
@endsection
@section('content')
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-xl-4 wow fadeInUp" data-wow-delay="1s"
                style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                <div class="card">
                    <div class="card-header border-0">
                        <h2 class="card-title">{{ $plan->name }} </h2>
                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <div class="d-flex flex-row-reverse m-0 p-0 ">
                                <span class="d-flex align-items-center ">
                                    <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                    <span class="ms-2">{{ __('Active') }}</span>
                                </span>
                            </div>
                        @endif
                        @if ($plan->is_free_plan == 0)
                            @if (\Auth::user()->type == 'super admin')
                                <div>
                                    <a href="#" data-size="lg" data-url="{{ route('plan.edit', $plan->id) }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-title="Plan Update"
                                        class="btn-link btn sharp tp-btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="card-body text-center pt-0 pb-2">
                        <div class="">
                            <div class="author-profile">
                                <div class="author-info">
                                    <h1 class=" f-w-600 ">
                                        {{ isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$' }}{{ $plan->price }}
                                    </h1>
                                    <span>
                                        <h6>{{ $plan->duration }}</h6>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-items">
                            <div class="row">
                                <div class=" col-xl-12 col-sm-12 mb-3">
                                    <div class="text-start mt-2">
                                        <div class="color-picker">
                                            <p class="mb-0  text-gray ">
                                                <i class="fa fa-user me-2"></i>
                                                Maximum Employee
                                            </p>
                                            <h6 class="mb-0">
                                                {{ $plan->max_employee == '-1' ? __('Unlimited') : $plan->max_employee }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="text-start mt-2">
                                        <div class="color-picker">
                                            <p class="mb-0  text-gray ">
                                                <i class="fa fa-user me-2"></i>
                                                Maximum Client
                                            </p>
                                            <h6 class="mb-0">
                                                {{ $plan->max_client == '-1' ? __('Unlimited') : $plan->max_client }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-xl-12 col-sm-12 mb-3">
                                    <div class="text-center mt-2">
                                        @can('subscribe plan')
                                            <div class="card-footer">
                                                @if (Auth::user()->plan == $plan->id)
                                                    <div class="input-group">
                                                        <a
                                                            class="form-control text-primary rounded text-center">{{ $plan->duration == 'Lifetime' ? 'Unlimited' : Auth::user()->plan_expire_date ?? '' }}</a>
                                                    </div>
                                                @else
                                                    @if ($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin')
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            @if ($plan->price > 0)
                                                                <form role="form" action="{{ route('stripe.post') }}"
                                                                    method="post" id="stripe-payment-form">
                                                                    @csrf
                                                                    <input type="hidden" name="plan_id" id="plan_id"
                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                                    <button
                                                                        class="form-control text-primary rounded text-center"
                                                                        type="submit">
                                                                        {{ __('Subscribe') }}
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (Auth::user()->type == 'super admin')
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Order History</h4>
            </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="display" id="example">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>User Name</th>
                                <th>Plan Name</th>
                                <th>Payment Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>{{ $order->user_name }}</td>
                                    <td>{{ $order->plan_name }}</td>
                                    <td>{{ $order->payment_type }}</td>
                                    <td>
                                        <div class="d-flex">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id]]) !!}
                                            <a href="javascript:;"
                                                class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                title="Delete data">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('script-page')
    <script>
        $(document).on("click", ".is_active", function() {
            var id = $(this).attr('data-id');
            var is_active = ($(this).is(':checked')) ? $(this).val() : 0;
            $.ajax({
                url: '{{ route('plan.enable') }}',
                type: 'POST',
                data: {
                    "is_active": is_active,
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.success) {
                        toastrs('success', data.success);
                    } else {
                        toastrs('error', data.error);
                    }
                }
            });
        });
    </script>
@endpush
