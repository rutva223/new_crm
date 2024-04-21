{{ Form::open(array('url' => 'department')) }}

<div class="col-12 mb-3">
    <div class="form-group">
        {{ Form::label('name', __('Name') ,['class' => 'form-label required']) }}
        {{ Form::text('name', '', array('class' => 'form-control','required'=>'required','PlaceHolder'=>__('Department'))) }}
    </div>
</div>
<div class="col-12 mb-3">
    <div class="form-group">
        {{Form::label('branch_id',__('Branch'),['class'=>'form-label required'])}}
        {{Form::select('branch_id',$branch,null,array('class'=>'form-control select','placeholder'=>__('Select Branch')))}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>
</div>
</div>

{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
