@extends('layouts.app')

@section('page-title', __('Edit Package'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Edit Package') }}</h5>
    </div>
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    {{-- <li class="breadcrumb-item"><a href="{{ route('reports.purchases') }}">{{ __('Purchase List') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Purchase') }}</li> --}}
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
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('name', __('Package Name'), ['class' => 'col-form-label']) }}
                                {{ Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => __('Enter new Product Name'), 'required' => true]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('duration', __('Duration (Hour)'), ['class' => 'col-form-label']) }}
                                {{ Form::number('duration', $package->duration, ['class' => 'form-control', 'placeholder' => __('Enter duration in hours'), 'required' => true, 'min' => 1]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('location', __('Location'), ['class' => 'col-form-label']) }}
                                {{ Form::select('location', ['hall' => 'Hall', 'room' => 'Room', 'vip' => 'VIP'], $package->location, ['class' => 'form-control', 'placeholder' => __('Select Location'), 'required' => true]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('min_sale', __('Minimum Sale'), ['class' => 'col-form-label']) }}
                                {{ Form::number('min_sale', $package->min_sale, ['class' => 'form-control', 'placeholder' => __('Enter minimum sale'), 'required' => true, 'min' => 1]) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('number_optional_choice', __('Number Optional Product can Choose'), ['class' => 'col-form-label']) }}
                                {{ Form::number('number_optional_choice', $package->number_optional_choice, ['class' => 'form-control', 'placeholder' => __(''), 'required' => true, 'min' => 1]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('hpp', __('HPP Estimate'), ['class' => 'col-form-label']) }}
                                {{ Form::number('hpp', 0, ['class' => 'form-control', 'placeholder' => __(''), 'disabled' => true, 'id' => 'hpp']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('sale_price', __('Selling Price'), ['class' => 'col-form-label']) }}
                                {{ Form::number('sale_price', $product->sale_price, ['class' => 'form-control', 'placeholder' => __('Enter Package Price'), 'required' => true]) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti ti-search  text-black"></i></span>
                                    </div>
                                    {{ Form::text('searchproducts', null, ['class' => 'form-control', 'placeholder' => __('Please add products to fixed product')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            {{ Form::label('', __('Fixed Product'), ['class' => 'col-form-label']) }}

                            <table class="table carttable">
                                <thead class="thead-light">
                                <tr role="row">
                                    <th style="width: 25%;">{{ __('Product') }}</th>
                                    <th style="width: 20%;">{{ __('Price') }}</th>
                                    <th style="width: 12%;">{{ __('Quantity') }}</th>
                                    <th style="width: 20%;">{{ __('Subtotal') }}</th>
                                    <th style="width: 18%;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="fixed-product-body">
                                </tbody>
                                <tfoot>
                                {{-- <tr hidden>
                                    <td><strong>{{ __('Total') }}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong><span id="total"></span></strong></td>
                                    <td></td>
                                </tr> --}}
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti ti-search  text-black"></i></span>
                                    </div>
                                    {{ Form::text('searchproducts_optional', null, ['class' => 'form-control', 'placeholder' => __('Please add products to optional product')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            {{ Form::label('', __('Optional Product'), ['class' => 'col-form-label']) }}

                            <table class="table carttable-2">
                                <thead class="thead-light">
                                <tr role="row">
                                    <th style="width: 25%;">{{ __('Product') }}</th>
                                    <th style="width: 20%;">{{ __('Price') }}</th>
                                    <th style="width: 12%;">{{ __('Quantity') }}</th>
                                    <th style="width: 20%;">{{ __('Subtotal') }}</th>
                                    <th style="width: 18%;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="optional-product-body">
                                </tbody>
                                <tfoot>
                                
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::label('', __('Optional Talent'), ['class' => 'col-form-label']) }}
                            <a href="javascript:void" 
                                class="btn btn-sm btn-primary btn-icon m-1" id="add-talent">
                                <span class=""><i class="ti ti-plus text-white"></i></span>
                            </a>

                            <table class="table carttable-2">
                                <thead class="thead-light">
                                <tr role="row">
                                    <th style="width: 25%;">{{ __('Talent Grade') }}</th>
                                    <th style="width: 20%;">{{ __('Price') }}</th>
                                    <th style="width: 12%;">{{ __('Quantity') }}</th>
                                    <th style="width: 20%;">{{ __('Subtotal') }}</th>
                                    <th style="width: 18%;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="talent-body">
                                </tbody>
                                <tfoot>
                                
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-right">
                            {{ Form::submit(__('Save Change'), ['class' => 'btn btn-primary float-end']) }}
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

    setInterval(updateAllSubtotals, 1000);

        $(function() {
            $("#date").datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true
            });

            var items = [];
            var total = 0;

            $.ajax({
                url: '{{ route('package.items') }}',
                dataType: 'json',
                data: {
                    'id': '{{ $product->id }}',
                    'field' : 'fixed'
                },
                success: function(data) {

                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            items.push(data[i].product_id);
                            $('<tr id=' + data[i].product_id + '>')
                                .append(
                                    '<td>' + data[i].name + '</td>' +
                                    '<td>' + addCommas(data[i].purchase_price) + '</td>' +
                                    '<td><div class="quantity buttons_added">' +
                                    '<input type="button" value="-" class="minus">' +
                                    '<input type="hidden" name="fixed_product[]" value="' + data[i]
                                    .product_id + '">' +
                                    '<input type="number" step="1" min="1" name="fixed_quantity[]" title="{{ __('Quantity') }}" class="input-number form-control" size="4" data-id="' +
                                    data[i].product_id + '" data-price="' + data[i].purchase_price +
                                    '" data-tax="' + 0 + '" value="' + data[i].quantity +
                                    '">' +
                                    '<input type="button" value="+" class="plus"></div></td>' +
                                    '<td class="total-cell"><span>' + addCommas(data[i].subtotal) + '</span></td>' +
                                    '<td class="btn btn-sm d-inline-flex align-items-center">' +
                                    '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
                                    '</td>'
                                )
                                .appendTo($('#fixed-product-body'));
                            total += data[i].subtotal;
                        }
                        $('#total').text(addCommas(total));
                    }
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });

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
                                    '<td>' + addCommas(ui.item.price) + '</td>' +
                                    '<td><div class="quantity buttons_added">' +
                                    '<input type="button" value="-" class="minus">' +
                                    '<input type="hidden" name="fixed_product[]" value="' + ui.item.id + '">' +
                                    '<input type="number" step="1" min="1" max="' + ui.item.maxquantity +
                                    '" name="fixed_quantity[]" title="{{ __('Quantity') }}" class="input-number form-control" size="4" data-id="' +
                                    ui.item.id + '" data-price="' + ui.item.price + '" data-tax="' + ui.item
                                    .tax + '" value="' + ui.item.quantity + '">' +
                                    '<input type="button" value="+" class="plus"></div></td>' +
                                    '<td class="total-cell"><span>' + addCommas(ui.item.subtotal) + '</span></td>' +
                                    '<td class="btn btn-sm d-inline-flex align-items-center">' +
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

            $(document).on('change', 'input[name="fixed_quantity[]"]', function(e) {
                e.preventDefault();

                var ele = $(this);
                var id = ele.data('id');

                $('tr#' + id + ' td span').text(addCommas(getSubTotal(ele)));

                manageTotals();
            });

            $.ajax({
                url: '{{ route('package.items') }}',
                dataType: 'json',
                data: {
                    'id': '{{ $product->id }}',
                    'field' : 'optional'
                },
                success: function(data) {

                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            items.push(data[i].product_id);
                            $('<tr id=' + data[i].product_id + '>')
                                .append(
                                    '<td>' + data[i].name + '</td>' +
                                    '<td>' + addCommas(data[i].purchase_price) + '</td>' +
                                    '<td><div class="quantity buttons_added">' +
                                    '<input type="button" value="-" class="minus">' +
                                    '<input type="hidden" name="optional_product[]" value="' + data[i]
                                    .product_id + '">' +
                                    '<input type="number" step="1" min="1" name="optional_quantity[]" title="{{ __('Quantity') }}" class="input-number form-control" size="4" data-id="' +
                                    data[i].product_id + '" data-price="' + data[i].purchase_price +
                                    '" data-tax="' + 0 + '" value="' + data[i].quantity +
                                    '">' +
                                    '<input type="button" value="+" class="plus"></div></td>' +
                                    '<td class="total-cell"><span>' + addCommas(data[i].subtotal) + '</span></td>' +
                                    '<td class="btn btn-sm d-inline-flex align-items-center">' +
                                    '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
                                    '</td>'
                                )
                                .appendTo($('#optional-product-body'));
                                manageTotals();
                            total += data[i].subtotal;
                        }
                    }
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });

            $('input[name="searchproducts_optional"]').autocomplete({
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
                                    '<td>' + addCommas(ui.item.price) + '</td>' +
                                    '<td><div class="quantity buttons_added">' +
                                    '<input type="button" value="-" class="minus">' +
                                    '<input type="hidden" name="optional_product[]" value="' + ui.item.id + '">' +
                                    '<input type="number" step="1" min="1" max="' + ui.item.maxquantity +
                                    '" name="optional_quantity[]" title="{{ __('Quantity') }}" class="input-number form-control" size="4" data-id="' +
                                    ui.item.id + '" data-price="' + ui.item.price + '" data-tax="' + ui.item
                                    .tax + '" value="' + ui.item.quantity + '">' +
                                    '<input type="button" value="+" class="plus"></div></td>' +
                                    '<td class="total-cell"><span>' + addCommas(ui.item.subtotal) + '</span></td>' +
                                    '<td class="btn btn-sm d-inline-flex align-items-center">' +
                                    '<a class="action-btn bg-danger"><i class="ti ti-trash text-white remove-items"></i></a>' +
                                    '</td>'
                                )
                                .appendTo($('#optional-product-body'));
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

            // Update the price cell
            const priceCell = row.querySelector('.price-cell');
            const price = grade ? grade.price : 0;
            priceCell.textContent = addCommas(price);

            // Calculate and update total based on quantity
            const quantityInput = row.querySelector('.talent-quantity-input');
            const quantity = parseFloat(quantityInput.value) || 0;
            const totalCell = row.querySelector('.total-cell');
            totalCell.textContent = addCommas(price * quantity);
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

    </script>
@endpush
