<style>
     body .table td, body .table th {
        padding: 0.75rem 0.75rem !important;
    }
</style>

@extends('layouts.app')

@section('page-title', __('Edit Package'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Edit Package') }}</h5>
    </div>
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Product') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Package') }}</li>
@endsection


@push('old-datatable-css')
    <link rel="stylesheet" href="{{ asset('custom/css/jquery.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="row min-vh-100">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Package Update') }}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => ['update.package', $product->id], 'enctype' => 'multipart/form-data', 'method' => 'PUT']) }}

                    

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    {{ Form::label('name', __('Package Name'), ['class' => 'col-form-label']) }}
                                </div>
                                <div class="col-md-8">
                                    {{ Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => __('Enter new Product Name'), 'required' => true, 'id' => 'name', 'autocomplete' => 'off']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    {{ Form::label('duration', __('Duration (Hour)'), ['class' => 'col-form-label']) }}
                                </div>
                                <div class="col-md-8">
                                    {{ Form::number('duration', $package->duration, ['class' => 'form-control', 'placeholder' => __('Enter duration in hours'), 'required' => true, 'min' => 1, 'id' => 'duration']) }}
                                </div>
                            </div>
                            <!-- Fixed Product Section -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>{{ Form::label('', __('Fixed Product'), ['class' => 'col-form-label']) }}</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ti ti-search text-black"></i></span>
                                            </div>
                                            {{ Form::text('searchproducts', null, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table carttable mb-5">
                                    <thead class="thead-light">
                                    <tr role="row">
                                        <th style="width: 25%;">{{ __('Product') }}</th>
                                        <th style="width: 12%;">{{ __('Quantity') }}</th>
                                        <th style="width: 18%;">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="fixed-product-body">
                                        @if($package->fixed_products !== null)
                                            @foreach($package->fixed_products as $fixedProduct)
                                                <tr id="{{ $fixedProduct->product->id }}">
                                                    <td>{{ $fixedProduct->product->name }}</td>
                                                    <td>
                                                        <div class="quantity buttons_added">
                                                            <input type="hidden" name="fixed_product[]" value="{{ $fixedProduct->product->id }}">
                                                            <input type="number" step="1" min="1" max="77" name="fixed_quantity[]" title="Jumlah" class=" form-control" size="4" data-id="6" data-price="{{ $fixedProduct->price }}" data-tax="0" value="1">
                                                        </div>
                                                    </td>
                                                    <td class=""><a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <hr class="mb-5">


                            <div class="col-md-12 mb-5">
                                <h4>
    
                                    {{ Form::label('', __('Optional Talent'), ['class' => 'col-form-label']) }}
                                    <a href="javascript:void" 
                                        class="btn btn-sm btn-primary btn-icon m-1" id="add-talent">
                                        <span class=""><i class="ti ti-plus text-white"></i></span>
                                    </a>
                                </h4>
    
                                <table class="table carttable-2">
                                    <thead class="thead-light">
                                    <tr role="row">
                                        <th style="width: 25%;">{{ __('Talent Grade') }}</th>
                                        <th style="width: 12%;">{{ __('Quantity') }}</th>
                                        <th style="width: 18%;">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="talent-body">
                                    </tbody>
                                    <tfoot>
                                    
                                    </tfoot>
                                </table>
                            </div>

                            <hr class="mb-5">
                           

                            <div class="col-md-12 form-group mt-5">
                                <!-- HPP Row -->
                                <div class="row">
                                    <div class="col-md-4 text-end">
                                        {{ Form::label('hpp', __('Harga HPP'), ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-8">
                                        {{ Form::number('hpp', $product->purchase_price, ['class' => 'form-control', 'placeholder' => __('Harga HPP'), 'id' => 'hpp']) }}
                                    </div>
                                </div>
                                <!-- Sale Price Row -->
                                <div class="row mt-2">
                                    <div class="col-md-4 text-end">
                                        {{ Form::label('sale_price', __('Harga Jual'), ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-8">
                                        {{ Form::number('sale_price', $product->sale_price, ['class' => 'form-control', 'placeholder' => __('Enter Sale Price'), 'required' => true, 'id' => 'sale_price']) }}
                                    </div>
                                </div>
                                <!-- Keuntungan (Profit) Row -->
                                <div class="row mt-2">
                                    <div class="col-md-4 text-end">
                                        {{ Form::label('profit', __('Keuntungan'), ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-8">
                                        {{ Form::number('profit', $product->sale_price - $product->purchase_price, ['class' => 'form-control', 'placeholder' => __('Keuntungan'), 'id' => 'profit', 'readonly' => true]) }}
                                    </div>
                                </div>
                            </div>
                            
    
                        </div>
                    
                        <div class="col-md-6">
                            <!-- Produk Opsional Section -->
                            @if($package->optional_products == null)
                            <div class="optional-product-container">

                            </div>
                            @else
                            <div class="optional-product-container">
                                @foreach($package->optional_products as $index => $optionalProduct)
                                        <div class="optional-product-group">
                                            <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
                                                <h4>
                                                    <label for="" class="form-label product-optional-index">Produk Opsional {{ $index + 1}} </label>
                                                </h4>
                                                <button type="button" class="btn btn-danger delete-optional-product-group">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </div>
                                        
                            
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">Keterangan Produk</div>
                                                    <div class="col-md-8 form-group"><input class="form-control" name="optional[{{ $index }}][description]" type="text" value="{{ $optionalProduct->description }}"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">Jumlah Pilihan Item</div>
                                                    <div class="col-md-8 form-group"><input class="form-control" name="optional[{{ $index }}][num_of_items]" type="number" value="{{ $optionalProduct->numOfItems }}"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group mb-4">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ti ti-search text-black"></i></span>
                                                        </div>
                                                        <input class="form-control ui-autocomplete-input" name="optional[{{ $index }}][searchproducts_optional]" type="text" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                            
                                            <div class="col-md-12">
                                                <table class="table carttable-2 mb-5">
                                                    <thead class="thead-light">
                                                    <tr role="row">
                                                        <th style="width: 25%;">Produk</th>
                                                        <th style="width: 12%;">Jumlah</th>
                                                        <th style="width: 18%;">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="optional-product-body">
                                                    @foreach ($optionalProduct->products as $productData)
                                                        
                                                        <tr id="product-{{ $productData->id }}">
                                                            <td>{{ $productData->product->name }}</td>
                                                            <td>
                                                                <div class="quantity buttons_added">
                                                                    <input type="hidden" name="optional_product[]" value="{{ $productData->id }}">
                                                                    <input type="number" step="1" min="1" max="" name="optional_quantity[]" title="Jumlah" class="form-control" size="4" data-id="5" data-price="{{ $productData->price }}" data-tax="0" value="{{ $productData->quantity }}">
                                                                </div>
                                                            </td>
                                                            <td class="">
                                                                <a class="action-btn bg-danger remove-items">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach                            
                                    </div> 
                            @endif

                            
                            
                            <div class="col-md-12 ">
                                <button type="button" id="add-optional-product" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> {{ __('Add Produk Opsional') }}
                                </button>
                            </div>
                        </div>
                    </div>
                   
                    
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-primary float-end" onclick="getRequestData()">Save Change</button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>

  
@endsection

@push('old-datatable-js')
    <script src="{{ asset('custom/js/jquery.dataTables.min.js') }}"></script>
    <script>
        var dataTabelLang = {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            lengthMenu: "{{ __('Show') }} _MENU_ {{ __('entries') }}",
            zeroRecords: "{{ __('No data available in table.') }}",
            info: "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_ {{ __('entries') }}",
            infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
            infoFiltered: "{{ __('(filtered from _MAX_ total entries)') }}",
            search: "{{ __('Search:') }}",
            thousands: ",",
            loadingRecords: "{{ __('Loading...') }}",
            processing: "{{ __('Processing...') }}"
        };

        var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
        var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
    </script>
@endpush

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
    // Function to calculate subtotal for a given table body
    function calculateSubtotal(tableBodyId) {
        const rows = document.querySelectorAll(`#${tableBodyId} tr`);
        let total = 0;

        rows.forEach(row => {
            const totalCell = row.querySelector('.total-cell');
            if (totalCell) {
                const subtotal = parseFloat(totalCell.textContent
                                .replace(/Rp.\s*/g, "") // Remove "Rp." at the start
                                .replace(/,|\.\d+$/g, "") // Remove commas and ".00" at the end
                            ) || 0;                total += subtotal; // Add to total
            }
        });

        return total; // Return the total of all subtotals
    }

    document.getElementById('hpp').addEventListener('input', calculateProfit);
    document.getElementById('sale_price').addEventListener('input', calculateProfit);

    function calculateProfit() {
        const hpp = parseFloat(document.getElementById('hpp').value) || 0;
        const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
        const profit = salePrice - hpp;

        // Update the profit field
        document.getElementById('profit').value = profit.toFixed(0);
    }

    function updateAllSubtotals() {
        const fixedProductTotal = calculateSubtotal('fixed-product-body');
        const optionalProductTotal = calculateSubtotal('optional-product-body');
        const talentTotal = calculateSubtotal('talent-body');

        const totalAmount = fixedProductTotal + optionalProductTotal + talentTotal;
        const hppInput = document.getElementById('hpp');
        hppInput.disabled = false; // Enable it temporarily
        hppInput.value = totalAmount; // Update the value
        hppInput.disabled = true; 
    }

    // setInterval(updateAllSubtotals, 1000);

        $(function() {
            $("#date").datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true
            });

            var items = [];
            var total = 0;

            // $.ajax({
            //     url: '{{ route('package.items') }}',
            //     dataType: 'json',
            //     data: {
            //         'id': '{{ $product->id }}',
            //         'field' : 'fixed'
            //     },
            //     success: function(data) {

            //         if (data.length > 0) {
            //             for (var i = 0; i < data.length; i++) {
            //                 items.push(data[i].product_id);
            //                 $('<tr id=' + data[i].product_id + '>')
            //                     .append(
            //                         '<td>' + data[i].name + '</td>' +
            //                         '<td>' + addCommas(data[i].purchase_price) + '</td>' +
            //                         '<td><div class="quantity buttons_added">' +
            //                         '<input type="hidden" name="fixed_product[]" value="' + data[i]
            //                         .product_id + '">' +
            //                         '<input type="number" step="1" min="1" name="fixed_quantity[]" title="{{ __('Quantity') }}" class=" form-control" size="4" data-id="' +
            //                         data[i].product_id + '" data-price="' + data[i].purchase_price +
            //                         '" data-tax="' + 0 + '" value="' + data[i].quantity +
            //                         '">' +
            //                         '<td class="total-cell"><span>' + addCommas(data[i].subtotal) + '</span></td>' +
            //                         '<td class="btn btn-sm d-inline-flex align-items-center">' +
            //                         '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
            //                         '</td>'
            //                     )
            //                     .appendTo($('#fixed-product-body'));
            //                 total += data[i].subtotal;
            //             }
            //             $('#total').text(addCommas(total));
            //         }
            //     },
            //     error: function(data) {
            //         data = data.responseJSON;
            //         show_toastr('{{ __('Error') }}', data.error, 'error');
            //     }
            // });

            $('input[name="searchproducts"]').autocomplete({
                minLength: 0,
                source: function(request, response) {
                    $.getJSON("{{ route('name.search.products') }}", {
                        search: request.term,
                        exclude_category: "{{ $product->category_id }}"
                    }, response);
                },
                search: function() {
                    var term = $.trim(this.value);
                },
                select: function(event, ui) {
                    if ($.inArray(ui.item.id, items) == -1) {
                        items.push(ui.item.id);
                        $('<tr id=' + ui.item.id + '>')
                            .append(
                                '<td>' + ui.item.name + '</td>' +
                                '<td><div class="quantity buttons_added">' +
                                '<input type="hidden" name="fixed_product[]" value="' + ui.item.id + '">' +
                                '<input type="number" step="1" min="1" max="' + ui.item.maxquantity +
                                '" name="fixed_quantity[]" title="{{ __('Quantity') }}" class=" form-control" size="4" data-id="' +
                                ui.item.id + '" data-price="' + ui.item.price + '" data-tax="' + ui.item.tax +
                                '" value="' + ui.item.quantity + '">' +
                                '<td class="">' +
                                '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
                                '</td>'
                            )
                            .appendTo($('#fixed-product-body'));
                        manageTotals();
                    }
                    return true;
                }
            })
                .autocomplete("instance")._renderItem = function(ul, item) {
                    var ele = ($.inArray(item.id, items) == -1) ? $('<li>') : $( 
                        '<li class="bg-primary text-white">');
                    
                    return ele.append("<div>" + item.name + "</div>").appendTo(ul);
                };

            // Add an event listener for the "Enter" key to select the top item
            $('input[name="searchproducts"]').on('keydown', function(event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // Prevent the default form submission

                    // Check if autocomplete menu is visible
                    const menu = $(this).autocomplete("widget");
                    if (menu.is(":visible")) {
                        // Find the first item in the menu
                        const firstItem = menu.find("li:first");
                        if (firstItem.length) {
                            // Trigger a click on the first item
                            firstItem.click();
                        }
                    }
                }
            });


            $(document).on('change', 'input[name="fixed_quantity[]"]', function(e) {
                e.preventDefault();

                var ele = $(this);
                var id = ele.data('id');

                $('tr#' + id + ' td span').text(addCommas(getSubTotal(ele)));

                manageTotals();
            });

            // $.ajax({
            //     url: '{{ route('package.items') }}',
            //     dataType: 'json',
            //     data: {
            //         'id': '{{ $product->id }}',
            //         'field' : 'optional'
            //     },
            //     success: function(data) {

            //         if (data.length > 0) {
            //             for (var i = 0; i < data.length; i++) {
            //                 items.push(data[i].product_id);
            //                 $('<tr id=' + data[i].product_id + '>')
            //                     .append(
            //                         '<td>' + data[i].name + '</td>' +
            //                         '<td>' + addCommas(data[i].purchase_price) + '</td>' +
            //                         '<td><div class="quantity buttons_added">' +
            //                         '<input type="hidden" name="optional_product[]" value="' + data[i]
            //                         .product_id + '">' +
            //                         '<input type="number" step="1" min="1" name="optional_quantity[]" title="{{ __('Quantity') }}" class=" form-control" size="4" data-id="' +
            //                         data[i].product_id + '" data-price="' + data[i].purchase_price +
            //                         '" data-tax="' + 0 + '" value="' + data[i].quantity +
            //                         '">' +
            //                         '<td class="total-cell"><span>' + addCommas(data[i].subtotal) + '</span></td>' +
            //                         '<td class="btn btn-sm d-inline-flex align-items-center">' +
            //                         '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
            //                         '</td>'
            //                     )
            //                     .appendTo($('#optional-product-body'));
            //                     manageTotals();
            //                 total += data[i].subtotal;
            //             }
            //         }
            //     },
            //     error: function(data) {
            //         data = data.responseJSON;
            //         show_toastr('{{ __('Error') }}', data.error, 'error');
            //     }
            // });

            // A list to keep track of selected product IDs (avoid duplicates)

            // Function to initialize autocomplete for a specific input
            function initializeAutocomplete(input) {
                $(input).autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        $.getJSON("{{ route('name.search.products') }}", {
                            search: request.term,
                            exclude_category: "{{ $product->category_id }}"
                        }, response);
                    },
                    search: function() {
                        let term = $.trim(this.value);
                    },
                    select: function(event, ui) {
                        if ($.inArray(ui.item.id, items) === -1) {
                            items.push(ui.item.id); // Add to the array to prevent duplicates
                            
                            // Append new row to the correct Produk Opsional group
                            const parentGroup = $(this).closest('.optional-product-group');
                            parentGroup.find('.optional-product-body').append(`
                                <tr id="product-${ui.item.id}">
                                    <td>${ui.item.name}</td>
                                    <td>
                                        <div class="quantity buttons_added">
                                            <input type="hidden" name="optional_product[]" value="${ui.item.id}">
                                            <input type="number" step="1" min="1" max="${ui.item.maxquantity}" 
                                                name="optional_quantity[]" 
                                                title="{{ __('Quantity') }}" 
                                                class="form-control" 
                                                size="4" 
                                                data-id="${ui.item.id}" 
                                                data-price="${ui.item.price}" 
                                                data-tax="${ui.item.tax}" 
                                                value="${ui.item.quantity}">
                                        </div>
                                    </td>
                                    <td class="">
                                        <a class="action-btn bg-danger remove-items">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);
                            manageTotals();
                        }
                        return true;
                    }
                })
                .autocomplete("instance")._renderItem = function(ul, item) {
                    let ele = ($.inArray(item.id, items) === -1) ? $('<li>') : $('<li class="bg-primary text-white">');
                    return ele.append("<div>" + item.name + "</div>").appendTo(ul);
                };

                // Add an event listener for the "Enter" key to select the top item
                $(input).on('keydown', function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault(); // Prevent default behavior
                        const menu = $(this).autocomplete("widget");
                        if (menu.is(":visible")) {
                            const firstItem = menu.find("li:first");
                            if (firstItem.length) {
                                firstItem.click(); // Simulate click on the top item
                            }
                        }
                    }
                });
            }

            // Initialize autocomplete for all current inputs on page load
            $('input[name^="optional"][name$="[searchproducts_optional]"]').each(function() {
                initializeAutocomplete(this);
            });

            // Reinitialize autocomplete when a new Produk Opsional group is added
            $('#add-optional-product').on('click', function() {
                // Delay to ensure the new input is added to the DOM
                setTimeout(() => {
                    $('.optional-product-group:last input[name^="optional"][name$="[searchproducts_optional]"]').each(function() {
                        initializeAutocomplete(this);
                    });
                }, 100);
            });


            // Event delegation for remove items
            $(document).on('click', '.remove-items', function() {
                const row = $(this).closest('tr');
                const productId = row.find('input[name="optional_product[]"]').val();
                
                // Remove the row
                row.remove();
                
                // Remove the product from the items array
                items = items.filter(id => id !== parseInt(productId));
                manageTotals();
            });

                $(document).on('change', 'input[name="optional_quantity[]"]', function(e) {
                    e.preventDefault();

                    var ele = $(this);
                    var id = ele.data('id');

                    $('tr#' + id + ' td span').text(addCommas(getSubTotal(ele)));

                    manageTotals();
                });

            function getSubTotal(ele) {
                var price = ele.data('price');
                var tax = ele.data('tax');
                var quantity = ele.val();

                var subtotal = price * quantity;
                var tax = (subtotal * tax) / 100;

                return subtotal + tax;
            }

            function manageTotals() {
                var total = 0;
                var rows = $("table.carttable tbody > tr:visible");
                $(rows).each(function(index, value) {
                    total += getSubTotal($('tr#' + this.id + ' .quantity input[type="number"]'));
                });
                $('#total').text(addCommas(total))
            }

            $(document).on('click', '.remove-items', function(e) {
                e.preventDefault();

                var ele = $(this).closest('tr');

                if (confirm('{{ __('Are you sure you want to remove item?') }}')) {
                    ele.hide(250, function() {
                        ele.remove();
                        manageTotals();
                    });
                    items.remove(parseInt(ele.attr('id')));
                }
            });

            $.ajax({
                url: '{{ route('user.type') }}',
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        if (data[0].isOwner) {
                            $.ajax({
                                url: '{{ route('get.branches') }}',
                                dataType: 'json',
                                success: function(data) {

                                    if (data.length > 0) {

                                        $.each(data, function(key, value) {
                                            $('#branch_id')
                                                .append($("<option></option>")
                                                    .attr("value", value.id)
                                                    .text(value.name));
                                        });

                                        $('#branch_id').trigger('change');
                                    }
                                },
                                error: function(data) {
                                    data = data.responseJSON;
                                    show_toastr('{{ __('Error') }}', data.error,
                                        'error');
                                }
                            });
                        }
                    }
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });

            $(document).on('change', '#branch_id', function(e) {
                $.ajax({
                    url: '{{ route('get.cash.registers') }}',
                    dataType: 'json',
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#cash_register_id').find('option').remove();
                        $.each(data, function(key, value) {
                            $('#cash_register_id')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.name));
                        });
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            });

        });
        
        document.getElementById('talent-body').addEventListener('change', function(event) {
            const element = event.target;

            // Check if the changed element is a grade select or quantity input
            if (element.classList.contains('talent-grade-select') || element.classList.contains('talent-quantity-input')) {
                updateRow(element);
                disableSelectedOptions();
            }
        });

        // Update row function to handle price and total calculation
        function updateRow(element) {
            const talentGrades = @json($talentGrades);
            const row = element.closest('tr');

            // Get grade ID from select and match it to price
            const gradeSelect = row.querySelector('.talent-grade-select');
            const gradeId = parseInt(gradeSelect.value);
            const grade = talentGrades.find(item => item.id === gradeId);

            // // Update the price cell
            // const priceCell = row.querySelector('.price-cell');
            // const price = grade ? grade.price : 0;
            // priceCell.textContent = addCommas(price);

            // Calculate and update total based on quantity
            const quantityInput = row.querySelector('.talent-quantity-input');
            const quantity = parseFloat(quantityInput.value) || 0;
            // const totalCell = row.querySelector('.total-cell');
            // totalCell.textContent = addCommas(price * quantity);
        }

        function disableSelectedOptions() {
            const selectedValues = Array.from(document.querySelectorAll('.talent-grade-select'))
                .map(select => select.value)
                .filter(value => value); // Get all selected values, excluding empty ones

            document.querySelectorAll('.talent-grade-select').forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== select.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        document.getElementById('talent-body').addEventListener('click', function(event) {
            if (event.target.closest('.remove-row')) {
                const confirmation = confirm("Are you sure you want to delete this row?");
                if (confirmation) {
                    const row = event.target.closest('tr');
                    row.remove();
                }
            }
        });

        // AJAX call to add a talent row
        $('#add-talent').on('click', function() {
            getTalent();
        });

        function getTalent(id = null, qty = null) {
            $.ajax({
                url: "{{ route('package.add.talent') }}",  // Update with your controller route
                method: 'GET',  // Or 'POST' if needed
                data: {
                    grade: id,
                    quantity: qty,
                },
                success: function(response) {
                    // Append the returned view to the #talent-body table section
                    $('#talent-body').append(response);
                    disableSelectedOptions();

                    const newRow = $('#talent-body tr').last(); // Get the last added row
                    const gradeSelect = newRow.find('.talent-grade-select'); // Find the grade select in the new row
                    const quantityInput = newRow.find('.talent-quantity-input'); // Find the quantity input in the new row
                    
                    // Check if the grade is selected and quantity is filled
                    if (gradeSelect.val() && quantityInput.val()) {
                        updateRow(gradeSelect[0]); // Trigger updateRow with the grade select element
                    }
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }

        function getPrevTalent() {
            const prevTalents = @json($package->optional_talents);

            if (prevTalents && prevTalents.length > 0) {
                prevTalents.forEach(talent => {
                    getTalent(talent.grade_id, talent.quantity);
                });
            }
        }

        // Call getPrevTalent on page load if applicable
        $(document).ready(function() {
            getPrevTalent();
        });

        function reindexOptionalProducts() {
            const optionalGroups = document.querySelectorAll('.optional-product-group');
            optionalGroups.forEach((group, index) => {
                const label = group.querySelector('.product-optional-index');
                if (label) {
                    label.textContent = `Produk Opsional ${index + 1}`;
                }
            });
        }


        
        document.getElementById('add-optional-product').addEventListener('click', function () {
            let optionalProductInputs = document.querySelectorAll('[name^="optional["][name$="][searchproducts_optional]"]');
            let optionalProductIndex = 0;

            if (optionalProductInputs.length > 0) {
                optionalProductIndex = optionalProductInputs.length
                console.log('Last Index:', optionalProductIndex); // Output the index
            }


            const optionalProductTemplate = `
                <div class="optional-product-group">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
                        <h4>
                            <label for="" class="form-label product-optional-index">Produk Opsional</label>
                        </h4>
                        <button type="button" class="btn btn-danger delete-optional-product-group">
                            <i class="ti ti-trash"></i> Delete
                        </button>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">Keterangan Produk</div>
                            <div class="col-md-8 form-group">
                                <input type="text" name="optional[${optionalProductIndex}][description]" class="form-control" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Jumlah Pilihan Item</div>
                            <div class="col-md-8 form-group">
                                <input type="number" name="optional[${optionalProductIndex}][num_of_items]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti ti-search text-black"></i></span>
                                </div>
                                <input type="text" name="optional[${optionalProductIndex}][searchproducts_optional]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <table class="table carttable-2 mb-5">
                            <thead class="thead-light">
                            <tr role="row">
                                <th style="width: 25%;">Product</th>
                                <th style="width: 12%;">Quantity</th>
                                <th style="width: 18%;">Action</th>
                            </tr>
                            </thead>
                            <tbody class="optional-product-body">
                            </tbody>
                        </table>
                    </div>
                </div>`;

                // Select all containers
                let optionalProductContainers = document.querySelectorAll('.optional-product-container');

                if (optionalProductContainers.length === 0) {
                    // If no container exists, append to a specific parent container
                    let parentContainer = document.getElementById('optional-product-parent'); // Replace with your actual parent ID
                    if (parentContainer) {
                        parentContainer.insertAdjacentHTML('beforeend', optionalProductTemplate);
                    } else {
                        console.error('Parent container not found!');
                    }
                } else {
                    // Get the last container and append the template
                    let lastOptionalProductContainer = optionalProductContainers[optionalProductContainers.length - 1];
                    lastOptionalProductContainer.insertAdjacentHTML('beforeend', optionalProductTemplate);
                }

                // Reindex after adding a new group
                reindexOptionalProducts();
        });

        document.body.addEventListener('click', function (e) {
            // Check if the clicked element is a delete button
            if (e.target.classList.contains('delete-optional-product-group') || 
                e.target.closest('.delete-optional-product-group')) {
                // Find the closest parent .optional-product-group and remove it
                const group = e.target.closest('.optional-product-group');
                if (group) {
                    group.remove();
                }
            }

            reindexOptionalProducts();
        });

        function getFixedProduct(){
            const rows = document.querySelectorAll('#fixed-product-body tr');
            const fixedProducts = [];

            rows.forEach(row => {
                // Get product ID from the <tr> id
                const productId = row.id;

                // Get quantity from the number input
                const quantity = row.querySelector('input[name="fixed_quantity[]"]').value;

                // Optional: Get price if needed
                const price = row.querySelector('input[name="fixed_quantity[]"]').dataset.price;

                // Add the data to the array
                fixedProducts.push({
                    productId: parseInt(productId, 10), // Use tr id
                    quantity: parseInt(quantity, 10),
                    price: parseFloat(price) || 0
                });
            });

            // Log the extracted data (or process it further)
            return fixedProducts;
        }

        function getOptionalProduct(){
            // Get all optional product containers
            const optionalProductContainers = document.querySelectorAll('.optional-product-group');

            // Initialize an array to store the optional product groups
            const optionalProducts = [];

            // Loop through each optional container
            optionalProductContainers.forEach((container, index) => {
                // Extract the description and numOfItems
                const description = container.querySelector(`input[name="optional[${index}][description]"]`)?.value || '';
                const numOfItems = parseInt(container.querySelector(`input[name="optional[${index}][num_of_items]"]`)?.value || '0');
                
                // Get all products within the current container
                const productRows = container.querySelectorAll('.optional-product-body tr');
                
                // Collect the products for this container
                const products = Array.from(productRows).map(row => {
                    return {
                        id: parseInt(row.querySelector('input[name="optional_product[]"]')?.value || '0'),
                        quantity: parseInt(row.querySelector('input[name="optional_quantity[]"]')?.value || '0'),
                        price: parseInt(row.querySelector('input[name="optional_quantity[]"]')?.dataset.price || '0'),
                    };
                });

                // Add this container's data to the optionalProducts array
                if (products.length > 0) {
                    optionalProducts.push({
                        description: description,
                        numOfItems: numOfItems,
                        products: products,
                    });
                } 
            });

            // Output the structured data
            return optionalProducts;

        }

        function validatRequestData() {
            let isValid = true;
            let firstInvalidField = null;

            // Loop through each optional product group
            $('.optional-product-group').each(function(index, group) {
                const descriptionInput = $(group).find(`input[name="optional[${index}][description]"]`);
                const numOfItemsInput = $(group).find(`input[name="optional[${index}][num_of_items]"]`);

                // Clear previous error styles
                descriptionInput.removeClass('is-invalid');
                numOfItemsInput.removeClass('is-invalid');

                // Validate description field
                if (!descriptionInput.val().trim()) {
                    descriptionInput.addClass('is-invalid'); // Add error style
                    if (!firstInvalidField) firstInvalidField = descriptionInput;
                    isValid = false;
                }

                // Validate num_of_items field
                if (!numOfItemsInput.val().trim() || parseInt(numOfItemsInput.val(), 10) <= 0) {
                    numOfItemsInput.addClass('is-invalid'); // Add error style
                    if (!firstInvalidField) firstInvalidField = numOfItemsInput;
                    isValid = false;
                }
            });

            // Validate other fields
            ['#name', '#hpp', '#sale_price'].forEach(selector => {
                const inputField = $(selector);
                inputField.removeClass('is-invalid');

                if (!inputField.val().trim()) {
                    inputField.addClass('is-invalid');
                    if (!firstInvalidField) firstInvalidField = inputField;
                    isValid = false;
                }
            });

            // Focus the first invalid field
            if (firstInvalidField) {
                firstInvalidField.focus();
            }

            return isValid;
        }


        function getTalents() {
            // Select the table body containing talent rows
            const talentRows = document.querySelectorAll('#talent-body tr');

            // Initialize an array to store the talent data
            const talents = [];

            // Loop through each row in the table body
            talentRows.forEach(row => {
                // Extract the selected grade ID
                const gradeSelect = row.querySelector('.talent-grade-select');
                const gradeId = parseInt(gradeSelect?.value || '0');

                // Extract the quantity value
                const quantityInput = row.querySelector('.talent-quantity-input');
                const quantity = parseInt(quantityInput?.value || '0');

                // Add the data to the talents array if valid
                if (gradeId && quantity) {
                    talents.push({
                        grade_id: gradeId,
                        quantity: quantity
                    });
                }
            });

            // Output the structured data
            return talents;
        }

        function getRequestData() {

            var isValid = validatRequestData();
            if (isValid == false) {
                return;
            } 

            // Gather package details
            var packageName = $('#name').val();
            var duration = $('#duration').val();
            var hpp = $('#hpp').val();
            var salePrice = $('#sale_price').val();

            // Fetch product and talent data
            var fixedProduct = getFixedProduct(); // Function to fetch fixed product data
            var optionalProduct = getOptionalProduct(); // Function to fetch optional product data
            var talents = getTalents(); // Function to fetch talent data

            // Prepare request data
            var requestData = {
                package_name: packageName,
                duration: duration,
                hpp: hpp,
                sale_price: salePrice,
                fixed_product: fixedProduct,
                optional_product: optionalProduct,
                talents: talents
            };

            // Perform AJAX request
            $.ajax({
                url: "{{ route('update.package', ['product' => $product->id]) }}",
                type: 'PUT',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    console.log('Request successful:', response);
                    // Handle success response
                    show_toastr(response.status, response.message, response.status)
                },
                error: function(error) {
                    console.error('Request failed:', error);
                    // Handle error response
                }
            });
        }

    </script>
@endpush
