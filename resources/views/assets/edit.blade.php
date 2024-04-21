{{ Form::model($asset, array('route' => array('account-assets.update', $asset->id), 'method' => 'PUT')) }}
<div class="row">
    @php
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Name'),['class' => 'col-form-label required']) }}
        {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('amount', __('Amount'),['class' => 'col-form-label required']) }}
        {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('purchase_date', __('Purchase Date'),['class' => 'col-form-label']) }}
        {{ Form::date('purchase_date',null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('supported_date', __('Support Until'),['class' => 'col-form-label']) }}
        {{ Form::date('supported_date',null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group  col-md-12">
        {{ Form::label('description', __('Description'),['class' => 'col-form-label']) }}
        {{ Form::textarea('description', null, array('class' => 'form-control','rows'=>'3')) }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary','id'=>"updateButton"]) }}

    </div>
</div>
{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>




