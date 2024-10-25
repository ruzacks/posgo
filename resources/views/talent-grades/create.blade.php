{{ Form::open(['url' => 'talent-grades']) }}
<div class="modal-body">

    <div class="form-group">
        {{ Form::label('name', __('Talent Grade Name'), ['class' => 'col-form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Talent Grade Name')]) }}
    </div>

    <div class="form-group">
        {{ Form::label('price', __('Price'), ['class' => 'col-form-label']) }}
        {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price'), 'step' => '0.01']) }}
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>

{{ Form::close() }}
