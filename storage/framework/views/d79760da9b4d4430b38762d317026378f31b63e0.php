<?php echo e(Form::open(['url' => 'expenses'])); ?>

<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('date', __('Expense Date'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('date', null, ['class' => 'form-control d_week', 'placeholder' => __('Select Date'), 'readonly' => ''])); ?>

    </div>

    <div class="form-group">
        <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

        <div class="input-group">
            <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo e(Form::label('category_id', __('Expense Category'), ['class' => 'col-form-label'])); ?>

        <div class="input-group">
            <?php echo e(Form::select('category_id', $expensecategories, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo e(Form::label('amount', __('Amount'). ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('amount', null, ['class' => 'form-control', 'placeholder' => __('Enter Amount Price'), 'step' => '0.01'])); ?>

    </div>

    <div class="form-group">
        <?php echo e(Form::label('note', __('Note'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __('Enter Expense Note'), 'rows' => 3, 'style' => 'resize: none'])); ?>

    </div>
</div>

<div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/expenses/create.blade.php ENDPATH**/ ?>