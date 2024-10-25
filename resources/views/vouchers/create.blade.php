{{ Form::open(['url' => 'vouchers']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('voucher_code', __('Voucher Code'), ['class' => 'col-form-label']) }}
        {{ Form::text('voucher_code', null, ['class' => 'form-control', 'placeholder' => __('Enter voucher code'), 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('discount_type', __('Discount Type'), ['class' => 'col-form-label']) }}
        <div class="input-group">
            {{ Form::select('discount_type', 
                ['fixed' => 'Fixed', 'percentage' => 'Percentage'],  // Static options
                null,  // Default selected value (null means no default)
                ['class' => 'form-control', 'data-toggle' => 'select'] 
            ) }}
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('discount_value', __('Discount Value'), ['class' => 'col-form-label']) }}
        {{ Form::text('discount_value', null, ['class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('Enter discount value'), 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('max_discount', __('Maximum Discount (optional)'), ['class' => 'col-form-label']) }}
        {{ Form::text('max_discount', null, ['class' => 'form-control', 'maxlength' => '10', 'placeholder' => __('Enter maximum discount (if any)')]) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
        {{ Form::date('start_date', null, ['class' => 'form-control', 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('expiry_date', __('Expiry Date'), ['class' => 'col-form-label']) }}
        {{ Form::date('expiry_date', null, ['class' => 'form-control', 'required'=>'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('usage_limit', __('Usage Limit (optional)'), ['class' => 'col-form-label']) }}
        {{ Form::text('usage_limit', null, ['class' => 'form-control', 'maxlength' => '5', 'placeholder' => __('Enter usage limit (if any)')]) }}
    </div>
</div>
</div>
 <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

{{ Form::close() }}
