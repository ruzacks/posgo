<?php echo e(Form::open(['url' => 'branches'])); ?>

<div class="modal-body">
<div class="form-group">
    <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Branch Name')])); ?>

</div>

<div class="form-group">
    <?php echo e(Form::label('branch_type', __('Branch type'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::select('branch_type', ['' => __('Select Branch Type'), 'retail' => 'Retail', 'restaurant' => 'Restaurant'], null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

</div>

<div class="form-group">
    <?php echo e(Form::label('branch_manager', __('Branch Manager'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::select('branch_manager', $users, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

</div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/branches/create.blade.php ENDPATH**/ ?>