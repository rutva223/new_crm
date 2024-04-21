{{Form::model($plan, array('route' => array('plan.update', $plan->id), 'method' => 'PUT', 'enctype' => "multipart/form-data")) }}
<div class="row">
    <div class="form-group col-md-6">
        {{Form::label('name',__('Name'),['class' => 'col-form-label required'])}}
        {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter Plan Name'),'required'=>'required'))}}
    </div>
    @if($plan->price>0)
    <div class="form-group col-md-6">
        {{Form::label('price',__('Price'),['class' => 'col-form-label required'])}}
        {{Form::number('price',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Plan Price'),'step'=>'0.01'))}}
    </div>
    @endif
    <div class="form-group col-md-6">
        {{Form::label('max_employee',__('Maximum Employee'),['class' => 'col-form-label required'])}}
        {{Form::number('max_employee',null,array('class'=>'form-control','required'=>'required'))}}
        <span class="small">{{__('Note: "-1" for Unlimited')}}</span>
    </div>
    <div class="form-group col-md-6">
        {{Form::label('max_client',__('Maximum Client'),['class' => 'col-form-label required'])}}
        {{Form::number('max_client',null,array('class'=>'form-control','required'=>'required'))}}
        <span class="small">{{__('Note: "-1" for Unlimited')}}</span>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('duration', __('Duration'),['class' => 'col-form-label required']) }}
        {!! Form::select('duration', $arrDuration, null,array('class' =>
        'form-control','data-toggle'=>'select','required'=>'required')) !!}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description'),['class' => 'col-form-label']) }}
        {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'3']) !!}
    </div>

    <div class="modal-footer pr-0">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{Form::submit(__('Save Changes'),array('class'=>'btn  btn-primary', 'id'=>'updateButton'))}}
    </div>
</div>
{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>
