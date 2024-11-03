{{ Form::open(['url' => 'products', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('code', __('Product Code'), ['class' => 'col-form-label']) }}
            {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter new Product Code'), 'required' => '']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('name', __('Product Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Product Name'), 'required' => '']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('category_id', __('Category'), ['class' => 'col-form-label']) }}
            <div class="input-group">
                {{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'data-toggle' => 'select', 'required' => '']) }}
            </div>
        </div>
        
        <div class="form-group col-md-6">
            {{ Form::label('unit_id', __('Unit'), ['class' => 'col-form-label']) }}
            <div class="input-group">
                {{ Form::select('unit_id', $units, null, ['class' => 'form-control', 'data-toggle' => 'select', 'required' => '']) }}
            </div>
        </div>

        <div class="form-group col-md-6">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::label('is_consigment', __('Consigment'), ['class' => 'col-form-label']) }}
                    <div class="form-check">
                        {{ Form::checkbox('is_consigment', 1, false, ['class' => 'form-check-input', 'id' => 'is_consigment']) }}
                        {{ Form::label('is_consigment', __('Yes'), ['class' => 'form-check-label']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    {{ Form::label('is_stock', __('With Stock'), ['class' => 'col-form-label']) }}
                    <div class="form-check">
                        {{ Form::checkbox('is_stock', 1, false, ['class' => 'form-check-input', 'id' => 'is_stock']) }}
                        {{ Form::label('is_stock', __('Yes'), ['class' => 'form-check-label']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('vendor_id', __('Vendor'), ['class' => 'col-form-label']) }}
            <div class="input-group">
                {{ Form::select('vendor_id', $vendors, null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
            </div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('min_stock', __('Minimum Stock'), ['class' => 'col-form-label']) }}
            {{ Form::number('min_stock', null, ['class' => 'form-control', 'placeholder' => __('Enter new Minimum Stock'), 'step' => '1', 'id' => 'min_stock', 'readonly' => 'readonly']) }}
        </div>
        
        <div class="form-group col-md-6">
            {{ Form::label('max_stock', __('Maximum Stock'), ['class' => 'col-form-label']) }}
            {{ Form::number('max_stock', null, ['class' => 'form-control', 'placeholder' => __('Enter new Maximum Stock'), 'step' => '1', 'id' => 'max_stock', 'readonly' => 'readonly']) }}
        </div>
        
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            {{ Form::label('purchase_price', __('Purchase price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label']) }}
            {{ Form::number('purchase_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Purchase Price'), 'step' => '1000']) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('sale_price', __('Selling price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label']) }}
            {{ Form::number('sale_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Selling Price'), 'step' => '1000']) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('profit', __('Profit'), ['class' => 'col-form-label']) }}
            {{ Form::text('profit', null, ['class' => 'form-control', 'placeholder' => __('0'), 'readonly' => true]) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>
{{ Form::close() }}

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

    function calculateProfit() {
        const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0;
        const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
        const profit = salePrice - purchasePrice;
        document.getElementById('profit').value = profit.toFixed(0); // Display profit with two decimal places
    }

    // Attach event listeners
    document.getElementById('sale_price').addEventListener('keyup', function() {
        calculateProfit();
    });

    document.getElementById('purchase_price').addEventListener('keyup', function() {
        calculateProfit();
    });
</script>
