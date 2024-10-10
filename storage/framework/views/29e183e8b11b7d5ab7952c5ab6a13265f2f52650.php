<?php $__env->startSection('page-title', __('Returns')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Returns')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>

    <a href="<?php echo e(route('productsreturns.export')); ?>" data-bs-toggle="tooltip" class="btn btn-sm btn-primary btn-icon"
        title="<?php echo e(__('Export')); ?>">
        <i class="ti ti-file-export text-white"></i>
    </a>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Returns')): ?>
        <a href="<?php echo e(route('productsreturn.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Add Return')); ?>"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Product Returns')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('old-datatable-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/customdatatable.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Returns')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card ">
                    <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Reference No')); ?></th>
                                        <th><?php echo e(__('Vendor')); ?></th>
                                        <th><?php echo e(__('Customer')); ?></th>
                                        <th><?php echo e(__('Grand Total')); ?></th>
                                        <th  width="200px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($return->date); ?></td>
                                            <td><?php echo e($return->reference_no); ?></td>
                                            <td><?php echo e($return->vendor != null ? ucfirst($return->vendor->name) : __('Walk-in Vendor')); ?>

                                            </td>
                                            <td><?php echo e($return->customer != null ? ucfirst($return->customer->name) : __('Walk-in Customer')); ?>

                                            </td>
                                            <td><?php echo e(Auth::user()->priceFormat($return->getTotal())); ?></td>
                                            <td class="Action">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Returns')): ?>
                                                    <div class="action-btn btn-info ms-2">
                                                        <a href="<?php echo e(route('productsreturn.edit', $return->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit return')); ?>"
                                                            title="<?php echo e(__('Edit')); ?>"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Returns')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-toggle="sweet-alert" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($return->id); ?>"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i
                                                                class="ti ti-trash text-white"></i>
                                                        </a>
                                                        </a>


                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['productsreturn.destroy', $return->id], 'id' => 'delete-form-' . $return->id]); ?>

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


<?php $__env->startPush('old-datatable-js'); ?>
    <script src="<?php echo e(asset('custom/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
        var dataTabelLang = {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
            zeroRecords: "<?php echo e(__('No data available in table.')); ?>",
            info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
            infoEmpty: "<?php echo e(__('Showing 0 to 0 of 0 entries')); ?>",
            infoFiltered: "<?php echo e(__('(filtered from _MAX_ total entries)')); ?>",
            search: "<?php echo e(__('Search:')); ?>",
            thousands: ",",
            loadingRecords: "<?php echo e(__('Loading...')); ?>",
            processing: "<?php echo e(__('Processing...')); ?>"
        };

        var site_currency_symbol_position = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol_position')); ?>';
        var site_currency_symbol = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol')); ?>';
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/productsreturns/index.blade.php ENDPATH**/ ?>