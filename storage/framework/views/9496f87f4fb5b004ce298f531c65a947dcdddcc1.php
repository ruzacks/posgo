<?php $__env->startSection('page-title', __('Branch Sales Target')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Branch Sales Target')); ?></h5>  
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Branch Sales Target')): ?>
        <a data-ajax-popup="true" data-title="<?php echo e(__('Create New Sales Target')); ?>"
            data-url="<?php echo e(route('branchsalestargets.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Sales Target')); ?>"
            data-title="<?php echo e(__('Sales Target')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('stylesheets'); ?>

<?php $__env->stopPush(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Settings')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Branch Sales Target')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Branch Sales Target')): ?>

        <?php if(!empty($saletarget) && count($saletarget) > 0): ?>
            <div class="min-vh-78 mt-3">
                <?php $__currentLoopData = $saletarget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0 h6"><?php echo e($target['month']); ?></h3>
                                        </div>
                                        <div class="col text-end">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Branch Sales Target')): ?>
                                                <div class="action-btn btn-info ms-2">
                                                    <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                        data-title="<?php echo e(__('Edit Sales Target')); ?>" title="<?php echo e(__('Edit')); ?>"
                                                        data-url="<?php echo e(route('branchsalestargets.edit', $target['id'])); ?>"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Branch Sales Target')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <a href="#"
                                                        class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-toggle="sweet-alert" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                        data-confirm-yes="delete-form-<?php echo e($target['id']); ?>">
                                                        <i class="ti ti-trash text-white" title="<?php echo e(__('Delete')); ?>"></i>
                                                    </a>
                                                </div>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['branchsalestargets.destroy', $target['id']], 'id' => 'delete-form-' . $target['id']]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table align-items-center mb-0 ">
                                        <thead class="thead-light">
                                            <tr class="border-top-0">
                                                <th class="w-25"><?php echo e(__('Branch Name')); ?></th>
                                                <th class="w-25"><?php echo e(__('Target')); ?></th>
                                                <th class="w-25"><?php echo e(__('Sales')); ?></th>
                                                <th class="w-25"><?php echo e(__('Progress')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <?php if(isset($target['branch']) && !empty($target['branch'] && count($target['branch']) > 0)): ?>
                                                <?php for($i = 0; $i < count($target['branch']); $i++): ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <span
                                                                        class="name mb-0 text-sm"><?php echo e($target['branch'][$i]); ?></span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="budget">
                                                            <?php echo e($target['totaltarget'][$i]); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($target['totalselledprice'][$i]); ?>

                                                        </td>
                                                        <td class="circular-progressbar p-0">
                                                            <?php
                                                            $percentage = $target['percentage'][$i];
                                                            
                                                            $status = $percentage > 0 && $percentage <= 25 ? 'red' : ($percentage > 25 && $percentage <= 50 ? 'orange' : ($percentage > 50 && $percentage <= 75 ? 'blue' : ($percentage > 75 && $percentage <= 100 ? 'green' : '')));
                                                            ?>
                                                            <div class="flex-wrapper">
                                                                <div class="single-chart">
                                                                    <svg viewBox="0 0 36 36"
                                                                        class="circular-chart <?php echo e($status); ?>">
                                                                        <path class="circle-bg" d="M18 2.0845
                                                                                  a 15.9155 15.9155 0 0 1 0 31.831
                                                                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <path class="circle"
                                                                            stroke-dasharray="<?php echo e($percentage); ?>, 100" d="M18 2.0845
                                                                                  a 15.9155 15.9155 0 0 1 0 31.831
                                                                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <text x="18" y="20.35"
                                                                            class="percentage"><?php echo e($percentage); ?>%</text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="row min-vh-78">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="mb-0"><?php echo e(__('No Target Records Found.')); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/branchsalestargets/index.blade.php ENDPATH**/ ?>