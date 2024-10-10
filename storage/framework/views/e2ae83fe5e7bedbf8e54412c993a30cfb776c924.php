<?php echo e(Form::open(['url' => 'users'])); ?>

<div class="modal-body">
    <div class="row mb-3">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', __('Name'),['class' => 'col-form-label'])); ?><br>
            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new user name')])); ?>

        </div>
    
        <div class="form-group col-md-6">
            <?php echo e(Form::label('email', __('Email'),['class' => 'col-form-label'])); ?><br>
            <?php echo e(Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter new Email Address')])); ?>

        </div>
    
        <?php if(Auth::user()->parent_id != 0): ?>
            <div class='form-group col-md-12'>
                <h5><?php echo e(__('Assign Role')); ?></h5>
                <?php echo e(Form::select('role', $roles, null, ['class' => 'form-control', 'required'=>'' ])); ?>

            </div>
    
            <div class="form-group col-md-6">
                <?php echo e(Form::label('branch_id', __('Branch'),['class' => 'col-form-label'])); ?><br>
                <div class="input-group">
                    <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

                </div>
            </div>
    
            <div class="form-group col-md-6">
                <?php echo e(Form::label('cash_register_id', __('Cash Register'),['class' => 'col-form-label'])); ?>

                <div class="input-group">
                    <?php echo e(Form::select('cash_register_id', ['' => __('Select Cash Register')], null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

                </div>
            </div>
        <?php endif; ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('password', __('Password'),['class' => 'col-form-label'])); ?><br>
            <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter new Password')])); ?>

        </div>
    
        <div class="form-group col-md-6">
            <?php echo e(Form::label('password_confirmation', __('Confirm Password'),['class' => 'col-form-label'])); ?><br>
            <?php echo e(Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('Confirm Password')])); ?>

        </div>
    </div>
</div>



<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/users/create.blade.php ENDPATH**/ ?>