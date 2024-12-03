{{ Form::open(['url' => 'location-types']) }}
<div class="modal-body">

<div class="form-group">
    {{ Form::label('name', __('Location Name'), ['class' => 'col-form-label']) }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Location Name'), 'autocomplete' => 'off']) }}
</div>
</div>

 <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

{{ Form::close() }}
