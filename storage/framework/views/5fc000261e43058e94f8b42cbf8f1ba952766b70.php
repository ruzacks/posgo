<?php echo e(Form::open(['url' => 'vendors'])); ?>

<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        <?php echo e(Form::label('code', __('Code'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter new vendor code'), 'required'=>'required'])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new vendor name'), 'required'=>'required'])); ?>

    </div>
    
    <div class="form-group col-md-6">
        <?php echo e(Form::label('phone_number', __('Phone number'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('phone_number', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter phone number')])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('address', __('Address'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Enter Address')])); ?>

    </div>
    

    

    

    
</div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/vendors/create.blade.php ENDPATH**/ ?>