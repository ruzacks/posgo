<?php $__env->startSection('page-title', __('Coupons') ); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Coupons')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Coupon')): ?>
        <a class="btn btn-sm btn-primary btn-icon m-1"  data-bs-toggle="tooltip"
            data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Add New Coupon')); ?>" data-url="<?php echo e(route('coupons.create')); ?>" title="<?php echo e(__('Add Coupon')); ?>"> <i class="ti ti-plus text-white"></i></a>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
         <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('Coupons')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Coupon')): ?>
        <div class="row">
            <div class="col-xl-12">
                
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                       
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple" role="grid">
                                <thead>
                                <tr>
                                    <th> <?php echo e(__('Name')); ?></th>
                                    <th> <?php echo e(__('Code')); ?></th>
                                    <th> <?php echo e(__('Discount (%)')); ?></th>
                                    <th> <?php echo e(__('Limit')); ?></th>
                                    <th> <?php echo e(__('Used')); ?></th>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($coupon->name); ?></td>
                                        <td><?php echo e($coupon->code); ?></td>
                                        <td><?php echo e($coupon->discount); ?></td>
                                        <td><?php echo e($coupon->limit); ?></td>
                                        <td><?php echo e($coupon->used_coupon()); ?></td>
                                        <td class="Action">

                                            <div class="action-btn btn-warning ms-2">
                                            <a href="<?php echo e(route('coupons.show',$coupon->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title='show'>
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                           </div>  


                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Coupon')): ?>
                                            <div class="action-btn btn-info ms-2">
                                                <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip" title='edit' data-title="<?php echo e(__('Edit Coupon')); ?>" title="<?php echo e(__('Edit')); ?>" data-size="md" data-url="<?php echo e(route('coupons.edit', $coupon->id)); ?>"
                                                   class="mx-3 btn btn-sm d-inline-flex align-items-center"><i class="ti ti-pencil text-white"> </i></a>
                                               </div>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Coupon')): ?>
                                             <div class="action-btn bg-danger ms-2">
                                                <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="Delete"  data-toggle="sweet-alert"
                                                   data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                   data-confirm-yes="delete-form-<?php echo e($coupon->id); ?>" title="<?php echo e(__('Delete')); ?>">
                                                    <i class="ti ti-trash text-white"></i>
                                                </a>


                                            </div>  
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id],'id' => 'delete-form-'.$coupon->id]); ?>

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
        $(document).ready(function () {

            $(document).on('keypress keydown keyup', '.coupon-discount, .coupon-limit', function () {
                if ($(this).val() > 100 && $(this).hasClass('coupon-discount')) {
                    $(this).val('100');
                } else if ($(this).val() < 0 || $(this).val() == '') {
                    $(this).val('0');
                } else {
                }
            });

            $(document).on('click', '.code', function () {
                var type = $(this).val();
                if (type == 'manual') {
                    $('#manual').removeClass('d-none').addClass('d-block');
                    $('#auto').removeClass('d-block').addClass('d-none');
                } else {
                    $('#auto').removeClass('d-none').addClass('d-block');
                    $('#manual').removeClass('d-block').addClass('d-none');
                }
            });

            $(document).on('click', '#code-generate', function () {
                var length = 10;
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                $('#auto-code').val(result);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/coupons/index.blade.php ENDPATH**/ ?>