<?php $__env->startSection('page-title', __('Products List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Products List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Product')): ?>
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Add New Product')); ?>"
            data-title="<?php echo e(__('Add New Product')); ?>" data-url="<?php echo e(route('products.create')); ?>"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Product')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Product')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="w-25"><?php echo e(__('Name')); ?></th>
                                        <th><?php echo e(__('Category')); ?></th>
                                        <th><?php echo e(__('Stock')); ?></th>
                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="text" id="nameFilter" class="form-control" placeholder="<?php echo e(__('Enter name')); ?>"></td>
                                        <td><input type="text" id="categoryFilter" class="form-control" placeholder="<?php echo e(__('Enter category name')); ?>"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td class="name-cell"><span class="break-all"><?php echo e($product->name); ?></span></td>
                                            <td class="category-cell"><?php echo e($product->categoryname); ?></td>
                                            <td>
                                                <?php if($product->is_stock): ?>
                                                    <?php if($product->getTotalProductQuantity() > \App\Models\Utility::settings()['low_product_stock_threshold']): ?>
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded"><?php echo e($product->quantity); ?></span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-danger p-2 px-3 rounded"><?php echo e($product->quantity); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right">
                                                <div class="d-flex justify-content-start align-items-center gap-2">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Product')): ?>
                                                        <div class="action-btn btn-info">
                                                            <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                               data-title="<?php echo e(__('Edit Product')); ?>" title="<?php echo e(__('Edit Product')); ?>"
                                                               data-size="lg" data-url="<?php echo e(route('products.edit', $product->id)); ?>"
                                                               class="btn btn-sm d-inline-flex align-items-center edit-product">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Product')): ?>
                                                        <div class="action-btn bg-danger">
                                                            <a href="#" class="bs-pass-para btn btn-sm d-inline-flex align-items-center"
                                                               data-toggle="sweet-alert" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                               data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                               data-confirm-yes="delete-form-<?php echo e($product->id); ?>"
                                                               data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['products.destroy', $product->id], 'id' => 'delete-form-' . $product->id]); ?>

                                                            <?php echo Form::close(); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($product->categoryname == 'PAKET'): ?>
                                                        <div class="action-btn bg-primary">
                                                            <a class="btn btn-sm d-inline-flex align-items-center" href="<?php echo e(route('update.package', $product->id)); ?>"
                                                                data-bs-toggle="tooltip" title="<?php echo e(__('Edit Package')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
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
    <script src="<?php echo e(asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/jquery-barcode.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/jquery-barcode.js')); ?>"></script>
    <script>
        $(document).on('click', '.add-poduct, .edit-product', function() {
            setTimeout(function() {
                img_display();
            }, 1000);
        });

        $(document).on('click', '.product-img-btn', function() {
            $('input[name="imgstatus"]').val(1);
            $(this).closest('#product-image').find('img').attr("src", "");
            $(this).closest('#product-image').find('button').addClass('d-none');
        });
        
        $(document).ready(function() {
            $(".product_barcode").each(function() {
                var id = $(this).attr("id");
                var sku = $(this).data('skucode');
                generateBarcode(sku, id);
            });
        });

        function generateBarcode(val, id) {
            var value = val;
            var btype = '<?php echo e($barcode['barcodeType']); ?>';
            var renderer = '<?php echo e($barcode['barcodeFormat']); ?>';
            var settings = {
                output: renderer,
                bgColor: '#FFFFFF',
                color: '#000000',
                barWidth: '1',
                barHeight: '50',
                moduleSize: '5',
                posX: '10',
                posY: '20',
                addQuietZone: '1'
            };
            $('#' + id).html("").show().barcode(value, btype, settings);

        }

        $(document).on('change', 'input[name="sku"]', function() {
            var str = $(this).val();
            if (str !== '') {
                var val = is_Dash(str);
                if (val == false) {
                    show_toastr("<?php echo e(__('Error')); ?>", "Please enter a valid sku format.(use ' - ' in sku code)",
                        'error');
                }
            }
        });

        function img_display() {
            if ($('#product-image img.profile-image').attr('src') == undefined) {
                $("#product-image img.profile-image").addClass('d-none');
            } else {
                $("#product-image img.profile-image").removeClass('d-none');
            }

        }

        function is_Dash(str) {
            regexp = /[\-]+/i;

            if (regexp.test(str)) {
                return true;
            } else {
                return false;
            }
        }

        function applyFilters() {
            let categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
            let nameFilter = document.getElementById('nameFilter').value.toLowerCase();
            let rows = document.querySelectorAll('#pc-dt-simple tbody tr');

            rows.forEach(row => {
                let category = row.querySelector('.category-cell').textContent.toLowerCase();
                let name = row.querySelector('.name-cell').textContent.toLowerCase();

                // Display the row only if it matches both filters
                row.style.display = (category.includes(categoryFilter) && name.includes(nameFilter)) ? '' : 'none';
            });
        }

        document.getElementById('categoryFilter').addEventListener('keyup', applyFilters);
        document.getElementById('nameFilter').addEventListener('keyup', applyFilters);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/products/index.blade.php ENDPATH**/ ?>