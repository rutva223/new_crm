@extends('layouts.admin')
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
@push('css-page')
@endpush
@push('script-page')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
@push('css')
<style>
    .nav-pills .nav-link.active, .nav-pills:hover .show > .nav-link {
    background-color: var(--primary) !important;
}
</style>

@endpush
@section('page-title')
    {{ __('Client Edit') }}
@endsection
@section('title')
      {{ \Auth::user()->clientIdFormat($client->client_id) }}
            {{ __('Edit') }}
@endsection
@section('breadcrumb')
    {{ $user->name }}
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal_details-tab" data-bs-toggle="pill"
                            data-bs-target="#personal_details" type="button">{{ __('Personal Details') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="company_details-tab" data-bs-toggle="pill"
                            data-bs-target="#company_details" type="button">{{ __('Company Details') }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ sample-page ] start -->
<div class="col-sm-12">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="personal_details" role="tabpanel" aria-labelledby="pills-personal_details-tab">
            <div id="useradd-1" class="card">
                {{ Form::model($client, ['route' => ['client.personal.update', $client->user_id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="card-header">
                    <h5>{{ __('Personal Info') }}</h5>
                    <small class="text-muted">{{ __('Edit details about your personal information') }}</small>
                </div>

                <div class="card-body">
                    <form>
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                    {{ Form::text('name', $user->name, ['class' => 'form-control font-style', 'placeholder' => 'Enter Name']) }}
                                    @error('name')
                                        <span class="invalid-name" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('mobile', __('Mobile'), ['class' => 'form-label']) }}
                                    {{ Form::text('mobile', $client->mobile, ['class' => 'form-control', 'placeholder' => 'Enter Mobile']) }}
                                    @error('mobile')
                                        <span class="invalid-mobile" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('address_1', __('Address 1'), ['class' => 'form-label']) }}
                                    {{ Form::textarea('address_1', $client->address_1, ['class' => 'form-control', 'rows' => '4', 'placeholder' => 'Enter Address']) }}
                                    @error('address_1')
                                        <span class="invalid-address_1" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                    {{ Form::text('city', $client->city, ['class' => 'form-control', 'placeholder' => 'Enter City']) }}
                                    @error('city')
                                        <span class="invalid-city" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                {{ Form::text('state', $client->state, ['class' => 'form-control', 'placeholder' => 'Enter State']) }}
                                @error('state')
                                    <span class="invalid-state" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                {{ Form::text('country', $client->country, ['class' => 'form-control', 'placeholder' => 'Enter Country']) }}
                                @error('country')
                                    <span class="invalid-country" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('zip_code', __('Zip Code'), ['class' => 'form-label']) }}
                                {{ Form::text('zip_code', $client->zip_code, ['class' => 'form-control', 'placeholder' => 'Enter Zip Code']) }}
                                @error('zip_code')
                                    <span class="invalid-zip_code" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-2">
                                {{ Form::label('zip_code', __('Avatar'), ['class' => 'form-label']) }}
                                <div class="card bg-gradient-primary hover-shadow-lg border-0">
                                    <div class="card-body py-3">
                                        <div class="row row-grid align-items-center">
                                            <div class="col-lg-8">
                                                <div class="media align-items-center">
                                                    <a href="#" class="avatar avatar-lg rounded-circle mr-3">
                                                        <img @if (!empty($user->avatar)) src="{{ $profile . '/' . $user->avatar }}" @else avatar="{{ $user->name }}" @endif
                                                            class="avatar  rounded-circle avatar-lg">
                                                    </a>
                                                    <div class="media-body ms-3">
                                                        <h5 class="text-dark mb-2">{{ $user->name }}</h5>
                                                        <div>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="file-1" name="profile"
                                                                    aria-describedby="inputGroupFileAddon04"
                                                                    aria-label="Upload"
                                                                    data-multiple-caption="{count} files selected"
                                                                    multiple />
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer1">
                                {{ Form::submit(__('Update'), ['class' => 'btn btn-primary d-flex align-items-center']) }}
                            </div>


                        </div>
                    </form>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="tab-pane fade" id="company_details" role="tabpanel" aria-labelledby="pills-company_details-tab">
            <div id="useradd-2" class="card">
                {{ Form::model($client, ['route' => ['client.update.company', $client->user_id], 'method' => 'post']) }}
                <div class="card-header">
                    <h5>{{ __('Company Info') }}</h5>
                    <small class="text-muted">{{ __('Edit details about your company information') }}</small>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('clt_id', __('Client ID'), ['class' => 'form-label']) !!}
                                    {!! Form::text('clt_id', \Auth::user()->clientIdFormat($client->client_id), [
                                        'class' => 'form-control',
                                        'readonly',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('company_name', __('Company Name'), ['class' => 'form-label']) }}
                                    {{ Form::text('company_name', $client->company_name, ['class' => 'form-control', 'placeholder' => 'Enter  Company Name']) }}
                                    @error('company_name')
                                        <span class="invalid-company_name" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('website', __('Website'), ['class' => 'form-label']) }}
                                    {{ Form::text('website', $client->website, ['class' => 'form-control', 'placeholder' => 'Enter Website']) }}
                                    @error('website')
                                        <span class="invalid-website" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('tax_number', __('Tax Number'), ['class' => 'form-label']) }}
                                    {{ Form::text('tax_number', $client->tax_number, ['class' => 'form-control', 'placeholder' => 'Enter Tax Number']) }}
                                    @error('tax_number')
                                        <span class="invalid-tax_number" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('notes', __('Notes'), ['class' => 'form-label']) }}
                                    {{ Form::textarea('notes', $client->notes, ['class' => 'form-control', 'placeholder' => 'Enter Notes', 'rows' => '3']) }}
                                    @error('notes')
                                        <span class="invalid-notes" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer1">
                                {{ Form::submit(__('Update'), ['class' => 'btn btn-primary d-flex align-items-center']) }}
                            </div>
                        </div>
                    </form>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<!-- [ sample-page ] end -->
@endsection
