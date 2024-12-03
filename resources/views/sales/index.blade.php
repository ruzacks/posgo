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

        .table td, .table th {
        padding: 0.75rem 0.75rem !important;
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
                            {{ __('Reservation (Check In)') }}</span>
                            <a  href="#" id="home-btn" class="text-white"><i class="ti ti-home" style="font-size: 20px;"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-md-2 " style="display: flex; align-items: center;">
                                Lokasi
                            </div>
                            <div class="col-md-3">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 d-flex justify-content-start align-items-center">
                                        <h5 id="location_code" class="mb-0 ms-2 text-muted">{{ $location->code ?? '' }} </h5>
                                        <a href="#" class="action-btn bg-info" data-ajax-popup="true" data-bs-toggle="tooltip"
                                        data-title="{{ __('Change Location') }}" title="{{ __('Change Location') }}"
                                        data-size="lg" data-url="{{ route('locations.getLocation') }}">
                                            <i class="ti ti-pencil text-white mx-3 btn btn-sm" title="{{ __('Change Location') }}"></i>
                                        </a>
                                        {{ Form::hidden('current_location_hidden', $location->id ?? '', ['id' => 'current_location_hidden']) }}
                                    </div>
                                </div>        
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                Tipe
                            </div>
                            <div class="col-md-8">
                                {{ Form::select('sale_type',['regular' =>'Regular', 'paket' => 'Paket'],null, ['class' => 'form-control', 'id' => 'sale_type']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                Tanggal
                            </div>
                            <div class="col-md-8">
                                {{ Form::date('sale_date', now(), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2" style="display: flex; align-items: center;">
                                No Invoice
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('sale_id', '', ['class' => 'form-control', 'id' => 'sale_id']) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                    <div class="mt-2 row">
                        <div class="col-lg-12 ps-lg-0">
                            <div class="card m-0 package-container" style="min-height: 200px;">
                                <div class="card-header p-2">
                                    <div class="row">
                                        <div class="col-md-6" id="package-name-section">
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    {{ Form::label('package_name', __('Package Name'), ['class' => 'col-form-label']) }}
                                                </div>
                                                <div class="col-md-8">                       
                                                    {{ Form::text('package_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Package Name'), 'required' => '']) }}
                                                    <div id="autocomplete-list" class="autocomplete-items"></div>
                                                    {{ Form::hidden('package_id', null, ['id' => 'package_id']) }}
                                                    {{ Form::hidden('package_price', null, ['id' => 'package_price']) }}

                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="regular-mintrans-section">
                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    {{ Form::label('min_trans', __('Minimum Transaksi'), ['class' => 'col-form-label']) }}
                                                </div>
                                                <div class="col-md-6">                       
                                                    {{ Form::number('min_trans', null, ['class' => 'form-control', 'required' => '']) }}
                                                    
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body carttable cart-product-list carttable-scroll mt-2"  id="carthtml" >
                                        @php $total = 0 @endphp
                                        <div class="card-header card-body table-border-style">
            
                                            <div class="table-responsive">
                                                <div class="row mx-1">
                                                    <div class="col-md-6" id="package-attribute">
                                                        <div class="label mb-1">Produk</div>
                                                        <table class="table" style="min-height: 100px">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-left">Name</th>
                                                                    <th class="text-center">QTY</th>
                                                                    <th class="text-center">Satuan</th>
                                                                    </tr>
                                                            </thead>
                                                            <tbody id='fixed-product-body'>
        
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <div class="optional-product-container mt-2 mb-2"></div>
                                                        <br>
                                                        <div class="label mt-2" id="talent-title">Pilihan Talent</div>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-left" width="10%">#</th>
                                                                    <th class="text-center" width="90%">Nama</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id='optional-talent-body'>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6" id="regular-attribute">
                                                            <div class="label mb-1" id="additional-product-title">Produk Tambahan</div>
                                                            {{ Form::label('name', __('Product Name'), ['class' => 'col-form-label', 'hidden' => true]) }}
                                                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Product Name'), 'required' => '']) }}
                                                            <div id="autocomplete-list" class="autocomplete-items"></div>
                                                            {{ Form::hidden('product_id', null, ['id' => 'product_id']) }}
                                                            <table class="table" style="min-height: 100px">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-left">Name</th>
                                                                        <th class="text-center">QTY</th>
                                                                        <th class="text-center">Satuan</th>
                                                                        <th class="text-end">Harga</th>
                                                                        <th class="text-end">Subtotal</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='additional-product-body'>
            
                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                                                    <div class="label mt-2" id="talent-title">Talent Tambahan</div>
                                                                    <div>
                                                                        <button id="add-talent" class="btn btn-primary">Tambah Talent</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-left" width="10%">#</th>
                                                                        <th class="text-center" width="40%">Nama</th>
                                                                        <th class="text-center" width="20%">Durasi</th>
                                                                        <th class="text-end" width="20%">Harga</th>
                                                                        <th class="text-end" width="20%">Subtotal</th>
                                                                        <th class="text-center" width="10%"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='additional-talent-body'>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="total-section">
                                                <div class="sub-total">
                                                    <table class="table" style="font-weight:700; color:#ffffff" width="30%">
                                                        <tr>
                                                            <td class="text-end">Total :</td>
                                                            <td class="text-end" width="10%" id="displaytotal">{{ Auth::user()->priceFormat($total) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end">PPn :</td>
                                                            <td class="text-end" width="10%" id="displaytaxtotal">{{ Auth::user()->priceFormat($total) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end">Grand Total :</td>
                                                            <td class="text-end" width="10%" id="displaygrantotal">{{ Auth::user()->priceFormat($total) }}</td>
                                                        </tr>
                                                    </table>
                                                    
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

    <!-- Modal for Talent Selection -->
    <div class="modal fade" id="talentModal" tabindex="-1" role="dialog" aria-labelledby="talentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="talentModalLabel">Pilih Talent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="talent-modal-body">
                           
                        </tbody>
                    </table>
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


    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the sale type default state
        handleSaleTypeChange();
        
        // Add change event listener
        document.getElementById('sale_type').addEventListener('change', function() {
            handleSaleTypeChange();
            updateDisplayTotal();  // Call your update function
        });
    });

    function handleSaleTypeChange() {
        const saleType = document.getElementById('sale_type').value;

        // Regular sale type selected
        if (saleType === 'regular') {
            document.getElementById('package-attribute').hidden = true;
            document.getElementById('regular-attribute').classList.add('col-md-12');
            document.getElementById('regular-attribute').classList.remove('col-md-6');
            document.getElementById('additional-product-title').textContent = 'Pilih produk';
            document.getElementById('talent-title').textContent = 'Pilih Talent';
            document.getElementById('package-name-section').hidden = true;
            document.getElementById('regular-mintrans-section').hidden = false;
            document.querySelector('input[name="package_name"]').value = ''; // Clear package name
            document.querySelector('input[name="package_price"]').value = ''; // Clear package price
        }
        // Package sale type selected
        else if (saleType === 'paket') {
            document.getElementById('package-attribute').hidden = false;
            document.getElementById('regular-attribute').classList.add('col-md-6');
            document.getElementById('regular-attribute').classList.remove('col-md-12');
            document.getElementById('additional-product-title').textContent = 'Produk tambahan';
            document.getElementById('talent-title').textContent = 'Talent tambahan';
            document.getElementById('package-name-section').hidden = false;
            document.getElementById('regular-mintrans-section').hidden = true;
        }

        updateDisplayTotal();
    }



    //PACKAGE HANDLING
    $(document).ready(function() {
        // Autocomplete for vendor name
        $("#package_name").autocomplete({
            minLength: 1,
            source: function (request, response) {
                $.getJSON("{{ route('search.package') }}", {
                    search: request.term,
                }, response);
            },
            search: function () {
                var term = this.value;
                if (term.length == 0) {
                    $("#package_id").val('');
                }
                if (term.length < 1) {
                    return false;
                }
            },
            focus: function (event, ui) {
                $("#package_name").val(ui.item.name); 
                return false;
            },
            select: function (event, ui) {
                $("#package_name").val(ui.item.name);
                $("#package_id").val(ui.item.id);  // Set package_id
                $("#package_price").val(ui.item.sale_price);
                $('#package_id').trigger('change');  // Trigger change event

                updateDisplayTotal();
                return false;
            },
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.name + "</div>")
                .appendTo(ul);
        };

        // Change event for package_id
        $('#package_id').on('change', function() {
            const selectedPackageId = $(this).val();
            if (selectedPackageId) {
                // Make the AJAX request to fetch package details
                $.ajax({
                    url: "{{ route('get.package') }}", // Your route
                    method: "GET",
                    data: { package_id: selectedPackageId }, // Send the vendor ID
                    success: function (response) {
                        populatefixedProductbody(response.package_detail.fixed_products);
                        populateOptionalProducts(response.package_detail.optional_products);
                        populateOptionalTalents(response.package_detail.optional_talents);
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

    function populatefixedProductbody(fixedProducts){
        var fixedProductBody = $('#fixed-product-body'); // Correct variable initialization
        fixedProductBody.empty(); // Clear previous entries

        fixedProducts.forEach(function (fixedProduct) {
            // Create table row
            var row = $('<tr></tr>');

            // Create table data for product name
            var nameCell = $('<td class="text-left"></td>').text(fixedProduct.product.name);

            // Create table data for quantity
            var qtyCell = $('<td class="text-center"></td>').text(fixedProduct.quantity);

            var unitCell = $('<td class="text-center"></td>').text(fixedProduct.product.unit_name);

            // Append cells to the row
            row.append(nameCell);
            row.append(qtyCell);
            row.append(unitCell);

            // Append row to the table body
            fixedProductBody.append(row);
        });
    }

    function populateOptionalProducts(optionalProducts) {
        var container = $('.optional-product-container'); // Target the container
        container.empty(); // Clear any existing content

        optionalProducts.forEach(function (optionalProduct) {
            // Create a section for each optional product group
            var groupDiv = $('<div class="optional-product-group mb-3"></div>');

            // Add a header with description and numOfItems
            var groupHeader = $(
                `<div>Opsional Produk : ${optionalProduct.description} <small>(Pilih Hingga ${optionalProduct.numOfItems} Produk)</small></div>`
            );
            groupDiv.append(groupHeader);

            // Create a table for the products in this group
            var table = $('<table class="table"></table>');
            var thead = $('<thead><tr><th class="text-center">Select</th><th class="text-left">Product Name</th><th class="text-center">Quantity</th><th class="text-center">Satuan</th></tr></thead>');
            table.append(thead);

            var tbody = $('<tbody></tbody>');
            var selectedCount = 0; // Track the number of selected checkboxes for this group

            optionalProduct.products.forEach(function (productData) {
                var product = productData.product; // Access the product object
                var row = $('<tr></tr>');

                // Checkbox input with a change event listener
                var checkboxCell = $('<td class="text-center"></td>');
                var checkbox = $('<input type="checkbox" class="product-checkbox">');
                checkbox.on('change', function () {
                    if (this.checked) {
                        selectedCount++;
                    } else {
                        selectedCount--;
                    }
                    // Disable unchecked checkboxes if the limit is reached for this group
                    if (selectedCount >= parseInt(optionalProduct.numOfItems)) {
                        tbody.find('.product-checkbox:not(:checked)').prop('disabled', true);
                    } else {
                        tbody.find('.product-checkbox').prop('disabled', false);
                    }
                });

                checkboxCell.append(checkbox);

                // Create table cells for product name and quantity
                var nameCell = $('<td class="text-left"></td>').text(product.name);
                var qtyCell = $('<td class="text-center"></td>').text(productData.quantity);
                var unitCell = $('<td class="text-left"></td>').text(product.unit_name);

                // Append cells to the row
                row.append(checkboxCell, nameCell, qtyCell, unitCell);

                // Append row to tbody
                tbody.append(row);
            });

            table.append(tbody);
            groupDiv.append(table);

            // Append this group to the container
            container.append(groupDiv);
        });
    }

    function populateOptionalTalents(optionalTalents) {
        var talentBody = $('#optional-talent-body'); // Target the tbody
        talentBody.empty(); // Clear any existing content
        var talentCount = 1;
        optionalTalents.forEach(function (optionalTalent, index) {
            // Generate rows based on the quantity
            for (let i = 0; i < parseInt(optionalTalent.quantity); i++) {
                // Create a table row
                var row = $('<tr></tr>');

                // Index column
                var indexCell = $('<td class="text-left"></td>').text(talentCount); // Sub-index for each grade

                // Talent input column
                var talentCell = $('<td class="text-center"></td>');
                var talentInput = $(`<input type="text" 
                                        class="form-control talent-input" 
                                        placeholder="Pilih Talent Grade ${optionalTalent.talent.name}" 
                                        readonly>`);
                var hiddenInput = $(`<input type="hidden" class="talent-id-input" name="talents[${index}][${i}][talent_id]">`);

                // Add click event to open modal
                talentInput.on('click', function () {
                    const currentTalentInput = $(this); // Reference the clicked input
                    const currentHiddenInput = currentTalentInput.siblings('.talent-id-input'); // Related hidden input

                    // Update modal title
                    updateTalentModalTitle(optionalTalent.talent.name);

                    // Make an AJAX request to get talents by grade
                    $.ajax({
                        url: '{{ route('get.talent.by.grade') }}', // Replace with your route
                        type: 'GET',
                        data: { grade_id: optionalTalent.grade_id }, // Pass grade_id as a parameter
                        success: function (response) {
                            // Populate the modal with filtered talents
                            populateTalentModal(response.talents, optionalTalent.grade_id, currentTalentInput, currentHiddenInput);

                            // Show the modal
                            $('#talentModal').modal('show');
                        },
                        error: function () {
                            alert('Failed to load talents. Please try again.');
                        }
                    });
                });

                // Append the input and hidden input to the cell
                talentCell.append(talentInput, hiddenInput);

                // Append cells to the row
                row.append(indexCell, talentCell);

                // Append row to tbody
                talentBody.append(row);

                talentCount++;
            }
        });

        var talentTableTitle = generateTalentString(optionalTalents);
        $('#talent-title').text(`Pilihan Talent (${talentTableTitle})`);
    }

    function generateTalentString(optionalTalents) {
        return optionalTalents
            .map(talent => `${talent.quantity} Grade ${talent.talent.name}`) // Create a string for each talent
            .join(', '); // Join the strings with a comma
    }

    // Array to track selected talent IDs globally
    let selectedTalentIds = [];

    // Update modal title dynamically
    function updateTalentModalTitle(gradeName) {
        $('#talentModalLabel').text(`Pilih Talent Grade ${gradeName}`);
    }

    // Populate talent modal with filtering logic
    function populateTalentModal(talentList, gradeId, currentTalentInput, currentHiddenInput) {
        const modalBody = $('#talent-modal-body');
        modalBody.empty(); // Clear existing content

        talentList.forEach(talent => {
            // Check if the talent is already selected
            if (!selectedTalentIds.includes(talent.id)) {
                const talentRow = $(`
                <tr>
                    <td>${talent.name}</td>
                    <td>
                        <button type="button" 
                                class="btn btn-primary pick-optional-talent-btn" 
                                data-talent-id="${talent.id}" 
                                data-talent-name="${talent.name}">
                            Pilih
                        </button>
                    </td>
                </tr>
                `);

                // Add click event for selecting a talent
                talentRow.find('.pick-optional-talent-btn').on('click', function () {
                    const talentId = $(this).data('talent-id');
                    const talentName = $(this).data('talent-name');

                    // Add talent to the selected list
                    selectedTalentIds.push(talentId);

                    // Update input fields
                    currentTalentInput.val(talentName);
                    currentHiddenInput.val(talentId);

                    // Close the modal
                    $('#talentModal').modal('hide');
                });

                modalBody.append(talentRow);
            }
        });
    }

    $('#add-talent').on('click', function () {
        updateTalentModalTitle('Pilih Talent Tambahan');

        $.ajax({
            url: "{{ route('get.talent.by.grade') }}",
            type:'GET',
            success: function (response) {
                // Populate the modal with filtered talents
                populateAdditionalTalentModal(response);

                // Show the modal
                $('#commonModal').modal('show');
            },
            error: function () {
                alert('Failed to load talents. Please try again.');
            }
        });
    });

    function populateAdditionalTalentModal(talentList){
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

        document.addEventListener('click', function (event) {
            if (event.target.closest('.pick-talent-btn')) {
                const talentBtn = event.target.closest('.pick-talent-btn');  // Get the clicked button
                const talentId = $(talentBtn).data('talent-id');
                const talentName = $(talentBtn).data('talent-name');
                const talentPrice = parseFloat($(talentBtn).data('talent-price'));

                selectedTalentIds.push(talentId);

                // Get the current number of rows in the table body to set the index
                const rowCount = $('#additional-talent-body tr').length;

                const newRow = `
                    <tr data-talent-id="${talentId}">
                        <td class="text-left">${rowCount + 1}</td> <!-- Index starts from 1 -->
                        <td class="text-center">${talentName}</td>
                        <td class="text-center">
                            <span class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" style="color: white" name="quantity" title="Quantity" class="input-number" size="4" data-talent-id="${talentId}" value="1">
                                <input type="button" value="+" class="plus">
                            </span>
                        </td>
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

                $('#additional-talent-body').on('change keyup', '.buttons_added input[name="quantity"]', function (e) {
                    const $input = $(this);
                    const duration = parseInt($input.val());
                    const $row = $input.closest('tr');
                    const price = parseFloat($row.find('.price').text().replace('Rp.', '').replace(',', '')); // Extract price
                    const subtotalElement = $row.find('.subtotal');

                    if (!isNaN(duration) && duration > 0) {
                        const newSubtotal = price * duration;
                        subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
                    } else {
                        $input.val(1); // Reset invalid duration to 1
                    }
                    updateDisplayTotal();
                });
            }
        });



        document.addEventListener('click', function (event) {
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

        

 

    //ADD PRODUCT HANDLING
    $("#name").autocomplete({
        minLength: 0, // Trigger even when no input is entered
        source: function (request, response) {
            $.getJSON("{{ route('search.product.json') }}", {
                search: request.term, // Send the input value as 'search'
                type: 'sale'
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
            console.log(ui.item);
            addOrUpdateRow(ui.item);
            $("#name").val('');
            return false; // Prevent default action
        },
    }).autocomplete("instance")._renderItem = function (ul, item) {
        // Render the dropdown menu items
        return $("<li>")
            .append("<div>" + item.label + "<br>Stock: " + item.stock + ", Harga: " + item.purchase_price + "</div>")
            .appendTo(ul);
        };
        
        
    // $(document).on('click', '.autocomplete-item', function () {
    //     let selected = $(this);
    //     let productId = selected.data('id');
    //     let stock = selected.data('stock');
    //     let price = selected.data('price');
    //     let name = selected.text();

    //     // Set values to fields
    //     $('#product_id').val(productId);
    //     $('#name').val(name);
    //     $('#stock').val(stock);
    //     $('#purchase_price').val(price);

    //     // Clear the autocomplete list
    //     $('#autocomplete-list').empty();
    // });

    // // Close autocomplete on outside click
    // $(document).on('click', function (e) {
    //     if (!$(e.target).closest('#name, #autocomplete-list').length) {
    //         $('#autocomplete-list').empty();
    //     }
    // });

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
                const quantity = 1;
                const subtotal = product.sale_price * quantity;

                const newRow = document.createElement('tr');
                newRow.setAttribute('data-product-id', product.id);
                newRow.setAttribute('id', `product-id-${product.id}`);
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
                    <td>
                        ${product.unit_name}
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

        }

        function updateDisplayTotal() {
            let total = 0;
            
            // Loop through all product rows
            const productRows = document.querySelectorAll('#additional-product-body tr');
            productRows.forEach(row => {
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

            // Loop through all talent rows
            const talentRows = document.querySelectorAll('#additional-talent-body tr');
            talentRows.forEach(row => {
                const quantityInput = row.querySelector('input[name="quantity"]');
                const priceElement = row.querySelector('.price');

                if (quantityInput && priceElement) {
                    // Parse price and quantity
                    const price = parseFloat(priceElement.textContent.replace('Rp.', '').replace(',', '')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;

                    // Add talent subtotal to total
                    total += price * quantity;
                }
            });

            // Add package price
            const package_price = $('#package_price').val() || 0;
            total += parseInt(package_price);

            // Calculate PPn (11% tax)
            const tax = total * 0.11;  // 11% tax
            const grandTotal = total + tax;

            // Update the display
            const displayTotal = document.getElementById('displaytotal');
            const displayTaxTotal = document.getElementById('displaytaxtotal');
            const displayGrandTotal = document.getElementById('displaygrantotal');

            // Update the respective totals
            displayTotal.textContent = `Rp.${total.toLocaleString()}`;
            displayTaxTotal.textContent = `Rp.${tax.toLocaleString()}`;
            displayGrandTotal.textContent = `Rp.${grandTotal.toLocaleString()}`;

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



        // document.addEventListener('click', function (event) {
        //     if (event.target.closest('.delete-btn')) {
        //         event.preventDefault();
        //         const deleteBtn = event.target.closest('.delete-btn');
        //         const productId = deleteBtn.getAttribute('data-id');
        //         const confirmText = deleteBtn.getAttribute('data-confirm');
        //         const formId = `remove-product-${productId}`;

        //         Swal.fire({
        //             title: confirmText,
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, delete it!'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 // Remove the row from the table
        //                 const row = document.querySelector(`tr[data-product-id="${productId}"]`);
        //                 if (row) {
        //                     row.remove();
        //                 }

        //                 // Optionally, submit the form if necessary
        //                 const form = document.getElementById(formId);
        //                 if (form) {
        //                     form.submit(); // Submit the form for server-side handling
        //                 }

        //                 // Show success message
        //                 show_toastr('Success', 'The product has been removed.', 'success')
                        
        //                 // Recalculate the total
        //                 updateDisplayTotal();
        //             }
        //         });
        //     }
        // });

        // $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
        //     e.preventDefault();
        //     const $input = $(this);
        //     const quantity = parseInt($input.val());
        //     const $row = $input.closest('tr'); // Find the parent row
        //     const productId = $row.data('product-id');
        //     const price = parseFloat($row.find('.price').text().replace('Rp.', '').replace(',', '')); // Extract price
        //     const subtotalElement = $row.find('.subtotal');

        //     if (!isNaN(quantity) && quantity > 0) {
        //         const newSubtotal = price * quantity;
        //         subtotalElement.text(`Rp.${newSubtotal.toLocaleString()}`);
        //     } else {
        //         $input.val(1); // Reset invalid quantity to 1
        //     }
        //     updateDisplayTotal();
        // });

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
