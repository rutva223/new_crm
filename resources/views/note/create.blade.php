{{ Form::open(['url' => 'note', 'enctype' => 'multipart/form-data']) }}
@php
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
    @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
        <div class="text-end">
            <a href="#" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate', ['note']) }}"
                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}"
                data-title="{{ __('Generate Content With AI') }}" float-end>
                <span class="btn btn-primary btn-sm"> <i class="fas fa-robot"> {{ __('Generate With AI') }}</span></i>
            </a>
        </div>
    @endif
    <div class="form-group col-md-12">
        {{ Form::label('title', __('Title'), ['class' => 'col-form-label']) }}
        {{ Form::text('title', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Title')]) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('file', __('File'), ['class' => 'col-form-label']) }}
        {{ Form::file('file', ['class' => 'form-control', 'id' => 'files']) }}
        <img id="image" class="mt-2" style="width:25%;" />
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
        {!! Form::textarea('description', null, [
            'class' => 'form-control',
            'rows' => '3',
            'placeholder' => __('Enter Description'),
        ]) !!}
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}

<script>
    document.getElementById('files').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>
