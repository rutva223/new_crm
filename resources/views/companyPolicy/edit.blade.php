{{Form::model($companyPolicy,array('route' => array('company-policy.update', $companyPolicy->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="card-body p-0">
    @php 
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
   @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
     <div class="text-end">
                <a href="#" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate',['company policy']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate') }}" float-end>
            <span class="btn btn-primary btn-sm"> <i class="fas fa-robot">  {{ __('Generate With AI') }}</span></i>
        </a>
     </div>
     @endif
     
        <div class="form-group col-md-12">
            {{Form::label('title',__('Title'),['class' => 'col-form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('attachment',__('Attachment'),['class' => 'col-form-label'])}}
            {{Form::file('attachment',array('class'=>'form-control','id'=>'files'))}}
            <img id="image" class="mt-2" src="{{ \App\Models\Utility::get_file('uploads/companyPolicy/'.$companyPolicy->attachment)}}" style="width:25%;"/>

        </div>
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'),['class' => 'col-form-label']) }}
            {{ Form::textarea('description',null, array('class' => 'form-control','rows'=>3)) }}
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{Form::submit(__('Update'),array('class'=>'btn  btn-primary'))}}
</div>
{{Form::close()}}

<script>
    document.getElementById('files').onchange = function () {
    var src = URL.createObjectURL(this.files[0])
    document.getElementById('image').src = src
    }
</script>
