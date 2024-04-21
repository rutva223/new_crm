{{ Form::model($note,array('route' => array('note.update', $note->id),'method'=>'PUT','enctype'=>"multipart/form-data")) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title', __('Title') ,['class' => 'col-form-label required']) }}
        {{ Form::text('title', null, array('class' => 'form-control', 'required' => 'required')) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('file', __('File') ,['class' => 'col-form-label required']) }}
        {{ Form::file('file', array('class' => 'form-control','id'=>'files', 'required' => 'required')) }}
        <img id="image" class="mt-2" src="{{ \App\Models\Utility::get_file('uploads/notes/'.$note->file)}}" style="width:25%;"/>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description') ,['class' => 'col-form-label required']) }}
        {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'3', 'required' => 'required']) !!}
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{Form::submit(__('Save Changes'),array('class'=>'btn  btn-primary', 'id'=>'updateButton'))}}
</div>
{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>
<script>
    document.getElementById('files').onchange = function () {
    var src = URL.createObjectURL(this.files[0])
    document.getElementById('image').src = src
    }
</script>
