{{ Form::model($location, ['route' => ['locations.update', $location->id], 'method' => 'PUT']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('code', __('Location Code'), ['class' => 'col-form-label']) }}
        {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter new location code'), 'required'=>'required', 'readonly' => '']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
        <div class="input-group">
            {{ Form::select('status', 
                [
                    'available' => 'Available', 
                    'occupied' => 'Occupied',  
                    'booked' => 'Booked', 
                    'maintenance' => 'Maintenance' 
                ],  
                null,  // Default selected value (null means no default)
                ['class' => 'form-control', 'data-toggle' => 'select'] 
            ) }}
        </div>
    </div></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>

{{ Form::close() }}
