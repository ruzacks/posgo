{{ Form::model($locationType, ['route' => ['location-types.update', $locationType->id], 'method' => 'PUT']) }}
<div class="modal-body">

<div class="form-group">
    {{ Form::label('name', __('Location Type Name'), ['class' => 'col-form-label']) }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Location Type Name'), 'autocomplete' => 'off']) }}
</div>
</div>

 <div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>
{{ Form::close() }}
