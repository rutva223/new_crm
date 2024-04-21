@extends('layouts.admin')

@section('title')
    {{ __('Manage Setting') }}
@endsection
@section('breadcrumb')
    {{ __('Setting') }}
@endsection
@push('css')
    <style>
        .nav-pills .nav-link.active,
        .nav-pills:hover .show>.nav-link {
            background-color: var(--primary) !important;
        }
    </style>
@endpush
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link {{ session('active_tab', 'email_setting') == 'email_setting' ? 'active' : '' }}"
                                id="email_setting-tab" data-bs-toggle="pill" data-bs-target="#email_setting"
                                type="button">{{ __('Email Setting') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab') == 'payment_setting' ? 'active' : '' }}"
                                id="payment_setting-tab" data-bs-toggle="pill" data-bs-target="#payment_setting"
                                type="button">{{ __('Payment Setting') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab') == 'company_setting' ? 'active' : '' }}"
                                id="company_setting-tab" data-bs-toggle="pill" data-bs-target="#company_setting"
                                type="button">{{ __('company setting') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab') == 'estimate_etting' ? 'active' : '' }}"
                                id="estimate_etting-tab" data-bs-toggle="pill" data-bs-target="#estimate_etting"
                                type="button">{{ __('Estimate Setting') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab') == 'invoice_setting' ? 'active' : '' }}"
                                id="invoice_setting-tab" data-bs-toggle="pill" data-bs-target="#invoice_setting"
                                type="button">{{ __('Invoice Setting') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade {{ session('active_tab', 'email_setting') == 'email_setting' ? 'show active' : '' }}"
                id="email_setting" role="tabpanel" aria-labelledby="pills-email_setting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Email Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ Form::model($settings, ['route' => 'email.setting', 'method' => 'post', 'id' => 'payment-form']) }}
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail Driver</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_driver"
                                            value="{{ $settings['mail_driver'] ?? '' }}"
                                            placeholder="Enter a Mail Mailer.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail Host</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_host"
                                            value="{{ $settings['mail_host'] ?? '' }}" placeholder="Enter a Mail Host.."
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail Port</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="mail_port"
                                            value="{{ $settings['mail_port'] ?? '' }}" placeholder="Enter a Mail Port.."
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail Username</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_username"
                                            value="{{ $settings['mail_username'] ?? '' }}"
                                            placeholder="Enter a Mail Username.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail Password</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_password"
                                            value="{{ $settings['mail_password'] ?? '' }}"
                                            placeholder="Enter a Mail Password.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail From Address</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_from_address"
                                            value="{{ $settings['mail_from_address'] ?? '' }}"
                                            placeholder="Enter a Mail From Address.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label required">Mail From Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail_from_name"
                                            value="{{ $settings['mail_from_name'] ?? '' }}"
                                            placeholder="Enter a Mail From Name.." required>
                                    </div>
                                </div>
                            </div>
                            <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" id="cancelButton"
                                data-bs-dismiss="modal">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary" id="createButton"
                                disabled>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade {{ session('active_tab') == 'payment_setting' ? 'show active' : '' }}"
                id="payment_setting" role="tabpanel" aria-labelledby="pills-payment_setting-tab">
                <div class="card">
                    <div class="cm-content-box">
                        <div class="card-header SlideToolHeader">
                            <h4 class="card-title">Stripe</h4>
                            <div class="tools">
                                <a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
                            </div>
                        </div>
                        <div class="cm-content-body form excerpt">
                            <div class="card-body">
                                <div class="basic-form">
                                    {{ Form::model($settings, ['route' => 'payment.setting', 'method' => 'post', 'id' => 'payment_form']) }}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Currency</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_currency"
                                                    value="{{ $settings['stripe_currency'] ?? '' }}"
                                                    placeholder="Enter Currancy.." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Stripe Key</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_key"
                                                    value="{{ $settings['stripe_key'] ?? '' }}"
                                                    placeholder="Enter Stripe Key.." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Stripe Secret Key</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_secret_key"
                                                    value="{{ $settings['stripe_secret_key'] ?? '' }}"
                                                    placeholder="Enter Stripe Secret Key.." required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light"
                                        id="cancelButton1" data-bs-dismiss="modal">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade {{ session('active_tab') == 'company_setting' ? 'show active' : '' }}"
                id="company_setting" role="tabpanel" aria-labelledby="pills-company_setting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Company Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ Form::model($settings, ['route' => 'company.setting', 'method' => 'post', 'id' => 'payment-form']) }}
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_name', __('Company Name'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::text('company_name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your Company Name')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_address', __('Address'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_address', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your Address')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_city', __('City'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_city', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your City')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_state', __('State'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_state', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your State')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_zipcode', __('Zip/Post Code'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_zipcode', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Zip/Post Code')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_country', __('Country'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_country', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your Country')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_telephone', __('Mobile No.'), ['class' => 'text-label form-label']) }}
                                    {{ Form::text('company_telephone', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Telephone Number')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_email', __('System Email'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::text('company_email', null, ['class' => 'form-control', 'placeholder' => __('Enter Your System Email')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_email_from_name', __('Email (From Name)'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::text('company_email_from_name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Your Email (From Name)')]) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('registration_number', __('Company Registration Number'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::text('registration_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Company Registration Number')]) }}
                                </div>
                                {{-- <div class="col-md-6 mb-3">
                                        {{ Form::label('vat_number', __('VAT Number'), ['class' => 'form-label required']) }}
                                        {{ Form::text('vat_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Your VAT Number')]) }}
                                    </div>
                                    <div class="col-md-6">
                                        {{ Form::label('timezone', __('Timezone'), ['class' => 'form-label']) }}
                                        <select type="text" name="timezone" class="form-control custom-select" id="timezone">
                                            <option value="">{{ __('Select Timezone') }}</option>
                                            @foreach ($timezones as $k => $timezone)
                                            <option value="{{ $k }}" {{ $setting['timezone'] == $k ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_start_time', __('Company Start Time'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::time('company_start_time', null, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ Form::label('company_end_time', __('Company End Time'), ['class' => 'text-label form-label required']) }}
                                    {{ Form::time('company_end_time', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" id="cancelButton"
                                data-bs-dismiss="modal">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade {{ session('active_tab') == 'estimate_etting' ? 'show active' : '' }}"
                id="estimate_etting" role="tabpanel" aria-labelledby="pills-estimate_etting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Estimate Settings</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{-- {{ Form::model(['route' => 'estimate.template.setting', 'method' => 'post']) }}
                            @csrf --}}
                        <div class="row">
                            @if (isset($settings['estimate_template']) && isset($settings['estimate_color']))
                                <iframe id="estimate_frame" class="w-100" style="height: 1070px;" frameborder="0"
                                    src="{{ route('estimate.preview', [$settings['estimate_template'], $settings['estimate_color']]) }}"></iframe>
                            @else
                                <iframe id="estimate_frame" class="w-100" style="height: 1070px;" frameborder="0"
                                    src="{{ route('estimate.preview', ['template1', 'fffff']) }}"></iframe>
                            @endif
                        </div>
                        {{-- <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" id="cancelButton"
                                data-bs-dismiss="modal">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                            {{ Form::close() }} --}}
                    </div>
                </div>
            </div>

            <div class="tab-pane fade {{ session('active_tab') == 'invoice_setting' ? 'show active' : '' }}"
                id="invoice_setting" role="tabpanel" aria-labelledby="pills-invoice_setting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Invoice Settings</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{-- {{ Form::model(['route' => 'estimate.template.setting', 'method' => 'post']) }}
                            @csrf --}}
                        <div class="row">
                            @if (isset($settings['invoice_template']) && isset($settings['invoice_color']))
                                <iframe id="invoice_frame" class="w-100" style="height: 1070px;" frameborder="0"
                                    src="{{ route('invoice.preview', [$settings['invoice_template'], $settings['invoice_color']]) }}"></iframe>
                            @else
                                <iframe id="invoice_frame" class="w-100" style="height: 1070px;" frameborder="0"
                                    src="{{ route('invoice.preview', ['template1', 'fffff']) }}"></iframe>
                            @endif
                        </div>
                        {{-- <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" id="cancelButton"
                                data-bs-dismiss="modal">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                            {{ Form::close() }} --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            $('#cancelButton').on('click', function() {
                $('#payment-form')[0].reset();
            });
            $('#cancelButton1').on('click', function() {
                $('#payment_form')[0].reset();
            });
        });
    </script>
@endpush
