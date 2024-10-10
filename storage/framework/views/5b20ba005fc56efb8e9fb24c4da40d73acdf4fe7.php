<?php $__env->startSection('page-title', __('Roles List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Roles List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Role')): ?>
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Add Role')); ?>"
            data-title="<?php echo e(__('Add Role')); ?>" data-url="<?php echo e(route('roles.create')); ?>" class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-plus text-white"></i></a>
        </a>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Role')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Role')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Role')); ?></th>
                                        <th><?php echo e(__('Permissions')); ?></th>
                                        <th class="text-right"><?php echo e(__('Operation')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($role->name); ?></td>
                                            <td style="white-space: inherit !important;">
                                                <?php $__currentLoopData = $role->permissions()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pername): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge rounded p-2 m-1 px-3 bg-primary ">
                                                        <a href="#" class="absent-btn text-white"><?php echo e($pername); ?></a>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td class="pull-right">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Role')): ?>
                                                    <div class="action-btn btn-info ms-2">
                                                        <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                            data-title="<?php echo e(__('Edit Role')); ?>" data-size="lg"
                                                            data-url="<?php echo e(route('roles.edit', $role->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"> </i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Role')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                            data-title="<?php echo e(__('Delete')); ?>"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($role->id); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('click', '#select-all', function(e) {
            if (this.checked) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/roles/index.blade.php ENDPATH**/ ?>