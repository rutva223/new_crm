{{ Form::open(array('url' => 'meeting')) }}
<div class="row">
    @php
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('department', __('Department'),['class' => 'col-form-label']) }}
        {{ Form::select('department', $departments,'', array('class' => 'form-control multi-select')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('designation', __('Designation'),['class' => 'col-form-label']) }}
        {{ Form::select('designation', $designations ,'', array('class' => 'form-control multi-select')) }}
    </div>

    <div class="form-group col-md-12">
        {{Form::label('title',__('Title '),['class' => 'col-form-label required'])}}
        {{Form::text('title',null,array('class'=>'form-control'))}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('date',__('Date'),['class' => 'col-form-label required'])}}
        {{Form::date('date', new \DateTime(),array('class'=>'form-control'))}}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('time',__('Time'),['class' => 'col-form-label required'])}}
        {{Form::time('time',null,array('class'=>'form-control'))}}
    </div>
    <div class="form-group col-md-12">
        <div class="row p-2">
            <div class="col-6">
                {{Form::label('notes',__('Notes'),['class' => 'col-form-label'])}}
            </div>
        </div>
        {{Form::textarea('notes',null,array('class'=>'form-control meeting_create','rows'=>'2'))}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>

</div>
{{ Form::close() }}

<script src="{{asset('assets/js/plugins/choices.min.js')}}"></script>
<script src="{{ asset('assets/js/required.js') }}"></script>

<script>
    if ($(".multi-select").length > 0) {
              $( $(".multi-select") ).each(function( index,element ) {
                  var id = $(element).attr('id');
                     var multipleCancelButton = new Choices(
                          '#'+id, {
                              removeItemButton: true,
                          }
                      );
              });
         }
</script>
