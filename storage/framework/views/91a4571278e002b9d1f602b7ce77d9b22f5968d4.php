<?php echo e(Form::open(['url' => 'products', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name', __('Product Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Product Name'), 'required' => ''])); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Product Description'), 'rows' => 3, 'style' => 'resize: none']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('category_id', __('Category'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('category_id', $categories, null, ['class' => 'form-control', 'data-toggle' => 'select', 'required' => ''])); ?>

            </div>
        </div>
        
        <div class="form-group col-md-6">
            <?php echo e(Form::label('unit_id', __('Unit'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('unit_id', $units, null, ['class' => 'form-control', 'data-toggle' => 'select', 'required' => ''])); ?>

            </div>
        </div>

        <div class="form-group col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?php echo e(Form::label('is_consigment', __('Consigment'), ['class' => 'col-form-label'])); ?>

                    <div class="form-check">
                        <?php echo e(Form::checkbox('is_consigment', 1, false, ['class' => 'form-check-input', 'id' => 'is_consigment'])); ?>

                        <?php echo e(Form::label('is_consigment', __('Yes'), ['class' => 'form-check-label'])); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo e(Form::label('is_stock', __('With Stock'), ['class' => 'col-form-label'])); ?>

                    <div class="form-check">
                        <?php echo e(Form::checkbox('is_stock', 1, false, ['class' => 'form-check-input', 'id' => 'is_stock'])); ?>

                        <?php echo e(Form::label('is_stock', __('Yes'), ['class' => 'form-check-label'])); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('vendor_id', __('Vendor'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('vendor_id', $vendors, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

            </div>
        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('min_stock', __('Minimum Stock'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('min_stock', null, ['class' => 'form-control', 'placeholder' => __('Enter new Minimum Stock'), 'step' => '0.01', 'id' => 'min_stock', 'readonly' => 'readonly'])); ?>

        </div>
        
        <div class="form-group col-md-6">
            <?php echo e(Form::label('max_stock', __('Maximum Stock'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('max_stock', null, ['class' => 'form-control', 'placeholder' => __('Enter new Maximum Stock'), 'step' => '0.01', 'id' => 'max_stock', 'readonly' => 'readonly'])); ?>

        </div>
        
        <div class="mb-4 col-md-6">
            <div class="choose-files mt-3">
                <label for="image">
                    <div class=" bg-primary edit-product-image"> <i
                            class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                    </div>
                    <input type="file" class="form-control file d-none" name="image" id="image"
                        data-filename="edit-product-image" accept="image/*">
                </label>
            </div>
        </div>
        <div class="col-md-6 my-auto mx-auto">
            <div class="form-group" id="product-image">
                <img class="profile-image rounded-circle-product" > 
                
                <button type="button" class="action-btn btn-danger ms-3 product-img-btn d-none">
                    <i class="ti ti-trash text-white btn-xs mb-1"></i>
                </button>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <?php echo e(Form::label('purchase_price', __('Purchase price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('purchase_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Purchase Price'), 'step' => '0.01'])); ?>

        </div>
        <div class="form-group col-md-4">
            <?php echo e(Form::label('sale_price', __('Selling price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('sale_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Selling Price'), 'step' => '0.01'])); ?>

        </div>
        <div class="form-group col-md-4">
            <?php echo e(Form::label('sku', __('SKU'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('sku', null, ['class' => 'form-control', 'placeholder' => __('Enter new SKU Code')])); ?>

        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>
<?php echo e(Form::close()); ?>


<script>
    document.getElementById('is_stock').addEventListener('change', function() {
        const isStockChecked = this.checked;
        document.getElementById('min_stock').readOnly = !isStockChecked;
        document.getElementById('max_stock').readOnly = !isStockChecked;
    });

    document.getElementById('category_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex].text;
        const isPaket = selectedOption.includes('PAKET');
        const unitElement = document.getElementById('unit_id');
        
        document.getElementById('purchase_price').readOnly = isPaket;
        // document.getElementById('sale_price').readOnly = isPaket;

         // Set and lock unit if "PAKET" is selected
        if (isPaket) {
            const paketOption = Array.from(unitElement.options).find(option => option.text.includes('PAKET'));
            
            if (paketOption) {
                unitElement.value = paketOption.value;
            }

            unitElement.setAttribute('readonly', 'readonly');
        } else {
            unitElement.removeAttribute('readonly');
        }
    });
</script>
<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/products/create.blade.php ENDPATH**/ ?>