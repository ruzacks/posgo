{{ Form::open(['url' => 'talents']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new talent name'), 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('phone_number', __('Phone number'), ['class' => 'col-form-label']) }}
        {{ Form::text('phone_number', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter phone number')]) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('grade_id', __('Grade'), ['class' => 'col-form-label']) }}
        <div class="input-group">
            {{ Form::select('grade_id', $grades, null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('price', __('Price per Hour'), ['class' => 'col-form-label']) }}
        {{ Form::text('price', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter price per hour')]) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('address', __('Address'), ['class' => 'col-form-label']) }}
        {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Enter Address')]) }}
    </div>
</div>
</div>
 <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

{{ Form::close() }}
