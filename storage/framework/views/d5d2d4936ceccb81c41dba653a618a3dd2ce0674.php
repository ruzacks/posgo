<?php $__env->startSection('page-title', __('Expense Analysis')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Expense Analysis')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <a class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="collapse" data-bs-toggle="tooltip"
        title="<?php echo e(__('Filter')); ?>" data-title="<?php echo e(__('Filter')); ?>" data-bs-target=".multi-collapse">
        <i class="ti ti-filter text-white"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('old-datatable-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/customdatatable.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Reports')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Expense Analysis')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
    <script>
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            onChange: function(selectedDates, dateStr, instance) {
                var dates = dateStr.split(" to ");
                var start = moment(dates[0]).format('YYYY-MM-DD');
                var end = moment(dates[0]).format('YYYY-MM-DD');
                $('#start_date1').val(start);
                $('end_date1').val(end);
                if (dates.length == 1) {
                    var end = moment(dates[1]).format('YYYY-MM-DD');
                    $('end_date1').val(end);
                    if (typeof ajax_product_expense_analysis_filter == 'function') {
                        ajax_product_expense_analysis_filter();
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Expense')): ?>

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card collapse multi-collapse">
                    <div class="card-body py-3">
                        <div class="row input-daterange analysis-datepicker align-items-center">
                            <div class="form-group col-md-4 mb-0">
                                <?php echo e(Form::label('duration1', __('Date Duration'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group" style="width: 1052px;">
                                    


                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type='text' class="form-control" id="pc-daterangepicker-1"
                                            placeholder="Select time" type="text" />
                                        <?php echo e(Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1'])); ?>

                                        <?php echo e(Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1'])); ?>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-md-4  mb-0">
                                <?php echo e(Form::label('expense_category_id', __('Expense Category'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control','id' => 'expense_category_id','data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-4  mb-0 <?php echo e($display_status); ?>">
                                <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control','id' => 'branch_id','data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-report-money"></i>
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3 mb-sm-0">
                                        <small class="text-muted">Total Expense Amount</small>
                                        <h3 class="m-0" id="totalexpenseamount"></h3>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="card table-card">
                    <div class="card-header card-body table-border-style">
                        
                        <div class="col-sm-12 table-responsive table_over" id="expense-analysis-datatable">
                            <table class="table dataTable expense-analysis-datatable" role="grid">
                                <thead class="thead-light">
                                    <tr role="row">
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Expense Category')); ?></th>
                                        <th><?php echo e(__('Note')); ?></th>
                                        <th><?php echo e(__('Created by')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tfoot>
                                    <tr>
                                        <td rowspan="1" colspan="1">
                                            <h5 class="h6"><?php echo e(__('Grand Total')); ?></h5>
                                        </td>
                                        <td rowspan="1" colspan="1"></td>
                                        <td rowspan="1" colspan="1"></td>
                                        <td rowspan="1" colspan="1"></td>
                                        <td rowspan="1" colspan="1">
                                            <h5 class="h6" id="totalexpenseamount"></h5>
                                        </td>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>
        <script type="text/javascript">
            function ajax_product_expense_analysis_filter() {

                var data = {
                    'start_date': $('#start-date').val(),
                    'end_date': $('#end-date').val(),
                    'expense_category_id': $('#expense_category_id').val(),
                    'branch_id': $('#branch_id').val(),
                }

                $('#expense-analysis-datatable .expense-analysis-datatable').DataTable({
                        "destroy": true,
                        "paging": true,
                        "ordering": false,
                        "processing": true,
                        "pageLength": 10,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": '<?php echo e(route('expense.analysis.filter')); ?>',
                            "data": data,
                        },
                        "columns": [{
                                "data": "date"
                            },
                            {
                                "data": "expense_category"
                            },
                            {
                                "data": "note"
                            },
                            {
                                "data": "created_by"
                            },
                            {
                                "data": "amount"
                            },
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalexpenseamount').html(json.totalExpenseAmount);
                    });
            }

            // $(function() {
            //     function cb(start, end) {
            //         $("#duration1").val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            //         $('input[name="start_date1"]').val(start.format('YYYY-MM-DD'));
            //         $('input[name="due_date1"]').val(end.format('YYYY-MM-DD'));
            //         ajax_product_expense_analysis_filter();
            //     }

            //     $('#duration1').daterangepicker({
            //         // timePicker: true,
            //         autoApply: true,
            //         autoclose: true,
            //         autoUpdateInput: false,
            //         // startDate: start,
            //         // endDate: end,
            //         locale: {
            //             format: 'MMM D, YY hh:mm A',
            //             applyLabel: "Apply",
            //             cancelLabel: "Cancel",
            //             fromLabel: "From",
            //             toLabel: "To",
            //             daysOfWeek: [
            //                 '<?php echo e(__('Sun')); ?>',
            //                 '<?php echo e(__('Mon')); ?>',
            //                 '<?php echo e(__('Tue')); ?>',
            //                 '<?php echo e(__('Wed')); ?>',
            //                 '<?php echo e(__('Thu')); ?>',
            //                 '<?php echo e(__('Fri')); ?>',
            //                 '<?php echo e(__('Sat')); ?>',
            //             ],
            //             monthNames: [
            //                 '<?php echo e(__('January')); ?>',
            //                 '<?php echo e(__('February')); ?>',
            //                 '<?php echo e(__('March')); ?>',
            //                 '<?php echo e(__('April')); ?>',
            //                 '<?php echo e(__('May')); ?>',
            //                 '<?php echo e(__('June')); ?>',
            //                 '<?php echo e(__('July')); ?>',
            //                 '<?php echo e(__('August')); ?>',
            //                 '<?php echo e(__('September')); ?>',
            //                 '<?php echo e(__('October')); ?>',
            //                 '<?php echo e(__('November')); ?>',
            //                 '<?php echo e(__('December')); ?>'
            //             ],
            //         }
            //     }, cb);
            // });


            $(document).ready(function() {
                ajax_product_expense_analysis_filter();
                $(document).on('change', '#expense_category_id', function(e) {
                    ajax_product_expense_analysis_filter();
                });
            });

            $(document).on('change', '#branch_id', function(e) {

                ajax_product_expense_analysis_filter();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>


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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/reports/expense-analysis.blade.php ENDPATH**/ ?>