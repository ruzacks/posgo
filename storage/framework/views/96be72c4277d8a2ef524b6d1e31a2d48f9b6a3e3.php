<?php echo e(Form::model($plan, ['route' => ['plans.update', $plan->id], 'method' => 'PUT', 'enctype' => "multipart/form-data"])); ?>

<div class="modal-body">
<div class="row">
    <div class="form-group col-md-6">
        <?php echo e(Form::label('name',__('Name'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name',null,['class'=>'form-control font-style','placeholder'=>__('Enter Plan Name'),'required'=>'required'])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php if($plan->id != 1): ?>
            <?php echo e(Form::label('price',__('Price'),['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('price',null,['class'=>'form-control','placeholder'=>__('Enter Plan Price'),'required'=>'required'])); ?>

        <?php endif; ?>
    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('duration', __('Duration'),['class' => 'col-form-label'])); ?>

        <?php echo Form::select('duration', $arrDuration, null,['class' => 'form-control','required'=>'required', 'data-toggle' => 'select']); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('max_users',__('Maximum Users'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('max_users',null,['class'=>'form-control max-users','required'=>'required'])); ?>

        <span class="small"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('max_customers',__('Maximum Customers'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('max_customers',null,['class'=>'form-control max-customers','required'=>'required'])); ?>

        <span class="small"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('max_vendors',__('Maximum Vendors'),['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('max_vendors',null,['class'=>'form-control max-vendors','required'=>'required'])); ?>

        <span class="small"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
    </div>
    <div class="form-group col-md-12">

        


        
    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'),['class' => 'col-form-label'])); ?>

        <?php echo Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']); ?>

    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Update')); ?>">
</div>

<?php echo e(Form::close()); ?>



<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/plans/edit.blade.php ENDPATH**/ ?>