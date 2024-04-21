
    {{Form::open(array('url'=>'branch','method'=>'post'))}}
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label required']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Branch Name')]) }}
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <label for="email" class="text-label form-label required">Mail</label>
            <div class="input-group">
                <input type="email" class="form-control" name="email" placeholder="Enter Mail ID..." required>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <label for="phone" class="text-label form-label required">Phone No.</label>
            <div class="input-group">
                <input type="number" class="form-control" name="phone" placeholder="Enter Phone Number.." required>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="from-group">
                <label for="status" class="from-label required">Status</label>
                <select name="status" id="status" class="form-control select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                {{ Form::label('address', __('Address'), ['class' => 'form-label required']) }}
                <textarea name="address" id="address" cols="15" rows="5" class="form-control" placeholder="Enter Address.." required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>
        </div>

    </div>
    {{Form::close()}}
    <script src="{{ asset('assets/js/required.js') }}"></script>
