
{{Form::open(array('url'=>'company-policy','method'=>'post', 'enctype' => "multipart/form-data"))}}
<div class="card-body p-0">
    @php
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
        <div class="form-group col-md-12">
            {{Form::label('title',__('Title'),['class' => 'col-form-label required'])}}
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required'))}}
        </div>

        <div class="form-group col-md-12">
            {{Form::label('attachment',__('Attachment'),['class' => 'col-form-label'])}}
            {{Form::file('attachment',array('class'=>'form-control','id'=>'files'))}}
            <img id="image" class="mt-2" style="width:25%;"/>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'),['class' => 'col-form-label']) }}
            {{ Form::textarea('description',null, array('class' => 'form-control','rows'=>3)) }}
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>

</div>
{{Form::close()}}
<script src="{{ asset('assets/js/required.js') }}"></script>

<script>
    document.getElementById('files').onchange = function () {
    var src = URL.createObjectURL(this.files[0])
    document.getElementById('image').src = src
    }
</script>
