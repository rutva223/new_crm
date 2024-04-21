{{ Form::open(['url' => 'note', 'enctype' => 'multipart/form-data']) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title', __('Title'), ['class' => 'col-form-label required']) }}
        {{ Form::text('title', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Title')]) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('file', __('File'), ['class' => 'col-form-label required']) }}
        {{ Form::file('file', ['class' => 'form-control', 'required' => 'required', 'id' => 'files']) }}
        <img id="image" class="mt-2" style="width:25%;" />
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description'), ['class' => 'col-form-label required']) }}
        {!! Form::textarea('description', null, [
            'class' => 'form-control',
            'rows' => '3',
            'required' => 'required',
            'placeholder' => __('Enter Description'),
        ]) !!}
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn btn-primary" id="createButton" disabled>{{ __('Create') }}</button>
</div>
{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>
<script>
    document.getElementById('files').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>
