{{ Form::model($talentGrade, ['route' => ['talent-grades.update', $talentGrade->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="form-group">
        {{ Form::label('name', __('Talent Grade Name'), ['class' => 'col-form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Talent Grade Name'), 'autocomplete' => 'off']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', __('Price Stucture'), ['class' => 'col-form-label']) }}
    </div>
    <div class="form-group">
        {{ Form::label('talent_price', __('Talent'), ['class' => 'col-form-label']) }}
        {{ Form::number('talent_price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price'), 'step' => '1000']) }}
    </div>
    <div class="form-group">
        {{ Form::label('agency_price', __('Agency'), ['class' => 'col-form-label']) }}
        {{ Form::number('agency_price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price'), 'step' => '1000']) }}
    </div>
    <div class="form-group">
        {{ Form::label('office_price', __('Office'), ['class' => 'col-form-label']) }}
        {{ Form::number('office_price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price'), 'step' => '1000']) }}
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>
{{ Form::close() }}
