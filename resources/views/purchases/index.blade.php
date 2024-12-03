@php
//  $logo=\App\Models\Utility::get_file('uploads/logo/');
$company_favicon = App\Models\Utility::getValByName('company_favicon');
$SITE_RTL = App\Models\Utility::getValByName('SITE_RTL');
$setting = App\Models\Utility::colorset();
$cust_darklayout = App\Models\Utility::getValByName('cust_darklayout');
$theme_color = App\Models\Utility::getValByName('color');
$color = 'theme-3';
if (!empty($theme_color)) {
    $color = $theme_color;
}

if (\Auth::user()->type == 'Super Admin'){

$logo=\App\Models\Utility::get_file('uploads/logo/');
}
else {
$logo=\App\Models\Utility::get_file('/');

}

if (\Auth::user()->type == 'Super Admin') {
    $company_logo = Utility::get_superadmin_logo();
} else {
    $company_logo = Utility::get_company_logo();
}
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">
{{-- {{ dd($setting) }} --}}

<head>
    <title>
        @if (trim($__env->yieldContent('page-title')))
            @yield('page-title') -
        @endif
        {{ \App\Models\Utility::settings()['company_name'] != '' ? \App\Models\Utility::settings()['company_name'] : config('app.name', 'POSGo Saas') }}
    </title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- {{ dd($company_favicon) }} --}}
    <link rel="icon"
        href="{{ $logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image/png">

    <!-- Favicon icon -->

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/libs/animate.css/animate.min.css') }}">
    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">


    {{-- @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
        @if (isset($cust_darklayout) && $cust_darklayout == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        @endif
    @endif --}}

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if (isset($cust_darklayout) && $cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif

    @stack('old-datatable-css')
    @stack('stylesheets')

    <style>
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 200px;
            overflow-y: auto;
            background: #fff;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            background-color: #3498db !important;
            color: #ffffff;
        }
    </style>

</head>



{{-- <body class="theme-1"> --}}

<body class="{{ $color }}">
            <div class="container-fluid px-4">
                <?php $lastsegment = request()->segment(count(request()->segments())) ?>
            
                    <div class="row">
                    <div class="col-12">
                        <div class="mt-2 pos-top-bar bg-primary d-flex justify-content-between">
                                                       
                            <span class="text-white"> <a href="{{ route('reports.purchases') }}" class="text-white">
                                <i class="ti ti-arrow-left" style="font-size: 20px;"></i>
                            </a>
                            {{ __('Purchase') }}</span>
                            <a  href="#" id="home-btn" class="text-white"><i class="ti ti-home" style="font-size: 20px;"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-md-2 " style="display: flex; align-items: center;">
                                Tanggal
                            </div>
                            <div class="col-md-3">
                                {{ Form::date('purchase_date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'purchase_date']) }}
                            </div>
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                No Faktur
                            </div>
                            <div class="col-md-3">
                                {{ Form::text('invoice_id', $tempInvoice, ['class' => 'form-control', 'readonly' => true]) }}
                            </div>
                        </div>
                        <div class="row mt-2 form-group">
                            <div class="col-md-2">
                                {{ Form::label('vendor_name', __('Vendor Name'), ['class' => 'col-form-label']) }}
                            </div>
                            <div class="col-md-8">                       
                                {{ Form::text('vendor_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Vendor Name'), 'required' => '']) }}
                                <div id="autocomplete-list" class="autocomplete-items"></div>
                                {{ Form::hidden('vendor_id', null, ['id' => 'vendor_id']) }}
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                Alamat
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('address', null, ['class' => 'form-control', 'id' => 'address',  'readonly' =>  true]) }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                No. Telepon
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'readonly' =>  true]) }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                No. Faktur Supplier
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('vendor_invoice', null, ['class' => 'form-control', 'id' => 'vendor_invoice', 'autocomplete' => 'off' ]) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                    <div class="mt-2 row">
                        <div class="col-lg-12">
                            <div class="sop-card card">
                                <div class="card-header p-2">
                                    <h4>{{ __('Add Product') }}</h4>
                                    <div class="search-bar-left">
                                        <form>
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    {{ Form::label('name', __('Product Name'), ['class' => 'col-form-label']) }}
                                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Product Name'), 'required' => '']) }}
                                                    <div id="autocomplete-list" class="autocomplete-items"></div>
                                                    {{ Form::hidden('product_id', null, ['id' => 'product_id']) }}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    {{ Form::label('stock', __('Stock'), ['class' => 'col-form-label']) }}
                                                    {{ Form::text('stock', null, ['class' => 'form-control', 'id' => 'stock', 'readonly' => 'readonly']) }}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    {{ Form::label('purchase_price', __('Purchase price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label']) }}
                                                    {{ Form::text('purchase_price', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    {{ Form::label('new_purchase_price', __('New Purchase price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label']) }}
                                                    {{ Form::text('new_purchase_price', null, ['class' => 'form-control', 'id' => 'new_purchase_price', 'placeholder' => 'Harga baru jika ada' ]) }}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    {{ Form::label('qty', __('Purchase Qty.'), ['class' => 'col-form-label']) }}
                                                    {{ Form::number('qty', null, ['class' => 'form-control', 'id' => 'qty']) }}
                                                </div>
                                                <div class="form-group col-md-2 d-flex align-items-end">
                                                    <button class="btn btn-primary w-100 to toacart">{{ __('Tambah') }}</button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-12 ps-lg-0">
                            <div class="card m-0" style="min-height: 200px;">
                                <div class="card-header p-2">

                                  
                                </div>
                                <div class="card-body carttable cart-product-list carttable-scroll"  id="carthtml" >
                                        @php $total = 0 @endphp
                                        <div class="card-header card-body table-border-style">
            
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-end" >Price</th>
                                                        <th class="text-end" >Sub Total</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                        @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                                            @foreach(session($lastsegment) as $id => $details)
                                                                @php
                                                                $product = \App\Models\Product::find($details['id']);
                                                                    $total += $details['subtotal'];
                                                                @endphp
                                                                    <tr data-product-id="{{$id}}" id="product-id-{{$id}}">
                                                                        <td class="col-sm-3 name">{{ $details['name'] }}</td>
                                                                        <td>
                                                                            <span class="col-sm-6 quantity buttons_added">
                                                                                <input type="button" value="-" class="minus">
                                                                                <input type="number" step="1" min="1" max="" name="quantity"
                                                                                                        title="{{ __('Quantity') }}" class="input-number"
                                                                                                        data-url="{{ url('update-cart/') }}" data-id="{{ $id }}"
                                                                                                        size="10" style="color: white" value="{{ $details['quantity'] }}">
                                                                                <input type="button" value="+" class="plus">
                                                                            </span>
                                                                        </td>
                                                                        <td class="col-sm-6 price text-center">{{ Auth::user()->priceFormat($details['price']) }}</td>
                                                                        <td class="col-sm-3 text-center">
                                                                            <span class="subtotal">{{ Auth::user()->priceFormat($details['subtotal']) }}</span>
                                                                        </td>
                    
                                                                        <td class="col-sm-2 mt-2">
                                                                            <a href="#" class="action-btn bg-danger bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}"
                                                                            data-confirm-yes="delete-form-{{ $id }}" title="{{ __('Delete') }}" data-id="{{ $id }}">
                                                                                <i class="ti ti-trash text-white mx-3 btn btn-sm" title="{{ __('Delete') }}"></i>
                                                                            </a>
                                                                            {!! Form::open(['method' => 'delete', 'url' => ['remove-from-cart'],'id' => 'delete-form-'.$id]) !!}
                                                                            <input type="hidden" name="session_key" value="{{ $lastsegment }}">
                                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                                            {!! Form::close() !!}
                                                                        </td>
                                                                    </tr>
                                                            @endforeach
                                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="total-section">
                                                <div class="sub-total">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h4 class="mb-0 text-gray-800">Total</h4>
                                                            <h4 class="mb-0 text-gray-800" id="displaytotal">{{ Auth::user()->priceFormat($total) }}</h4>
                                                        </div>
                                                    <div class="d-flex align-items-center justify-content-between pt-3" id="btn-pur">

                                                        <div class="tab-content">
                                                            
                                                        </div>

                                                        <div class="tab-content btn-empty text-end">
                                                            <button type="button" class="btn btn-primary rounded" style="width: 100%"
                                                            id="pos_payment"  disabled="disabled">{{ __('FINISH') }}</button>


                                                            {{-- <a href="" id="pos_pay" data-ajax-popup="true" data-size="lg" data-align="centered"
                                                            data-url="{{ route('sales.create') }}"
                                                            data-title="{{ __('Sale Products') }}"></a> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            
            </div>


    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">

                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('custom/js/jquery.min.js') }}"></script>




    
    <script src="{{ asset('custom/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('js/select2/dist/js/select2.min.js')}}"></script>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('custom/libs/moment/moment.js') }}"></script>
    
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        if ($("#pc-dt-simple").length > 0) {
            const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
        }
    </script>

    <!-- Apex Chart -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>



    <script>
        $('#pos_payment').on('click', function() {

           
                $( "#pos_pay" ).trigger( "click" );
          
        });
    </script>




    <script>
        $(document).ready(function() {
            // cust_theme_bg();
            // cust_darklayout();


            feather.replace();
            var pctoggle = document.querySelector("#pct-toggler");
            if (pctoggle) {
                pctoggle.addEventListener("click", function() {
                    if (
                        !document.querySelector(".pct-customizer").classList.contains("active")
                    ) {
                        document.querySelector(".pct-customizer").classList.add("active");
                    } else {
                        document.querySelector(".pct-customizer").classList.remove("active");
                    }
                });
            }

            var themescolors = document.querySelectorAll(".themes-color > a");
            for (var h = 0; h < themescolors.length; h++) {
                var c = themescolors[h];

                c.addEventListener("click", function(event) {
                    var targetElement = event.target;
                    if (targetElement.tagName == "SPAN") {
                        targetElement = targetElement.parentNode;
                    }
                    var temp = targetElement.getAttribute("data-value");
                    removeClassByPrefix(document.querySelector("body"), "theme-");
                    document.querySelector("body").classList.add(temp);
                });
            }

            function cust_theme_bg() {
                var custthemebg = document.querySelector("#cust-theme-bg");
                // custthemebg.addEventListener("click", function() {

                if (custthemebg.checked) {
                    document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.add("transprent-bg");
                } else {
                    document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.remove("transprent-bg");
                }
                // });
            }
            var custthemebg = document.querySelector("#cust-theme-bg");
            custthemebg.addEventListener("click", function() {
                if (custthemebg.checked) {
                    document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.add("transprent-bg");
                } else {
                    document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.remove("transprent-bg");
                }
            });




            function removeClassByPrefix(node, prefix) {
                for (let i = 0; i < node.classList.length; i++) {
                    let value = node.classList[i];
                    if (value.startsWith(prefix)) {
                        node.classList.remove(value);
                    }
                }
            }

        });
    </script>


    @if (\App\Models\Utility::getValByName('gdpr_cookie') == 'on')
        <script type="text/javascript">
            var defaults = {
                'messageLocales': {
                    /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                    'en': "{{ \App\Models\Utility::getValByName('cookie_text') }}"
                },
                'buttonLocales': {
                    'en': 'Ok'
                },
                'cookieNoticePosition': 'bottom',
                'learnMoreLinkEnabled': false,
                'learnMoreLinkHref': '/cookie-banner-information.html',
                'learnMoreLinkText': {
                    'it': 'Saperne di più',
                    'en': 'Learn more',
                    'de': 'Mehr erfahren',
                    'fr': 'En savoir plus'
                },
                'buttonLocales': {
                    'en': 'Ok'
                },
                'expiresIn': 30,
                'buttonBgColor': '#d35400',
                'buttonTextColor': '#fff',
                'noticeBgColor': '#000',
                'noticeTextColor': '#fff',
                'linkColor': '#009fdd'
            };
        </script>

        <script src="{{ asset('js/cookie.notice.js') }}"></script>
    @endif




    <script>
        var toster_pos = "{{ $SITE_RTL == 'on' ? 'left' : 'right' }}";
    </script>


<style type="text/css">

</style>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
@stack('scripts')

<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //SUPPLIER HANDLING

    $(document).ready(function() {
        // Autocomplete for vendor name
        $("#vendor_name").autocomplete({
            minLength: 1,
            source: function (request, response) {
                $.getJSON("{{ route('search.vendors') }}", {
                    search: request.term,
                }, response);
            },
            search: function () {
                var term = this.value;
                if (term.length == 0) {
                    $("#vendor_id").val('');
                }
                if (term.length < 1) {
                    return false;
                }
            },
            focus: function (event, ui) {
                $("#vendor_name").val(ui.item.name); 
                return false;
            },
            select: function (event, ui) {
                $("#vendor_name").val(ui.item.name);
                $("#vendor_id").val(ui.item.id);  // Set vendor_id
                $('#vendor_id').trigger('change');  // Trigger change event

                return false;
            },
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.name + "</div>")
                .appendTo(ul);
        };

        // Change event for vendor_id
        $('#vendor_id').on('change', function() {
            const selectedVendorId = $(this).val();
            if (selectedVendorId) {
                // Make the AJAX request to fetch vendor details
                $.ajax({
                    url: "{{ route('get.vendor') }}", // Your route
                    method: "GET",
                    data: { vendor_id: selectedVendorId }, // Send the vendor ID
                    success: function (response) {
                        // Update the address and phone fields with the response
                        $('#address').val(response.address);
                        $('#phone').val(response.phone);
                    },
                    error: function () {
                        alert('Failed to fetch vendor details. Please try again.');
                    }
                });
            } else {
                // Clear fields if no vendor selected
                $('#address').val('');
                $('#phone').val('');
            }
        });
    });

    


    //ADD PRODUCT HANDLING
    $("#name").autocomplete({
        minLength: 0, // Trigger even when no input is entered
        source: function (request, response) {
            $.getJSON("{{ route('search.product.json') }}", {
                search: request.term, // Send the input value as 'search'
            }, response);
        },
        search: function () {
            var term = this.value;
            if (term.length == 0) {
                $("#product_id").val(''); // Clear product_id when input is empty
            }
            if (term.length < 2) {
                return false; // Don't search if input is less than 2 characters
            }
        },
        focus: function (event, ui) {
            $("#name").val(ui.item.label); // Focus does not select an item
            return false;
        },
        select: function (event, ui) {
            // Set the values of other fields when an item is selected
            $("#name").val(ui.item.label);
            $("#product_id").val(ui.item.id);
            $("#stock").val(ui.item.stock);
            $("#purchase_price").val(ui.item.purchase_price);
            return false; // Prevent default action
        },
    }).autocomplete("instance")._renderItem = function (ul, item) {
        // Render the dropdown menu items
        return $("<li>")
            .append("<div>" + item.label + "<br>Stock: " + item.stock + ", Harga: " + item.purchase_price + "</div>")
            .appendTo(ul);
    };


    $(document).on('click', '.autocomplete-item', function () {
        let selected = $(this);
        let productId = selected.data('id');
        let stock = selected.data('stock');
        let price = selected.data('price');
        let name = selected.text();

        // Set values to fields
        $('#product_id').val(productId);
        $('#name').val(name);
        $('#stock').val(stock);
        $('#purchase_price').val(price);

        // Clear the autocomplete list
        $('#autocomplete-list').empty();
    });

    // Close autocomplete on outside click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#name, #autocomplete-list').length) {
            $('#autocomplete-list').empty();
        }
    });

    function dataProduct(clear = false) {
        if (clear) {
            // Clear all input fields
            $('#name').val('');
            $('#product_id').val('');
            $('#new_purchase_price').val('');
            $('#purchase_price').val('');
            $('#stock').val('');
            $('#qty').val('');

            // Set focus to the "name" field
            $('#name').focus();
        } else {
            // Fetch values from input fields
            var productName = $('#name').val();
            var productId = $('#product_id').val();
            var price = $('#new_purchase_price').val() ? $('#new_purchase_price').val() : $('#purchase_price').val();
            var stock = $('#stock').val();
            var quantity = $('#qty').val();

            // Create a product data object with proper type conversion
            var data = {
                name: productName || '', // Default to an empty string if no value
                id: productId || '', // Default to an empty string if no value
                sale_price: parseFloat(price) || 0, // Default to 0 if price is invalid
                quantity: parseInt(quantity) || 0, // Default to 0 if quantity is invalid
                stock: parseInt(stock) || 0 // Default to 0 if stock is invalid
            };

            return data;
        }
    }

    document.addEventListener('click', function (event) {
        
        // Check if the clicked element has the 'toacart' class
        if (event.target.closest('.toacart')) {
            event.preventDefault();
            const element = event.target.closest('.toacart'); // Get the actual element clicked

            // Get the product data
            const product = dataProduct();

            if (product) {
                if (product.quantity === 0 || isNaN(product.quantity)) {
                    // Show an error toast if the quantity is 0 or invalid
                    show_toastr('{{ __("Error") }}', '{{ __("Please enter purchase quantity.") }}', 'error');
                } else {
                    // Add or update the row if quantity is valid and greater than 0
                    addOrUpdateRow(product);
                    dataProduct(true);
                }
            }
        }
    });

        function addOrUpdateRow(product) {
            // Calculate subtotal (assuming 1 quantity for simplicity)
            const tbody = document.getElementById('tbody');
            const existingRow = document.querySelector(`tr[data-product-id="${product.id}"]`);

            if (existingRow) {
                // Update the quantity and subtotal
                const quantityInput = existingRow.querySelector('.input-number');
                const quantity = parseInt(quantityInput.value) + product.quantity; // Increment the quantity by 1
                quantityInput.value = quantity;

                // Update subtotal
                const subtotalElement = existingRow.querySelector('.subtotal');
                const newSubtotal = product.sale_price * quantity;
                subtotalElement.textContent = `Rp.${newSubtotal.toLocaleString()}`;
            } else {
                // Add new row if product doesn't exist in the table
                const quantity = product.quantity;
                const subtotal = product.sale_price * quantity;

                const newRow = document.createElement('tr');
                newRow.setAttribute('data-product-id', product.id);
                newRow.setAttribute('id', `product-id-${product.id}`);
                newRow.innerHTML = `
                    <td class="col-sm-2">
                        <span class="name">${product.name}</span>
                    </td>
                    <td class="col-sm-2 text-center">
                        <span class="quantity buttons_added">
                            <input type="button" value="-" class="minus">
                            <input type="number" step="1" min="1" style="color: white" name="quantity" title="Quantity" class="input-number" size="4" 
                                data-url="/update-cart/" data-id="${product.id}" value="${quantity}">
                            <input type="button" value="+" class="plus">
                        </span>
                    </td>
                    <td class="col-sm-2 text-end">
                        <span class="price">Rp.${product.sale_price.toLocaleString()}</span>
                    </td>
                    <td class="col-sm-2 text-end">
                        <span class="subtotal">Rp.${subtotal.toLocaleString()}</span>
                    </td>
                    <td class="col-sm-2">
                       <div class="col-sm-2 mt-2">
                            <a href="javascript:void(0)" 
                            class="action-btn bg-danger delete-btn" 
                            data-confirm="Are You Sure?" 
                            data-id="${product.id}">
                                <span><i class="ti ti-trash btn btn-sm text-white"></i></span>
                            </a>
                        </div>
                    </td>
                `;

                tbody.appendChild(newRow);
            }
            updateDisplayTotal();
        }

        function updateDisplayTotal() {
            let total = 0;
            const rows = document.querySelectorAll('#carthtml tbody tr');
            const displayTotal = document.getElementById('displaytotal');

            // Loop through all rows in the table
            rows.forEach(row => {
                const quantityInput = row.querySelector('input[name="quantity"]');
                const priceElement = row.querySelector('.price');

                if (quantityInput && priceElement) {
                    // Parse price and quantity
                    const price = parseFloat(priceElement.textContent.replace('Rp.', '').replace(',', '')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;

                    // Add to total
                    total += price * quantity;
                }
            });

            // Update the total display
            displayTotal.textContent = `Rp.${total.toLocaleString()}`;

            // Check payment button condition
            checkPaymentButtonCondition();
        }

        function checkPaymentButtonCondition() {
            const rows = document.querySelectorAll('#carthtml tbody tr');
            const vendorId = document.getElementById('vendor_id') ? document.getElementById('vendor_id').value : null;
            const posPaymentButton = document.getElementById('pos_payment');

            // Enable or disable the payment button based on rows and vendor_id
            if (rows.length > 0 && vendorId) {
                posPaymentButton.disabled = false;
            } else {
                posPaymentButton.disabled = true;
            }
        }

        // Event listener for vendor_id select changes
        document.getElementById('vendor_id').addEventListener('change', checkPaymentButtonCondition);



        document.addEventListener('click', function (event) {
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

        $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
            e.preventDefault();
            const $input = $(this);
            const quantity = parseInt($input.val());
            const $row = $input.closest('tr'); // Find the parent row
            const productId = $row.data('product-id');
            const price = parseFloat($row.find('.price').text().replace('Rp.', '').replace(',', '')); // Extract price
            const subtotalElement = $row.find('.subtotal');

            if (!isNaN(quantity) && quantity > 0) {
                const newSubtotal = price * quantity;
                subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
            } else {
                $input.val(1); // Reset invalid quantity to 1
            }
            updateDisplayTotal();
        });

        document.getElementById('pos_payment').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent any default behavior, e.g., form submission

            // Display SweetAlert confirmation
            Swal.fire({
                title: '{{ __("Finish Purchase") }}', // Dynamically localize the title
                text: '{{ __("Are you sure you want to complete this purchase?") }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("Yes, finish it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fetch purchase data
                    const data = getPurchaseData();

                    // Make AJAX request to store purchase
                    $.ajax({
                        url: '{{ route("purchases.store") }}', // Route to handle the store logic
                        type: 'POST', // HTTP method
                        data: data, // Data payload
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                        },
                        success: function (response) {
                            // Check response status
                            if (response.status === 200) {
                                Swal.fire({
                                    title: '{{ __("Success") }}',
                                    text: '{{ __("The purchase has been completed successfully.") }}',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: '{{ __("Print the Purchase Invoice") }}',
                                    cancelButtonText: '{{ __("Close") }}',
                                }).then((printResult) => {
                                    if (printResult.isConfirmed) {
                                        // Open the invoice link in a new tab
                                        window.open(response.invoice_url, '_blank');
                                    }
                                    // Reload the current page regardless of the user's choice
                                    window.location.reload();
                                });
                            } else if (response.status === 400) {
                                Swal.fire(
                                    '{{ __("Error") }}',
                                    response.message || '{{ __("Invalid data. Please check and try again.") }}',
                                    'error'
                                );
                            } else {
                                Swal.fire(
                                    '{{ __("Error") }}',
                                    '{{ __("Something went wrong. Please try again later.") }}',
                                    'error'
                                );
                            }
                        },
                        error: function (xhr) {
                            const errorMessage = xhr.responseJSON?.message || '{{ __("There was an issue completing the purchase. Please try again.") }}';
                            Swal.fire(
                                '{{ __("Error") }}',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        });




        function getPurchaseData() {
            // Get Vendor ID, Purchase Date, and Vendor Invoice
            const vendorId = $('#vendor_id').val();
            const purcDate = $('#purchase_date').val();
            const vendorInv = $('#vendor_invoice').val();

            // Initialize products array
            const products = [];

            // Loop through each table row in the tbody
            $('#tbody tr').each(function () {
                const row = $(this); // Current row
                const productId = row.data('product-id'); // Get product ID from data attribute
                const qty = parseInt(row.find('input[name="quantity"]').val()) || 0; // Get quantity
                const price = parseFloat(row.find('.price').text().replace('Rp.', '').replace(',', '')) || 0; // Parse price
                const subtotal = parseFloat(row.find('.subtotal').text().replace('Rp.', '').replace(',', '')) || 0; // Parse subtotal

                // Add product data to the array
                products.push({
                    product_id: productId,
                    quantity: qty,
                    price: price,
                    subtotal: subtotal
                });
            });

            // Return all collected data
            return {
                vendor_id: vendorId,
                purchase_date: purcDate,
                vendor_invoice: vendorInv,
                products: products
            };
        }

        function searchProducts(value,cat_id,war_id = '0') {
            $.ajax({
                type: 'GET',
                url: "{{ route('search.products') }}",
                data: {
                    'search': value,
                    'cat_id': cat_id,
                    'war_id' : war_id,
                    'session_key': session_key
                },
                success: function (data) {
                    console.log(data)
                    $('#product-listing').html(data);
                }
            });
        }


       // Use a static parent element that wraps the dynamically created elements
        

        $(document).on('click', '.btn-clear-cart', function (e) {
            e.preventDefault();

            if (confirm('{{ __("Remove all items from cart?") }}')) {

                $.ajax({
                    url: $(this).data('url'),
                    data: {
                        session_key: session_key
                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

      
           $(document).on('click', '.btn-done-payment', function(e) {
                e.preventDefault();

                var ele = $(this);

                $.ajax({
                    url: ele.data('url'),
                    method: 'POST',
                    data: {
                        vc_name: $('#vc_name_hidden').val(),
                        branch_id: 1,
                        cash_register_id: 1,
                    },
                    beforeSend: function() {
                        ele.remove();
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            show_toastr('Success', data.success, 'success')
                        }
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            });

            document.getElementById('home-btn').addEventListener('click', function () {
                window.location.href = '{{ route("home") }}';
            });

</script>


<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
    var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
</script>


    @if (Session::has('success'))
        <script>
            show_toastr("{{ __('Success') }}", "{!! session('success') !!}", 'success');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            show_toastr("{{ __('Error') }}", "{!! session('error') !!}", 'error');
        </script>
    @endif
</body>

</html>
