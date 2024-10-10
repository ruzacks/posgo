<?php $__env->startSection('page-title', __('Quotations')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Quotations')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>

    <a href="<?php echo e(route('Quotation.export')); ?>" class="btn btn-sm btn-primary btn-icon " data-bs-toggle="tooltip"
        title="<?php echo e(__('Export')); ?>">
        <i class="ti ti-file-export text-white"></i>
    </a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Quotations')): ?>
        <a href="<?php echo e(route('quotations.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Add Quotation')); ?>"
            class="btn btn-sm btn-primary btn-icon m-1"><span class=""><i
                    class="ti ti-plus text-white"></i></span></a>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Quotations')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Quotations')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Due Date')); ?></th>
                                        <th><?php echo e(__('Reference No')); ?></th>
                                        <th><?php echo e(__('Customer Name')); ?></th>
                                        <th><?php echo e(__('Customer Email')); ?></th>
                                        <th><?php echo e(__('Grand Total')); ?></th>
                                        <th><?php echo e(__('Email')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($quotation->date)); ?></td>
                                            <td><?php echo e($quotation->reference_no); ?></td>
                                            <td><?php echo e($quotation->customer != null ? ucfirst($quotation->customer->name) : __('Walk-in Customer')); ?>

                                            </td>
                                            <td><?php echo e($quotation->customer_email); ?></td>
                                            <td><?php echo e(Auth::user()->priceFormat($quotation->getTotal())); ?></td>
                                            <td>
                                                <a href="#" class="badge bg-info p-2 px-3" id="resend-quotation"
                                                    data-id="<?php echo e($quotation->id); ?>"
                                                    data-mail="<?php echo e($quotation->customer_email); ?>"
                                                    title="<?php echo e(__('To resend quotation to customer')); ?>"><?php echo e(__('Resend')); ?></a>
                                            </td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Quotations')): ?>
                                                    <div class="nav-item dropdown display-quotation"
                                                        data-li-id="<?php echo e($quotation->id); ?>">
                                                        
                                                        <span data-bs-toggle="dropdown"
                                                            class="badge badge-lg  py-2 px-3  quotation-label  quotation-<?php echo e($quotation->status == 0 ? 'open' : 'close'); ?> bg-<?php echo e($quotation->status == 0 ? 'success' : 'danger'); ?> "
                                                            aria-expanded="false"><?php echo e($quotation->status == 0 ? __('Open') : __('Close')); ?></span>

                                                        <div
                                                            class="dropdown-menu dropdown-list quotation-status dropdown-menu-right">
                                                            <div class="dropdown-list-content quotation-actions"
                                                                data-id="<?php echo e($quotation->id); ?>"
                                                                data-url="<?php echo e(route('update.quotation.status', $quotation->id)); ?>">
                                                                <a href="#" data-status="0" data-class="bg-success"
                                                                    class="dropdown-item quotation-action <?php echo e($quotation->status == 0 ? 'selected' : ''); ?>"><?php echo e(__('Open')); ?>

                                                                </a>
                                                                <a href="#" data-status="1" data-class="bg-danger"
                                                                    class="dropdown-item quotation-action <?php echo e($quotation->status == 1 ? 'selected' : ''); ?>"><?php echo e(__('Close')); ?>

                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="Action">
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="<?php echo e(route('get.quotation.invoice', Crypt::encrypt($quotation->id))); ?>"
                                                        data-bs-toggle="tooltip" target="_blank"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        title="<?php echo e(__('Download')); ?>">
                                                        <i class="ti ti-download text-white"></i>
                                                    </a>
                                                </div>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Quotations')): ?>
                                                    <div class="action-btn btn-info ms-2">
                                                        <a href="<?php echo e(route('quotations.edit', $quotation->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Quotations')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-toggle="sweet-alert" title="<?php echo e(__('Delete')); ?>"
                                                            data-bs-toggle="tooltip" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($quotation->id); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['quotations.destroy', $quotation->id], 'id' => 'delete-form-' . $quotation->id]); ?>

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
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#resend-quotation', function(e) {
                e.preventDefault();
                var ele = $(this);

                $.ajax({
                    url: '<?php echo e(route('resend.quotation')); ?>',
                    method: "patch",
                    data: {
                        quotation_id: $(this).data('id'),
                        customer_email: $(this).data('mail'),
                    },
                    beforeSend: function() {
                        ele.prop("disabled", true);
                        ele.text('<?php echo e(__('Processing...')); ?>');
                    },
                    success: function(response) {
                        if (response.code == '200') {
                            show_toastr('Success', response.success, 'success')
                        }
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    },
                    complete: function() {
                        ele.prop("disabled", false);
                        ele.text('<?php echo e(__('Resend')); ?>');
                    }
                });
            });

            $(document).on('click', '.quotation-action', function(e) {
                e.stopPropagation();
                e.preventDefault();

                var ele = $(this);

                var id = ele.parent().attr('data-id');
                var url = ele.parent().attr('data-url');
                var status = ele.attr('data-status');

                $.ajax({
                    url: url,
                    method: 'PATCH',
                    data: {
                        status: status
                    },
                    success: function(response) {

                        if (response) {

                            $('[data-li-id="' + id + '"] .quotation-action').removeClass(
                                'selected');

                            if (ele.hasClass('selected')) {

                                ele.removeClass('selected');

                            } else {
                                ele.addClass('selected');
                            }

                            var quotation = $('[data-li-id="' + id + '"] .quotation-actions')
                           
                                .find('.selected').text().trim();

                            var quotation_class = $('[data-li-id="' + id +
                                '"] .quotation-actions').find('.selected').attr(
                                'data-class');
                            $('[data-li-id="' + id + '"] .quotation-label').removeClass(
                                    'quotation-open quotation-close').addClass(quotation_class)
                                .text(quotation);
                        }
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/quotations/index.blade.php ENDPATH**/ ?>