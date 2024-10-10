<?php $__env->startSection('page-title', __('Category Analysis')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Category Analysis')); ?></h5>
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
    <li class="breadcrumb-item"><?php echo e(__('Category Analysis')); ?></li>
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
                    if (typeof ajax_product_category_analysis_filter == 'function') {
                        ajax_product_category_analysis_filter();
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Category')): ?>

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card collapse multi-collapse">
                    <div class="card-body  p-3">
                        <div class="row input-daterange analysis-datepicker align-items-center">
                            <div class="form-group col-md-3  mb-0">
                                <?php echo e(Form::label('duration1', __('Date Duration'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group" style="width: 787px;">
                                 
                        
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type='text' class="form-control" id="pc-daterangepicker-1"
                                            placeholder="Select time" type="text" />
                                        <?php echo e(Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1'])); ?>

                                        <?php echo e(Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1'])); ?>

                                    </div>


                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-0">
                                <?php echo e(Form::label('category_id', __('Product Category'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('category_id', $product_categories, null, ['class' => 'form-control','id' => 'category_id','data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control','id' => 'branch_id','data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                                <?php echo e(Form::label('cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('cash_register_id', $cash_registers, null, ['class' => 'form-control','id' => 'cash_register_id','data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row">
                            <div class="col">
                                <div class="card" style="min-height: 92px;">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <div class="theme-avtar bg-info">
                                                    <i class="ti ti-box"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <small class="text-muted"><?php echo e(__('Total Purchased Quantity')); ?></small>
                                                <h6 class="m-0" id="totalpurchasedquantity"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" style="min-height: 92px;">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <div class="theme-avtar bg-info">
                                                    <i class="ti ti-box"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <small class="text-muted"><?php echo e(__('Total Sold Quantity')); ?></small>
                                                <h6 class="m-0" id="totalsoldquantity"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" style="min-height: 92px;">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <small class="text-muted"><?php echo e(__('Total Purchased Price')); ?></small>
                                                <h6 class="m-0" id="totalpurchasedprice"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" style="min-height: 92px;">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <small class="text-muted"><?php echo e(__('Total Sold Price')); ?></small>
                                                <h6 class="m-0" id="totalsoldprice"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" style="min-height: 92px;">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <small class="text-muted"><?php echo e(__('Total Profit/Loss')); ?></small>
                                                <h6 class="m-0" id="totalprofitorloss"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card table-card">
                    <div class="card-header card-body table-border-style">
                        <div class="col-sm-12 table-responsive table_over" id="myTable">
                            <table class="table dataTable category_myTable" role="grid">
                                <thead class="thead-light">
                                    <tr role="row">
                                        <th><?php echo e(__('ID')); ?></th>
                                        <th><?php echo e(__('Name')); ?></th>
                                        <th><?php echo e(__('Purchased Quantity')); ?></th>
                                        <th><?php echo e(__('Sold Quantity')); ?></th>
                                        <th><?php echo e(__('Purchased Price')); ?></th>
                                        <th><?php echo e(__('Sold Price')); ?></th>
                                        <th><?php echo e(__('Profit/Loss')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tfoot>
                                    
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
            function ajax_product_category_analysis_filter() {

                var data = {
                    'start_date': $('#start-date').val(),
                    'end_date': $('#end-date').val(),
                    'category_id': $('#category_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'cash_register_id': $('#cash_register_id').val(),
                }

                $('#myTable .category_myTable').DataTable({
                        "destroy": true,
                        "paging": true,
                        "ordering": false,
                        "processing": true,
                        "pageLength": 10,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": '<?php echo e(route('product.category.analysis.filter')); ?>',
                            "data": data,
                        },
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "purchased_quantity"
                            },
                            {
                                "data": "sold_quantity"
                            },
                            {
                                "data": "purchased_price"
                            },
                            {
                                "data": "sold_price"
                            },
                            {
                                "data": "profitorloss"
                            },
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalpurchasedquantity').text(json.totalPurchasedQuantity);
                        $('#totalpurchasedprice').text(json.totalPurchasedPrice);
                        $('#totalsoldquantity').text(json.totalSoldQuantity);
                        $('#totalsoldprice').text(json.totalSoldPrice);
                        $('#totalprofitorloss').html(json.totalProfitOrLoss);
                    });
            }



            $(document).ready(function() {
                ajax_product_category_analysis_filter();
                $(document).on('change', '#category_id', function(e) {
                    ajax_product_category_analysis_filter();
                });
            });

            $(document).on('change', '#cash_register_id', function(e) {
                ajax_product_category_analysis_filter();
            });

            $(document).on('change', '#branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
                    async: false,
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#cash_register_id').find('option').not(':first').remove();
                        $.each(data, function(key, value) {
                            $('#cash_register_id')
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

                ajax_product_category_analysis_filter();
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/reports/category-analysis.blade.php ENDPATH**/ ?>