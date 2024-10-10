<?php $__env->startSection('page-title', __('Tax Report')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Tax Report')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Reports')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Tax Report')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('old-datatable-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/customdatatable.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Tax')): ?>




    <?php $__env->startSection('content'); ?>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="setting-tab">
                            

                            <div class="p-3 card">
                                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchases')): ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-user-tab-1" href="#manage-purchases" data-bs-toggle="pill"
                                            data-bs-toggle="#pills-user-1"><?php echo e(__('Purchases')); ?></a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-user-tab-2" href="#manage-sales" data-bs-toggle="pill"
                                            data-bs-toggle="#pills-user-2"><?php echo e(__('Sales')); ?></a>
                                    </li>
                                    <?php endif; ?>
                                  
                                </ul>
                            </div>


                            <div class="tab-content">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchases')): ?>
                                    <div class="tab-pane fade show active" id="manage-purchases" role="tabpanel">
                                        <div class="row justify-content-md-center">
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card text-white btn-gradient-info">
                                                    <div class="card-header total-purchased-amount"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title text-white"><?php echo e(__('Purchased Amount')); ?></h5>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6">
                                                <div class="card text-white btn-gradient-secondary">
                                                    <div class="card-header total-purchased-product-tax-amount"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title text-white"><?php echo e(__('Product Tax Amount')); ?></h5>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card collapse multi-collapse-purchase">
                                                    <div class="card-body p-3 shadow-sm">
                                                        <div
                                                            class="row input-daterange purchase-analysis-datepicker align-items-center">
                                                            <div class="form-group col-md-3 mb-0">
                                                                <?php echo e(Form::label('duration1', __('Date Duration'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group"  style="width: 751px;">
                                                                    


                                                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                                                        <input type='text' class="form-control"
                                                                            id="pc-daterangepicker-1" placeholder="Select time"
                                                                            type="text" />
                                                                        <?php echo e(Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1'])); ?>

                                                                        <?php echo e(Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1'])); ?>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0">
                                                                <?php echo e(Form::label('vendor_id', __('Vendor'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('vendor_id', $vendors, null, ['class' => 'form-control','id' => 'vendor_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                                                <?php echo e(Form::label('purchase_branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('purchase_branch_id', $branches, null, ['class' => 'form-control','id' => 'purchase_branch_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                                                <?php echo e(Form::label('purchase_cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('purchase_cash_register_id', $cash_registers, null, ['class' => 'form-control','id' => 'purchase_cash_register_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="mb-0 h5 float-left"><?php echo e(__('Purchase Tax Report')); ?></h3>
                                                        <button type="button"
                                                            class="float-right btn btn-sm btn-primary btn-icon m-1"
                                                            data-bs-toggle="collapse" data-bs-target=".multi-collapse-purchase"
                                                            title="<?php echo e(__('Filter')); ?>">
                                                            <i class="ti ti-filter text-white"></i>
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12 table-responsive" id="myTable">
                                                                <table class="table dataTable purchase_myTable " role="grid">
                                                                    <thead class="thead-light">
                                                                        <tr role="row">
                                                                            <th><?php echo e(__('Reference No.')); ?></th>
                                                                            <th><?php echo e(__('Date')); ?></th>
                                                                            <th><?php echo e(__('Vendor')); ?></th>
                                                                            <th><?php echo e(__('Product Tax')); ?></th>
                                                                            <th><?php echo e(__('Grand Total')); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1">
                                                                                <h5 class="h6"
                                                                                    id="totalpurchasetaxamount"></h5>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1">
                                                                                <h5 class="h6"
                                                                                    id="totalpurchasesubtotal"></h5>
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
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                                    <div class="nav-link fade" id="manage-sales" role="tabpanel">
                                        <div class="row justify-content-md-center">
                                            <div class="col-xl-2 col-md-6">
                                                
                                                <div class="card text-white btn-gradient-info">
                                                    <div class="card-header total-saled-amount"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title text-white"><?php echo e(__('Sales Amount')); ?></h5>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6">
                                               <div class="card text-white btn-gradient-secondary">
                                                    <div class="card-header total-saled-product-tax-amount"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title text-white"><?php echo e(__('Product Tax Amount')); ?></h5>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="card collapse multi-collapse-sale">
                                                    <div class="card-body p-3 shadow-sm">
                                                        <div
                                                            class="row input-daterange sale-analysis-datepicker align-items-center">
                                                            <div class="form-group col-md-3 mb-0">
                                                                <?php echo e(Form::label('duration1', __('Date Duration'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group"  style="width: 751px;">
                                                                    

                                                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                                                        <input type='text' class="form-control"
                                                                            id="pc-daterangepicker-2" placeholder="Select time"
                                                                            type="text" />
                                                                        <?php echo e(Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1'])); ?>

                                                                        <?php echo e(Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1'])); ?>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0">
                                                                <?php echo e(Form::label('customer_id', __('Customer'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('customer_id', $customers, null, ['class' => 'form-control','id' => 'customer_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                                                <?php echo e(Form::label('sale_branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('sale_branch_id', $branches, null, ['class' => 'form-control','id' => 'sale_branch_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                                                <?php echo e(Form::label('sale_cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                                                                <div class="input-group">
                                                                    <?php echo e(Form::select('sale_cash_register_id', $cash_registers, null, ['class' => 'form-control','id' => 'sale_cash_register_id','data-toggle' => 'select'])); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="mb-0  h5 float-left"><?php echo e(__('Sale Tax Report')); ?></h3>
                                                        <a class="float-right btn btn-sm btn-primary btn-icon m-1"
                                                            data-bs-toggle="collapse" data-bs-target=".multi-collapse-sale"
                                                            title="<?php echo e(__('Filter')); ?>">
                                                            <i class="ti ti-filter text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12 table-responsive" id="myTable2">
                                                                <table class="table dataTable sale_myTable2" role="grid">
                                                                    <thead class="thead-light">
                                                                        <tr role="row">
                                                                            <th><?php echo e(__('Reference No.')); ?></th>
                                                                            <th><?php echo e(__('Date')); ?></th>
                                                                            <th><?php echo e(__('Customer')); ?></th>
                                                                            <th><?php echo e(__('Product Tax')); ?></th>
                                                                            <th><?php echo e(__('Grand Total')); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1"></td>
                                                                            <td rowspan="1" colspan="1">
                                                                                <h5 class="h6" id="totalsaletaxamount">
                                                                                </h5>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1">
                                                                                <h5 class="h6" id="totalsalesubtotal">
                                                                                </h5>
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
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        if (typeof ajax_product_purchase_tax_analysis_filter == 'function') {
                            ajax_product_purchase_tax_analysis_filter();
                        }
                    }
                }
            });
        </script>
    <?php $__env->stopPush(); ?>



    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
        <script>
            document.querySelector("#pc-daterangepicker-2").flatpickr({
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
                        if (typeof ajax_product_sale_tax_analysis_filter == 'function') {
                            ajax_product_sale_tax_analysis_filter();
                        }
                    }
                }
            });
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>
        <script type="text/javascript">
            function ajax_product_purchase_tax_analysis_filter() {

                var data = {
                    'start_date': $('#purchased-start-date').val(),
                    'end_date': $('#purchased-end-date').val(),
                    'branch_id': $('#purchase_branch_id').val(),
                    'cash_register_id': $('#purchase_cash_register_id').val(),
                }

                $('#myTable .purchase_myTable').DataTable({
                        "destroy": true,
                        "paging": true,
                        "ordering": false,
                        "processing": true,
                        "pageLength": 10,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": '<?php echo e(route('product.purchase.tax.analysis.filter')); ?>',
                            "data": data,
                        },
                        "columns": [{
                                "data": "invoice_id"
                            },
                            {
                                "data": "created_at"
                            },
                            {
                                "data": "vendorname"
                            },
                            {
                                "data": "tax_amount"
                            },
                            {
                                "data": "sub_total"
                            },
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalpurchasetaxamount').text(json.totalPurchasedTaxAmount);
                        $('#totalpurchasesubtotal, .total-purchased-amount').text(json.totalPurchasedSubTotal);
                        $('.total-purchased-product-tax-amount').text(json.totalPurchasedTaxAmount);
                    });
            }

            // $(function () {
            //     function cb(start, end) {
            //         $("#duration1").val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            //         $('#purchased-start-date').val(start.format('YYYY-MM-DD'));
            //         $('#purchased-end-date').val(end.format('YYYY-MM-DD'));
            //         ajax_product_purchase_tax_analysis_filter();
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
            //                 '<?php echo e(__('Sat')); ?>'
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


            function ajax_product_sale_tax_analysis_filter() {

                var data = {
                    'start_date': $('#sale-start-date').val(),
                    'end_date': $('#sale-end-date').val(),
                    'branch_id': $('#sale_branch_id').val(),
                    'cash_register_id': $('#sale_cash_register_id').val(),
                }

                $('#myTable2 .sale_myTable2').DataTable({
                        "destroy": true,
                        "paging": true,
                        "ordering": false,
                        "processing": true,
                        "pageLength": 10,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": '<?php echo e(route('product.sale.tax.analysis.filter')); ?>',
                            "data": data,
                        },
                        "columns": [{
                                "data": "invoice_id"
                            },
                            {
                                "data": "created_at"
                            },
                            {
                                "data": "customername"
                            },
                            {
                                "data": "tax_amount"
                            },
                            {
                                "data": "sub_total"
                            },
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalsaletaxamount').text(json.totalSaledTaxAmount);
                        $('#totalsalesubtotal, .total-saled-amount').text(json.totalSaledSubTotal);
                        $('.total-saled-product-tax-amount').text(json.totalSaledTaxAmount);
                    });
            }

            // $(function () {
            //     function cb(start, end) {
            //         $("#sale-duration").val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            //         $('#sale-start-date').val(start.format('YYYY-MM-DD'));
            //         $('#sale-end-date').val(end.format('YYYY-MM-DD'));
            //         ajax_product_sale_tax_analysis_filter();
            //     }

            //     $('#sale-duration').daterangepicker({
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
            //                 '<?php echo e(__('Sat')); ?>'
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

                // $('[data-toggle="select"]').select2({});
                $('#purchase_cash_register_id, #vendor_id').trigger('change');
                ajax_product_purchase_tax_analysis_filter();

            });

            $(document).on('change', '#purchase_cash_register_id, #vendor_id', function(e) {

                ajax_product_purchase_tax_analysis_filter();
            });

            $(document).on('change', '#purchase_branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
                    async: false,
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#purchase_cash_register_id').find('option').not(':first').remove();
                        $.each(data, function(key, value) {
                            $('#purchase_cash_register_id')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.name));
                        });
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });

                ajax_product_purchase_tax_analysis_filter();
            });

            $(document).on('change', '#sale_cash_register_id, #customer_id', function(e) {

                ajax_product_sale_tax_analysis_filter();
            });

            $(document).on('change', '#sale_branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
                    async: false,
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#sale_cash_register_id').find('option').not(':first').remove();
                        $.each(data, function(key, value) {
                            $('#sale_cash_register_id')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.name));
                        });
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });

                ajax_product_sale_tax_analysis_filter();
            });

            $(document).on('click', '[href="#manage-sales"]', function(e) {

                if (!$(this).hasClass('sale-active')) {
                    ajax_product_sale_tax_analysis_filter();
                    $(this).addClass('sale-active');
                }
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/reports/tax-analysis.blade.php ENDPATH**/ ?>