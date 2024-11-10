{{ Form::open(['url' => 'locations']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('location_code', __('Room Code'), ['class' => 'col-form-label']) }}
        {{ Form::text('location_code', null, ['class' => 'form-control', 'placeholder' => __('Enter new location code'), 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('location_type', __('Room Type'), ['class' => 'col-form-label']) }}
        <div class="input-group">
            {{ Form::select('location_type', 
                ['Standard Room' => 'Standard Room', 'VIP Room' => 'VIP Room', 'VVIP Room' => 'VVIP Room'],  // Static options
                null,  // Default selected value (null means no default)
                ['class' => 'form-control', 'data-toggle' => 'select'] 
            ) }}
        </div>
    </div>
</div>
</div>
 <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

{{ Form::close() }}
