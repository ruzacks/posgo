{{ Form::model($room, ['route' => ['rooms.update', $room->id], 'method' => 'PUT']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('room_code', __('Room Code'), ['class' => 'col-form-label']) }}
        {{ Form::text('room_code', null, ['class' => 'form-control', 'placeholder' => __('Enter new room code'), 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('room_type', __('Room Type'), ['class' => 'col-form-label']) }}
        <div class="input-group">
            {{ Form::select('room_type', 
                ['Standard Room' => 'Standard Room', 'VIP Room' => 'VIP Room', 'VVIP Room' => 'VVIP Room'],  // Static options
                null,  // Default selected value (null means no default)
                ['class' => 'form-control', 'data-toggle' => 'select'] 
            ) }}
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('price', __('Price per Hour'), ['class' => 'col-form-label']) }}
        {{ Form::text('price', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter price per hour')]) }}
    </div>
</div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>

{{ Form::close() }}
