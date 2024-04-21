{{ Form::model($department, array('route' => array('department.update', $department->id), 'method' => 'PUT')) }}
<div class="form-group mb-3">
    {{ Form::label('name', __('Name'),['class' => 'form-label required']) }}
    {{ Form::text('name', null, array('class' => 'form-control','required'=>'required','Place Holder'=>__('Department'))) }}
</div>
<div class="col-12 mb-3">
    <div class="form-group">
        {{Form::label('branch_id',__('Branch'),['class' => 'form-label required'])}}
        {{Form::select('branch_id',$branch,null,array('class'=>'form-control select','placeholder'=>__('select Branch')))}}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary','id'=>"updateButton"]) }}

</div>
</div>

{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
