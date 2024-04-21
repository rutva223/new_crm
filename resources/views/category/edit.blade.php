@php
$plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
    {{ Form::model($category, array('route' => array('category.update', $category->id), 'method' => 'PUT')) }}
    <div class="form-group">
        {{ Form::label('name', __('Name'),['class' => 'col-form-label']) }}
        {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group">
        {{ Form::label('type', __('Category Type'),['class' => 'col-form-label']) }}
        {{ Form::select('type',$types,null, array('class' => 'form-control multi-select','required'=>'required')) }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{Form::submit(__('Update'),array('class'=>'btn  btn-primary'))}}
    </div>
    {{ Form::close() }}
</div>
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
