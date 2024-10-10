<?php echo e(Form::open(['url' => 'units'])); ?>

<div class="modal-body">
<div class="form-group">
    <?php echo e(Form::label('name', __('Unit Name'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Unit Name')])); ?>

</div>

<div class="form-group">
    <?php echo e(Form::label('shortname', __('Short Name'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('shortname', null, ['class' => 'form-control', 'placeholder' => __('Enter Unit Short Name')])); ?>

</div>
</div>


<div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
    </div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/units/create.blade.php ENDPATH**/ ?>