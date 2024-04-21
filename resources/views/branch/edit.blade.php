
    {{Form::model($branch,array('route' => array('branch.update', $branch->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Branch Name')]) }}
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <label for="email" class="text-label form-label required">Mail</label>
            <input type="email" class="form-control" name="email" value="{{ $branch->email ?? '' }}" placeholder="Enter Mail ID..." required>
        </div>
        <div class="col-md-12 mb-3">
            <label for="phone" class="text-label form-label required">Phone No.</label>
            <input type="number" class="form-control" name="phone" value="{{ $branch->phone ?? '' }}" placeholder="Enter Phone Number.." required>
        </div>
        <div class="col-md-12 mb-3">
            <div class="from-group">
                <label for="status" class="from-label required">Status</label>
                <select name="status" id="status" class="form-control select">
                    <option value="active" {{ $branch->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $branch->status == 'active' ? 'inactive' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                {{ Form::label('address', __('Address'), ['class' => 'form-label required']) }}
                <textarea name="address" id="address" cols="15" rows="5" class="form-control"  placeholder="Enter Address.." required>{{ $branch->address ?? '' }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            {{ Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary','id'=>"updateButton"]) }}
        </div>
    </div>
    {{Form::close()}}
    <script src="{{ asset('assets/js/required.js') }}"></script>
