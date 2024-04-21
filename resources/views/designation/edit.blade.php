{{ Form::model($designation, array('route' => array('designation.update', $designation->id), 'method' => 'PUT')) }}
<div class="form-group">
    {{ Form::label('name', __('Name'),['class' => 'col-form-label required']) }}
    {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
</div>
<div class="form-group">
    {{ Form::label('department', __('Department'),['class' => 'col-form-label required']) }}
    {{ Form::select('department', $department,null, array('class' => 'form-control multi-select','required'=>'required')) }}
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary','id'=>"updateButton"]) }}

</div>

{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>

<script src="{{asset('assets/js/plugins/choices.min.js')}}"></script>

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
