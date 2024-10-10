<?php echo e(Form::open(['url' => 'brands'])); ?>

<div class="modal-body">
<div class="form-group">
    <?php echo e(Form::label('name', __('Brand Name'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Brand Name')])); ?>

</div>
</div>

<div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
    </div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/brands/create.blade.php ENDPATH**/ ?>