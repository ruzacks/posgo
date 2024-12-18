<div class="col-md-9" id="main-col">
    <div class="card">
        <div class="card-header card-body table-border-style">
            <div class="row mb-5">
                <div class="col-md-3">
                    {{ Form::select('', $locationTypes, null, ['class' => 'form-control', 'data-toggle' => 'select', 'id' => 'codeFilter']) }}
                </div>
            </div>

            <div class="table-responsive">
                {{-- <input type="text" id="codeFilter" class="form-control" placeholder="{{ __('Kode Lokasi') }}"> --}}
                <table class="table" style="border: #22242C 1px solid;" id="table-location">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Sale') }}</th>
                            <th>{{ __('Check In') }}</th>
                            {{-- <th>{{ __('Check Out') }}</th> --}}
                            <th>{{ __('Elapsed') }}</th>
                            <th width="200px" class="text-center">{{ __('Action') }}</th>
                        </tr>

                    </thead>
                    <tbody id="location-body">
                        @foreach ($locations as $key => $location)
                            @php
                                // Generate random check-in time within a specific range
                                $randomCheckIn = \Carbon\Carbon::now()
                                    ->subDays(rand(0, 5))
                                    ->setTime(rand(0, 23), rand(0, 59));
                                // Set check-out 2 hours after check-in
                                $randomCheckOut = $randomCheckIn->copy()->addHours(2);
                                // Determine color based on location status
                                $statusColor = '';
                                switch ($location->status) {
                                    case 'occupied':
                                        $statusColor = 'text-success'; // Green for occupied

                                        break;
                                    case 'booked':
                                        $statusColor = 'text-warning'; // Yellow for booked

                                        break;
                                    case 'available':
                                        $statusColor = 'text-info'; // Blue for available
                                        break;
                                    case 'maintenance':
                                        $statusColor = 'text-secondary'; // Gray for maintenance
                                        break;
                                    default:
                                        $statusColor = 'text-muted'; // Default for unknown status
                                        break;
                                }
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="code-cell">{{ $location->code }}</td>
                                <td class="{{ $statusColor }}">{{ $location->status }}</td>
                                <td>
                                    {{ $location->status != 'available' ? Auth::user()->priceFormat($location->getLatestSaleTotal()) : '' }}
                                </td>
                                <td>
                                    {{ $location->status != 'available' ? $location->getLatestSaleCheckIn() : '' }}
                                </td>
                                {{-- <td></td> --}}
                                <td class="elapsed-time" data-start="{{ $location->latestSale && $location->status != 'available' ? $location->latestSale->check_in : '' }}">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        @if ($location->is_active == 1)
                                            {{-- @can('Edit Location')
                                                <div class="action-btn btn-info">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-ajax-popup="true" title="{{ __('Edit Location') }}"
                                                        data-title="{{ __('Edit Location') }}" data-size="lg"
                                                        data-url="{{ route('locations.edit', $location->id) }}"
                                                        data-bs-toggle="tooltip" title="{{ __('Edit Location') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan --}}

                                            <!-- Money Badge Button -->
                                            @if ($location->status == 'available')
                                                <a href="{{ route('sales.index', ['location_id' => $location->id]) }}"
                                                    class="mx-3 btn-sm btn-primary d-inline-flex align-items-center"
                                                    title="{{ __('Transaction') }}">
                                                    check-in</i>
                                                </a>
                                            @elseif($location->getLatestSaleCheckOut() != null)
                                                <a href="{{ route('location.available', ['location_id' => $location->id]) }}"
                                                    class="mx-3 btn-sm btn-warning d-inline-flex align-items-center"
                                                    title="{{ __('Transaction') }}">
                                                    make available</i>
                                                </a>
                                            @else
                                                <a href="#"
                                                    class="mx-3 btn-sm btn-success d-inline-flex align-items-center"
                                                    title="{{ __('Transaction') }}"
                                                    onclick="toggleWindow({{ $location->id }})">
                                                    add-item/check-out</i>
                                                </a>
                                            @endif
                                        @else
                                            <a href="#" class="btn btn-danger btn-sm">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="paymentWindow" class="easyui-window" title="Payment"
    style="width:1024px;height:820px;padding:10px;background: #22242C;color: white;display:none"
    data-options="iconCls:'icon-save',modal:true">
    <div class="easyui-layout" fit="true" style="background: #22242C;">
        <div class="sop-card card form-group p-2">
            <div class="row">
                <div class="col-md-7">
                    <div class="row form-group-window">
                        <label for="invoice_id" class="col-md-3 form-window-label text-white text-right">
                            {{ __('No Invoice') }}
                        </label>
                        <div class="col-md-9">
                            {{ Form::text('invoice_id', '', ['id' => 'invoice_id', 'class' => 'form-control form-window', 'readonly' => true]) }}
                            {{ Form::hidden('sale_id','',['id' => 'sale_id']) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="location" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Location') }}
                        </label>
                        <div class="col-md-9">
                            {{ Form::text('location', '', ['id' => 'location', 'class' => 'form-control form-window', 'readonly' => true]) }}
                            {{ Form::hidden('location_id', '', ['id' => 'location_id']) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="sal_date" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Tanggal') }}
                        </label>
                        <div class="col-md-9">
                            {{ Form::date('sal_date', '', ['id' => 'sal_date', 'class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="check_in" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Check-in') }}
                        </label>
                        <div class="col-md-3">
                            {{ Form::text('check_in', '', ['id' => 'check_in', 'class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                        <label for="check_out" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Check-out') }}
                        </label>
                        <div class="col-md-3">
                            {{ Form::text('check_out', '', ['id' => 'check_out', 'class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="regular-attribute">
                    <div class="label mb-1" id="additional-product-title"></div>
                    {{ Form::label('name', __('Product Name'), ['class' => 'col-form-label', 'hidden' => true]) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Add Product'), 'required' => '']) }}
                    <div id="autocomplete-list" class="autocomplete-items"></div>
                    {{ Form::hidden('product_id', null, ['id' => 'product_id']) }}
                    <div style="max-height: 190px; overflow-y: auto; position: relative;">
                        <table class="table" id="sale_table" style="margin-bottom: 0;">
                            <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="additional-product-body">

                            </tbody>
                            <tbody id="additional-talent-body">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div>
                        <button id="add-talent" class="btn btn-primary">Tambah Talent</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card p-2">
                    <div class="row form-group-window mt-2">
                        <div class="col-md-3">
                                {{ Form::label('pay_type', __('Payment Type')) }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::select('pay_type', ['cash' => __('Cash'), 'card' => __('Card'), 'qris' => 'QRIS', 'trans' => 'Transfer' ,'unpaid' => 'Belum Bayar'], null, ['class' => 'form-control form-window', 'id' => 'pay_type']) }}
                        </div>
                        <div class="col-md-5 text-end">
                            <button class="btn btn-primary" onclick="makePayment()">BAYAR</button>
                            <a class="btn btn-primary" onclick="listPayment()"><i class="ti ti-wallet text-white"></i></a>
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="pay_amount" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Pay Amount') }}
                        </label>
                        <div class="col-md-4">
                            {{ Form::text('pay_amount', '', ['class' => 'form-control form-window', 'id' => 'pay_amount', 'onfocus' => "getUnpaidAmount(this)"]) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="card_number" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Card Number') }}
                        </label>
                        <div class="col-md-4">
                            {{ Form::text('card_number', '', ['class' => 'form-control form-window', 'id' => 'card_number']) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="payment_description" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Description') }}
                        </label>
                        <div class="col-md-9">
                            {{ Form::text('payment_description', '', ['class' => 'form-control form-window', 'id' => 'payment_description']) }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row form-group-window mt-2">
                        <label for="total" class="col-md-6 form-window-label text-white text-right">
                            {{ __('Total') }}
                        </label>
                        <div class="col-md-6">
                            {{ Form::text('total', '', ['class' => 'form-control form-window text-end', 'id' => 'total', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="tax" class="col-md-6 form-window-label text-white text-right">
                            {{ __('Tax') }}
                        </label>
                        <div class="col-md-6">
                            {{ Form::text('tax', '', ['class' => 'form-control form-window text-end', 'id' => 'tax', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="grand_total" class="col-md-6 form-window-label text-white text-right">
                            {{ __('Grand Total') }}
                        </label>
                        <div class="col-md-6">
                            {{ Form::text('grand_total', '', ['class' => 'form-control form-window text-end', 'id' => 'grand_total', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="paid" class="col-md-6 form-window-label text-white text-right">
                            {{ __('Paid') }}
                        </label>
                        <div class="col-md-6">
                            {{ Form::text('paid', '', ['class' => 'form-control form-window text-end', 'id' => 'paid', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window mt-2">
                        <label for="unpaid" class="col-md-6 form-window-label text-white text-right">
                            {{ __('Unpaid') }}
                        </label>
                        <div class="col-md-6">
                            {{ Form::text('unpaid', '', ['class' => 'form-control form-window text-end', 'id' => 'unpaid', 'readonly' => true]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-danger" onclick="toggleWindow()">Close</button>
                <button class="btn btn-primary mx-2" onclick="saveTransaction()">Save</button>
                <button class="btn btn-info" onclick="checkOut()">Check-Out</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Check if the URL contains 'report/sales'
        if (window.location.href.includes('reports/sales')) {
            const mainCol = document.getElementById("main-col");
            if (mainCol) {
                mainCol.className = "col-md-12"; // Replace with col-md-12
            } else {
                console.warn('Element with id="main-col" not found.');
            }
        }
    });

    $(document).ready(function() {
        const parentWindow = $('#paymentWindow').closest('.panel.window');
        const shadow = parentWindow.siblings('.window-shadow');
        const backdrop = $('.window-mask');
        // Make sure the elements are hidden initially
        parentWindow.hide();
        shadow.hide();
        backdrop.hide();

        $(document).ready(function() {
            $('#card_number').inputmask('9999-9999-9999-9999', {
                placeholder: '_'
            });

            $('#pay_amount').inputmask({
                alias: 'numeric',
                groupSeparator: ',',
                autoGroup: true,
                digits: 0, // No decimal places
                decimalProtect: true, // Ensures the decimal separator is ignored
                placeholder: '',
                rightAlign: false,
                clearMaskOnLostFocus: false
            });
        });
    });

    function toggleWindow(locationId = null) {
        const parentWindow = $('#paymentWindow').closest('.panel.window');
        const shadow = parentWindow.siblings('.window-shadow'); // Selects the sibling shadow element
        const backdrop = $('.window-mask'); // The backdrop element

        console.log(locationId);
        $('#additional-product-body').empty();
        $('#invoice_id').val('');
        $('#location').val('');
        $('#sal_date').val('');
        $('#check_in').val('');
        $('#card_number').val('');
        $('#payment_description').val('');
        
        // Toggle the window visibility
        parentWindow.toggle();

        // If the window is visible, show the backdrop
        if (parentWindow.is(':visible')) {
            // Display backdrop
            backdrop.fadeIn(200); // Fade-in effect

            const screenWidth = $(window).width(); // Get the width of the viewport
            const windowWidth = parentWindow.outerWidth(); // Get the width of the window element
            const leftPosition = (screenWidth - windowWidth) / 2; // Calculate horizontal center

            // Set the window and shadow position
            parentWindow.css({
                left: `${leftPosition}px`, // Set horizontal center
                top: '9px', // Maintain the fixed top value
            });

            shadow.css({
                left: `${leftPosition}px`, // Match the shadow position
                top: '9px', // Match the shadow top value
            });

            getPaymentData(locationId);

        } else {
            // Hide backdrop when the window is not visible
            backdrop.fadeOut(200); // Fade-out effect
        }
    }

    function getPaymentData(locationId){
        $.ajax({
                url: "{{ route('getLocation.sale', ':location_id') }}".replace(':location_id', locationId),
                success(response) {
                    // if (response.status == 200) {
                    populatePaymentWindow(response);
                    // }
                }
            });
    }

    function populatePaymentWindow(paymentData) {
        $('#sale_id').val(paymentData.id);
        $('#invoice_id').val(paymentData.invoice_id);
        $('#location').val(paymentData.location_code);
        $('#location_id').val(paymentData.location.id);
        $('#sal_date').val(paymentData.sal_date);
        $('#check_in').val(paymentData.formatted_check_in);
        $('#check_out').val(paymentData.formatted_check_out);
        $('#paid').val(`${paymentData.paid.toLocaleString()}`);
        $('#unpaid').val('0');
        //selled_item
        $('#additional-product-body').empty();
        paymentData.selled_item.forEach(selledItem => {
            const productData = {
                id: selledItem.product_id,
                label: selledItem.product.name, // Name comes from the product object
                sale_price: selledItem.price, // Price comes from selled_item
                unit_name: selledItem.unit, // Unit comes from selled_item
                quantity: selledItem.quantity // Quantity comes from selled_item
            };

            // Call the existing addOrUpdateRow function
            addOrUpdateRow(productData, selledItem.quantity);
        });

        $('#additional-talent-body').empty();

        paymentData.selled_talent.forEach(selledTalent => {
            const talentPrice = selledTalent.talent_price + selledTalent.agency_price + selledTalent.office_price;
            const subtotal = selledTalent.hour * talentPrice;
            const talentData = {
                talent_id: selledTalent.talent_id,
                talent_code: selledTalent.talent.code,
                talent_name: selledTalent.talent.name,
                talent_price: talentPrice,
                talent_quantity: selledTalent.hour,
                subtotal: subtotal
            };

            addTalent(talentData, selledTalent.hour);
        });

    }

    

    function checkOut() {
        event.preventDefault();
        const locationCode = $('#location').val(); // Get the value of the location input

        var unpaid = $('#unpaid').val() || '0';
        unpaid = parseFloat(unpaid.replace('Rp.', '').replace(/,/g, ''));
        
        if (unpaid > 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Please finish payment first!',
                text: 'You cannot proceed until the payment is settled.',
            });
            return; // Prevent further execution if unpaid < 1
        }

        // if (location) {
        //     // Redirect to the check-out URL with the location parameter
        //     window.location.href = `/check-out?location=${encodeURIComponent(location)}`;
        // } else {
        //     alert('Please select a location before proceeding.');
        // }

        $.ajax({
            url: `/check-out?location=${encodeURIComponent(locationCode)}`,  // Replace with your route to handle checkout
            method: 'POST',
            data: {
                location: locationCode,
                _token: '{{ csrf_token() }}'  // Include CSRF token for security
            },
            success: function(response) {
                if (response.status == 200) {
                    swal.fire({
                        icon: 'success',
                        title: 'Checkout Success',
                        text: response.message
                    });
                    location.reload();
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Checkout Failed',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred. Please try again.'
                });
            }
        });
        
    }

    

    function addOrUpdateRow(product, initialQuantity = 1) {
        // Calculate subtotal (assuming 1 quantity for simplicity)
        const tbody = document.getElementById('additional-product-body');
        const existingRow = document.querySelector(`tr[data-product-id="${product.id}"]`);

        if (existingRow) {
            // Update the quantity and subtotal
            const quantityInput = existingRow.querySelector('.input-number');
            const quantity = parseInt(quantityInput.value) + 1; // Increment the quantity by 1
            quantityInput.value = quantity;

            // Update subtotal
            const subtotalElement = existingRow.querySelector('.subtotal');
            const newSubtotal = product.sale_price * quantity;
            subtotalElement.textContent = `Rp.${newSubtotal.toLocaleString()}`;
        } else {
            // Add new row if product doesn't exist in the table
            const quantity = initialQuantity;
            const subtotal = product.sale_price * quantity;

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-product-id', product.id);
            newRow.setAttribute('id', `product-id-${product.id}`);

            if(product.unit_name == 'PAKET'){
                newRow.innerHTML = `
                        <td class="col-sm-2">
                            <span class="name">${product.label}</span>
                        </td>
                        <td class="col-sm-2 text-center">
                            <span class="quantity buttons_added">
                                <input type="number" step="1" min="1" style="color: white" name="quantity" title="Quantity" class="input-number" size="4" 
                                    data-url="/update-cart/" data-id="${product.id}" value="1" readonly>
                            </span>
                        </td>
                        <td class="text-center">
                            ${product.unit_name}
                        </td>
                        <td class="col-sm-2 text-end">
                            <span class="price">Rp.${product.sale_price.toLocaleString()}</span>
                        </td>
                        <td class="col-sm-2 text-end">
                            <span class="subtotal">Rp.${subtotal.toLocaleString()}</span>
                        </td>
                        <td class="text-center">
                           <button 
                                class="btn btn-danger btn-sm delete-btn" 
                                data-id="${product.id}" 
                                data-confirm="Are you sure you want to remove this item?">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    `;
            } else {
                newRow.innerHTML = `
                        <td class="col-sm-2">
                            <span class="name">${product.label}</span>
                        </td>
                        <td class="col-sm-2 text-center">
                            <span class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" style="color: white" name="quantity" title="Quantity" class="input-number" size="4" 
                                    data-url="/update-cart/" data-id="${product.id}" value="${quantity}">
                                <input type="button" value="+" class="plus">
                            </span>
                        </td>
                        <td class="text-center">
                            ${product.unit_name}
                        </td>
                        <td class="col-sm-2 text-end">
                            <span class="price">Rp.${product.sale_price.toLocaleString()}</span>
                        </td>
                        <td class="col-sm-2 text-end">
                            <span class="subtotal">Rp.${subtotal.toLocaleString()}</span>
                        </td>
                        <td class="text-center">
                           <button 
                                class="btn btn-danger btn-sm delete-btn" 
                                data-id="${product.id}" 
                                data-confirm="Are you sure you want to remove this item?">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    `;
            }

            tbody.appendChild(newRow);
        }
        updateDisplayTotal();

        $(document).on('change keyup', '#additional-product-body input[name="quantity"]', function(e) {
            e.preventDefault();
            const $input = $(this);
            const quantity = parseInt($input.val());
            const $row = $input.closest('tr'); // Find the parent row
            const productId = $row.data('product-id');
            const price = parseFloat($row.find('.price').text().replace('Rp.', '').replace(/,/g,
                '')); // Extract price
            const subtotalElement = $row.find('.subtotal');

            if (!isNaN(quantity) && quantity > 0) {
                const newSubtotal = price * quantity;
                subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
            } else {
                $input.val(1); // Reset invalid quantity to 1
            }
            updateDisplayTotal();
        });



        document.addEventListener('click', function(event) {
            if (event.target.closest('.delete-btn')) {
                event.preventDefault();
                const deleteBtn = event.target.closest('.delete-btn');
                const productId = deleteBtn.getAttribute('data-id');
                const confirmText = deleteBtn.getAttribute('data-confirm');
                const formId = `remove-product-${productId}`;

                Swal.fire({
                    title: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove the row from the table
                        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                        if (row) {
                            row.remove();
                        }

                        // Optionally, submit the form if necessary
                        const form = document.getElementById(formId);
                        if (form) {
                            form.submit(); // Submit the form for server-side handling
                        }

                        // Show success message
                        show_toastr('Success', 'The product has been removed.', 'success')

                        // Recalculate the total
                        updateDisplayTotal();
                    }
                });
            }
        });

    }

    let selectedTalentIds = [];


    function saveTransaction() {
        // To get product qty and id
        const productData = [];
        document.querySelectorAll('#additional-product-body tr').forEach(row => {
            const productId = row.dataset.productId;
            const quantityInput = row.querySelector('input[name="quantity"]');
            const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 0;

            if (productId) {
                productData.push({ id: productId, qty: quantity });
            }
        });

        // To get talent qty and id
        const talentData = [];
        document.querySelectorAll('#additional-talent-body tr').forEach(row => {
            const talentId = row.dataset.talentId;
            const quantityInput = row.querySelector('input[name="quantity"]');
            const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 0;

            if (talentId) {
                talentData.push({ id: talentId, qty: quantity });
            }
        });

        const saleId = $('#sale_id').val();

        // AJAX request to save transaction
        $.ajax({
            url: `{{ route('sales.update', ['sale' => ':saleId']) }}`.replace(':saleId', saleId),
            method: "PUT",
            data: {
                sale_id: saleId,
                selled_items: productData,
                selled_talents: talentData,
                _token: "{{ csrf_token() }}" // Include CSRF token if needed
            },
            success: function(response) {
                if (response.status === 200) {
                    show_toastr("Success", response.message, "success");
                } else {
                    show_toastr("Error", response.message, "error");
                }
            },
            error: function(xhr) {
                show_toastr("Error", "An error occurred while saving the transaction.", "error");
            }
        });
    }

    async function makePayment(){
        await saveTransaction();

        // Get saleId
        const saleId = $('#sale_id').val();

        // Check payment type
        const payType = $('#pay_type').val();
        if (!payType) {
            return Swal.fire("Choose payment type", "Please select a payment type.", "warning");
        }

        // Get card number and remove formatting (dashes)
        const cardNumber = $('#card_number').inputmask('unmaskedvalue');
        if (payType === 'card' && (!cardNumber || cardNumber.length !== 16)) {
            return Swal.fire("Invalid Card Number", "Please enter a valid 16-digit card number.", "warning");
        }

        // Get payment amount and remove formatting (commas)
        const payAmount = $('#pay_amount').inputmask('unmaskedvalue');
        if (!payAmount || parseFloat(payAmount) <= 0) {
            return Swal.fire("Invalid Amount", "Please enter a valid payment amount.", "warning");
        }

        // Validate amount
        if (!payAmount || parseFloat(payAmount) <= 0) {
            return Swal.fire("Invalid Amount", "Please enter a valid payment amount.", "warning");
        }

        const locationId = $('#location_id').val();

        const paymentDescription = $('#payment_description').val();
        if (payType === 'unpaid' && !paymentDescription) {
            return Swal.fire("Description Required", "Payment description cannot be empty for unpaid payments.", "warning");
        }

        // Perform AJAX request to store payment
        $.ajax({
            url: "{{ route('sale-payment.store') }}",
            method: "POST",
            data: {
                sale_id: saleId,
                pay_type: payType,
                card_number: payType === 'card' ? cardNumber : null,
                amount: payAmount,
                description: paymentDescription,
                _token: "{{ csrf_token() }}" // Laravel CSRF token
            },
            success: function (response) {
                if (response.status === 200) {
                    Swal.fire("Success", response.message, "success");
                    getPaymentData(locationId);
                    $('#pay_amount').val('');
                    $('#card_number').val('');

                } else {
                    Swal.fire("Error", response.message || "An error occurred.", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Unable to process the payment.", "error");
            }
        });
    }

    function listPayment(){
        const saleId = $('#sale_id').val(); // Corrected to use jQuery ID selector properly

        // AJAX request to fetch payment list
        $.ajax({
            url: "{{ route('sale-payment.index') }}",
            method: "GET",
            data: { sale_id: saleId },
            success: function (response) {
                // Open the modal
                $('#commonModal').modal('show');

                // Set modal title
                $('#commonModal .modal-title').text('Payment List');

                // Populate the modal body with the response content
                $('#commonModal .body').html(response);
            },
            error: function () {
                Swal.fire('Error', 'Failed to fetch payment list.', 'error');
            }
        });
    }



    $('#add-talent').on('click', function() {
        // updateTalentModalTitle('Pilih Talent Tambahan');

        $.ajax({
            url: "{{ route('get.talent.by.grade') }}",
            type: 'GET',
            success: function(response) {
                // Populate the modal with filtered talents
                populateAdditionalTalentModal(response);

                // Show the modal
                $('#commonModal').modal('show');
            },
            error: function() {
                alert('Failed to load talents. Please try again.');
            }
        });
    });

    function populateAdditionalTalentModal(talentList) {
        $('#exampleModalLabel').text('Pilih Talent Tambahan')
        var modalBody = $('#commonModal .body');
        modalBody.empty(); // Clear existing content


        // Create the tab list
        const tablist = $('<ul class="nav nav-pills mb-3 mx-2" id="pills-tab" role="tablist"></ul>');

        talentList.talents.forEach((talent, index) => {
            const liElement = $(`
                    <li class="nav-item" role="presentation">
                        <button 
                            class="nav-link ${index === 0 ? 'active' : ''}" 
                            id="pills-${talent.id}-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-${talent.id}" 
                            type="button" 
                            role="tab" 
                            aria-controls="pills-${talent.id}" 
                            aria-selected="${index === 0 ? 'true' : 'false'}">
                            Grade ${talent.name}
                        </button>
                    </li>
                `);
            tablist.append(liElement);
        });

        // Create the tab content area
        const tabContent = $('<div class="tab-content" id="pills-tabContent"></div>');

        talentList.talents.forEach((talent, index) => {
            const tabPanel = $(`
                    <div 
                        class="tab-pane fade ${index === 0 ? 'show active' : ''}" 
                        id="pills-${talent.id}" 
                        role="tabpanel" 
                        aria-labelledby="pills-${talent.id}-tab">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="talent-${talent.id}">
                            </tbody>
                        </table>
                    </div>
                `);

            // Add the table rows for each talent
            talent.talent.forEach(talentDetail => {
                if (!selectedTalentIds.includes(talentDetail.id)) {
                    const tr = $(`
                            <tr>
                                <td>${talentDetail.code}</td>
                                <td>${talentDetail.name}</td>
                                <td>${talentDetail.status}</td>
                                <td>
                                    ${talentDetail.status === 'available' 
                                        ? `<button class="btn btn-primary btn-sm pick-talent-btn" 
                                        data-talent-id="${talentDetail.id}"
                                        data-talent-code="${talentDetail.code}"
                                        data-talent-name="${talentDetail.name}"
                                         data-talent-price="${talent.price}" >
                                            Pilih
                                        </button>`
                                        : ''}
                                </td>
                            </tr>
                        `);
                    tabPanel.find('tbody').append(tr);
                }
            });

            tabContent.append(tabPanel);

            modalBody.append(tablist, tabContent);
        });



    }

    function addTalent(talentData, talentHour = 1){
        const newRow = `
                    <tr data-talent-id="${talentData.talent_id}">
                        <td class="text-left">${talentData.talent_code}<small>(${talentData.talent_name})</small></td> <!-- Index starts from 1 -->
                        <td class="text-center">
                            <span class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" style="color: white" onchange="updateSubtotal(this)" name="quantity" title="Quantity" class="input-number" size="4" data-talent-id="${talentData.talent_id}" value="${talentHour}">
                                <input type="button" value="+" class="plus">
                            </span>
                        </td>
                        <td class="text-center">JAM</td>
                        <td class="text-end price">Rp.${talentData.talent_price.toLocaleString()}</td>
                        <td class="text-end subtotal">Rp.${talentData.subtotal.toLocaleString()}</td>
                        <td class="text-center">
                            <button 
                                class="btn btn-danger btn-sm remove-talent-btn" 
                                data-id="${talentData.talent_id}" 
                                data-confirm="Are you sure you want to remove this talent?">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

            $('#additional-talent-body').append(newRow);
            selectedTalentIds.push(talentData.talent_id);

            updateDisplayTotal();
    }

    document.addEventListener('click', function(event) {
        if (event.target.closest('.pick-talent-btn')) {
            const talentBtn = event.target.closest('.pick-talent-btn'); // Get the clicked button
            const talentId = $(talentBtn).data('talent-id');
            const talentCode = $(talentBtn).data('talent-code');
            const talentName = $(talentBtn).data('talent-name');
            const talentPrice = parseFloat($(talentBtn).data('talent-price'));

            selectedTalentIds.push(talentId);

            // Get the current number of rows in the table body to set the index
            // const rowCount = $('#additional-talent-body tr').length;

            const newRow = `
                    <tr data-talent-id="${talentId}">
                        <td class="text-left">${talentCode}<small>(${talentName})</small></td> <!-- Index starts from 1 -->
                        <td class="text-center">
                            <span class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" style="color: white" onchange="updateSubtotal(this)" name="quantity" title="Quantity" class="input-number" size="4" data-talent-id="${talentId}" value="1">
                                <input type="button" value="+" class="plus">
                            </span>
                        </td>
                        <td class="text-center">JAM</td>
                        <td class="text-end price">Rp.${talentPrice.toLocaleString()}</td>
                        <td class="text-end subtotal">Rp.${talentPrice.toLocaleString()}</td>
                        <td class="text-center">
                            <button 
                                class="btn btn-danger btn-sm remove-talent-btn" 
                                data-id="${talentId}" 
                                data-confirm="Are you sure you want to remove this talent?">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

            $('#additional-talent-body').append(newRow);
            $('#commonModal').modal('hide');

            
        }
        updateDisplayTotal();
    });

    function updateSubtotal(input) {
        const $input = $(input);
        const duration = parseInt($input.val()) || 0;

        const $row = $input.closest('tr');
        const priceText = $row.find('.price').text().replace('Rp.', '').replace(',', '');
        const price = parseFloat(priceText);

        const subtotalElement = $row.find('.subtotal');

        if (!isNaN(price) && duration > 0) {
            const newSubtotal = price * duration;
            subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
        } else {
            $input.val(1); // Reset invalid duration to 1
        }

        updateDisplayTotal();
    }

    $(document).on('change keyup', '#additional-talent-body .buttons_added input[name="quantity"]', function(e) {
        const $input = $(this);
        const duration = parseInt($input.val()) || 0;

        const $row = $input.closest('tr');
        const priceText = $row.find('.price').text().replace('Rp.', '').replace(',', '');
        const price = parseFloat(priceText);

        const subtotalElement = $row.find('.subtotal');
        console.log('sdfsfsf');

        if (!isNaN(price) && duration > 0) {
            const newSubtotal = price * duration;
            subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
        } else {
            $input.val(1); // Reset invalid duration to 1
        }

        updateDisplayTotal();
    });

   


    document.addEventListener('click', function(event) {
        if (event.target.closest('.remove-talent-btn')) {
            event.preventDefault();
            const deleteBtn = event.target.closest('.remove-talent-btn');
            const talentId = deleteBtn.getAttribute('data-id');
            const confirmText = deleteBtn.getAttribute('data-confirm');
            const formId = `remove-talent-${talentId}`;

            Swal.fire({
                title: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the row from the table
                    const row = document.querySelector(`tr[data-talent-id="${talentId}"]`);
                    if (row) {
                        row.remove();
                    }

                    // Optionally, submit the form if necessary
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit(); // Submit the form for server-side handling
                    }

                    // Show success message
                    show_toastr('Success', 'The talent has been removed.', 'success');

                    // Remove talent ID from the selected list
                    selectedTalentIds = selectedTalentIds.filter(id => id !== parseInt(talentId, 10));

                    // Recalculate the total
                    updateDisplayTotal();
                }
            });
        }
    });

    function getUnpaidAmount(input) {
        if( $(input).val() == '' || $(input).val() == null){
            var unpaid = $('#unpaid').val();
            unpaid = parseFloat(unpaid.replace('Rp.', '').replace(/,/g, ''));
    
            $(input).val(unpaid); // Use the input parameter to set the value
        }
    }
    

    function updateDisplayTotal() {
        let total = 0;

        // Loop through all product rows
        const productRows = document.querySelectorAll('#sale_table tr');
        productRows.forEach(row => {
            const quantityInput = row.querySelector('input[name="quantity"]');
            const priceElement = row.querySelector('.price');

            if (quantityInput && priceElement) {
                // Parse price and quantity
                const price = parseFloat(priceElement.textContent.replace('Rp.', '').replace(/,/g, ''));
                const quantity = parseInt(quantityInput.value) || 0;

                // Add to total
                total += price * quantity;
            }
        });

        // Calculate tax and grand total
        const tax = total * 0.11;
        const grandTotal = total + tax;
        var paid = $('#paid').val() || '0';
        paid = parseFloat(paid.replace('Rp.', '').replace(/,/g, ''));
        const unpaid = grandTotal - paid;

        // Update the form fields
        document.getElementById("total").value = `${total.toLocaleString()}`;
        document.getElementById("tax").value = `${tax.toLocaleString()}`;
        document.getElementById("grand_total").value = `${grandTotal.toLocaleString()}`;
        document.getElementById("paid").value = `${paid.toLocaleString()}`;
        document.getElementById("unpaid").value = `${unpaid.toLocaleString()}`;
    }

    function updateLocationsData() {
        $.ajax({
            url: '{{ route('locations.updateStatus') }}', // Pass the route URL
            method: 'GET', // HTTP method
            success: function(response) {
                response.forEach(element => {
                    // Find the row with the matching code
                    const row = $(`#location-body tr`).filter(function() {
                        return $(this).find('td').eq(1).text() === element
                        .code; // Match the second column
                    });

                    if (row.length) {
                        // Update the third column with the status
                        const baseUrl = `${window.location.protocol}//${window.location.host}`; // Dynamically get the base URL

                        if (element.status === 'available') {
                            // If the location status is 'available'
                            row.find('td').eq(3).text('Rp.0.00'); // Set total to 0
                            row.find('td').eq(4).text(''); // Clear check-in time
                            row.find('td.elapsed-time').attr('data-start', ''); // Clear elapsed time start
                            row.find('td').eq(6).html(`
                                <a href="${baseUrl}/sales?location_id=${element.id}" class="mx-3 btn-sm btn-primary d-inline-flex align-items-center" title="Transaction">
                                    check-in
                                </a>
                            `); // Render "check-in" button
                        } else if (element.latest_sale && element.latest_sale.formatted_check_out !== null) {
                            // If there is a latest sale and check-out is not null
                            row.find('td').eq(3).text(`Rp.${element.latest_sale.total.toLocaleString()}.00`); // Display sale total
                            row.find('td').eq(4).text(element.latest_sale.formatted_check_in); // Display check-in time
                            row.find('td.elapsed-time').attr('data-start', element.latest_sale.check_in); // Set elapsed time start
                            row.find('td').eq(6).html(`
                                <a href="${baseUrl}/location-available/${element.id}" class="mx-3 btn-sm btn-warning d-inline-flex align-items-center" title="Transaction">
                                    make available
                                </a>
                            `); // Render "make available" button
                        } else {
                            // If there is a latest sale but check-out is null
                            row.find('td').eq(3).text(`Rp.${element.latest_sale.total.toLocaleString()}.00`); // Display sale total
                            row.find('td').eq(4).text(element.latest_sale.formatted_check_in); // Display check-in time
                            row.find('td.elapsed-time').attr('data-start', element.latest_sale.check_in); // Set elapsed time start
                            row.find('td').eq(6).html(`
                                <a href="#" class="mx-3 btn-sm btn-success d-inline-flex align-items-center" title="Transaction" onclick="toggleWindow(${element.id})">
                                    add-item/check-out
                                </a>
                            `); // Render "add-item/check-out" button
                        }

                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Failed to update location data. Please try again.');
            }
        });
    }

    setInterval(updateLocationsData, 1000);


    // Ticking Elapsed Time Counter
    function updateElapsedTime() {
        document.querySelectorAll('.elapsed-time').forEach(function(element) {
            const startTimeAttr = element.getAttribute('data-start');

            // If `data-start` is null or empty, clear the text content and skip
            if (!startTimeAttr) {
                element.textContent = '';
                return;
            }

            const startTime = new Date(startTimeAttr).getTime();
            const now = new Date().getTime();
            const elapsed = new Date(now - startTime);

            const hours = String(elapsed.getUTCHours()).padStart(2, '0');
            const minutes = String(elapsed.getUTCMinutes()).padStart(2, '0');
            const seconds = String(elapsed.getUTCSeconds()).padStart(2, '0');

            element.textContent = `${hours}:${minutes}:${seconds}`;
        });
    }


    setInterval(updateElapsedTime, 1000);

    function applyFilters() {
        // let categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
        // let nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        let codeFilter = document.getElementById('codeFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#table-location tbody tr');

        rows.forEach(row => {
            // let category = row.querySelector('.category-cell').textContent.toLowerCase();
            // let name = row.querySelector('.name-cell').textContent.toLowerCase();
            let code = row.querySelector('.code-cell').textContent.toLowerCase();


            // Display the row only if it matches both filters
            row.style.display = (code.includes(codeFilter)) ? '' : 'none';
        });
    }

    // document.getElementById('categoryFilter').addEventListener('keyup', applyFilters);
    // document.getElementById('nameFilter').addEventListener('keyup', applyFilters);
    document.getElementById('codeFilter').addEventListener('change', applyFilters);
</script>
