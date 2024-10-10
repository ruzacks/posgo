<?php echo e(Form::open(['url' => 'store-language'])); ?>

<div class="modal-body">
<div class="form-group">
    <?php echo e(Form::label('code', __('Language Code') , ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter new Language Code'), 'required' => 'required'])); ?>

</div>
</div>

 <div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <button type="submit" class="btn  btn-primary"><?php echo e(__('Create')); ?></button>  
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/languages/create.blade.php ENDPATH**/ ?>