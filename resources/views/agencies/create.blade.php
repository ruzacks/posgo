{{ Form::open(['url' => 'agencies']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('code', __('Code'), ['class' => 'col-form-label']) }}
            {{ Form::text('code', $newCode, ['class' => 'form-control', 'placeholder' => __('Enter code'), 'required' => 'required', 'autocomplete' => 'off', 'readonly' => '']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name'), 'autocomplete' => 'off', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('phone_number', __('Phone Number'), ['class' => 'col-form-label']) }}
            {{ Form::text('phone_number', null, ['class' => 'form-control', 'maxlength' => '15', 'autocomplete' => 'off', 'placeholder' => __('Enter phone number')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('address', __('Address'), ['class' => 'col-form-label']) }}
            {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Enter address'), 'autocomplete' => 'off']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>

{{ Form::close() }}
