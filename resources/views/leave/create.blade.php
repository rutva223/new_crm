{{ Form::open(['url' => 'leave']) }}
<div class="row">
    @php
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">

        @if (\Auth::user()->type == 'company')
        <div class="form-group col-md-12">
            {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label required']) }}
            <div class="form-icon-user">
                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control multi-select', 'id' => 'employee_id']) }}
            </div>
        </div>
    @endif
    <div class="form-group col-md-12">
        {{ Form::label('leave_type', __('Leave Type'), ['class' => 'col-form-label required']) }}
        <select name="leave_type" id="leave_type" class="form-control" data-toggle="select" required>
            @foreach ($leaveTypes as $leave)
                <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">{{ $leave->days }}
                    </p>)</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label required']) }}
        {{-- {{ Form::date('start_date', \Carbon\Carbon::now()->format('Y-m-d'),['class' => 'form-control']) }} --}}
        {{ Form::date('start_date', new \DateTime(), ['class' => 'form-control', 'required' => 'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label required']) }}
        {{-- {{ Form::date('end_date', \Carbon\Carbon::now()->format('Y-m-d'),['class' => 'form-control']) }} --}}
        {{ Form::date('end_date', new \DateTime(), ['class' => 'form-control', 'required' => 'required']) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label required']) }}
        {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'rows' => '3', 'required' => 'required']) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label required']) }}
        {{ Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '3', 'required' => 'required']) }}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>
</div>

{{ Form::close() }}


<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/required.js') }}"></script>

<script>
    if ($(".multi-select").length > 0) {
        $($(".multi-select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>
