<?php echo e(Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('name', __('Role Name'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new User Name')])); ?>

    </div>

    <?php if(!empty($permissions) && count($permissions) > 0): ?>

        <div class="d-flex align-items-center justify-content-between">
            <?php echo e(Form::label('permission', __('Assign Permission'), ['class' => 'form-label col-form-label'])); ?>


            <div class="custom-control form-check float-right">
                <?php echo e(Form::checkbox('select-all', false, null, ['class' => 'form-check-input', 'id' => 'select-all'])); ?>

                <?php echo e(Form::label('select-all', 'Select All', ['class' => 'form-check-label '])); ?>

            </div>
        </div>
                <div class="table-responsive shadow-none">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="200px"><?php echo e(__('Module')); ?></th>
                                <th class="text-center"><?php echo e(__('Permissions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $modules = ['User', 'Customer', 'Vendor', 'Role', 'Branch', 'Branch Sales Target', 'Tax', 'Unit', 'Product', 'Quotations', 'Expense', 'Expense Category', 'Returns', 'Category', 'Brand', 'Cash Register', 'Calendar Event', 'Notification', 'Profile'];
                            ?>
                            ​
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="form-control-label"><?php echo e(__($module)); ?></td>

                                    <td>
                                        <div class="row">
                                            <?php
                                            $internalPermission = ['Manage', 'Create', 'Edit', 'Delete'];
                                            ?>
                                            <?php $__currentLoopData = $internalPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(in_array($ip . ' ' . $module, $permissions)): ?>
                                                    <?php ($key = array_search($ip . ' ' . $module, $permissions)); ?>
                                                    <div class="col-3 custom-control form-check">
                                                        <?php echo e(Form::checkbox('permissions[]', $key, $role->permissions, ['class' => 'form-check-input', 'id' => 'permission_' . $key])); ?>

                                                        <?php echo e(Form::label('permission_' . $key, $ip, ['class' => 'form-check-label'])); ?>

                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td class="form-control-label"><?php echo e(__('Account')); ?></td>
                                <td>
                                    <div class="row">

                                        <?php
                                        $customPermission = ['Email Settings', 'Manage Logos', 'Create Language', 'Change Language', 'Manage Language', 'Change Password', 'System Settings', 'Billing Settings', 'Store Settings', 'Manage Purchases', 'Manage Sales'];
                                        ?>
                                        <?php $__currentLoopData = $customPermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(in_array($p, $permissions)): ?>
                                                <?php ($key = array_search($p, $permissions)); ?>
                                                <div class="col-4 custom-control form-check">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permissions, ['class' => 'form-check-input', 'id' => 'permission_' . $key])); ?>

                                                    <?php echo e(Form::label('permission_' . $key, $p, ['class' => 'form-check-label'])); ?>

                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    <?php endif; ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/roles/edit.blade.php ENDPATH**/ ?>