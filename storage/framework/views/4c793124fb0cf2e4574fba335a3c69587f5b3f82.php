<?php
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
?>


<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">


<head>
    <title>
        <?php if(trim($__env->yieldContent('page-title'))): ?>
            <?php echo $__env->yieldContent('page-title'); ?> -
        <?php endif; ?>
        <?php echo e(\App\Models\Utility::settings()['company_name'] != '' ? \App\Models\Utility::settings()['company_name'] : config('app.name', 'POSGo Saas')); ?>

    </title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="icon"
        href="<?php echo e($logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image/png">

    <!-- Favicon icon -->

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/libs/animate.css/animate.min.css')); ?>">
    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">

    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/jquery-ui.css')); ?>">


    

    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if(isset($cust_darklayout) && $cust_darklayout == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('old-datatable-css'); ?>
    <?php echo $__env->yieldPushContent('stylesheets'); ?>

</head>





<body class="<?php echo e($color); ?>">
            <div class="container-fluid px-2">
                <?php $lastsegment = request()->segment(count(request()->segments())) ?>
            
                    <div class="row">
                    <div class="col-12">
                        <div class="mt-2 pos-top-bar bg-color d-flex justify-content-between">
                            <span class="text-white"><?php echo e(__('Sales')); ?></span>
                            <a  href="<?php echo e(route('home')); ?>" class="text-white"><i class="ti ti-home" style="font-size: 20px;"></i> </a>
                        </div>
                    </div>
                </div>
            
                    <div class="mt-2 row">
                        <div class="col-lg-7">
                            <div class="sop-card card" style="min-height: 900px;">
                                <div class="card-header p-2">
                                    <div class="search-bar-left">
                                        <form>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                </div>
                                                
                                                <input id="searchproduct" type="text" data-url="<?php echo e(route('search.products')); ?>" placeholder="<?php echo e(__('Search Product')); ?>" class="form-control pr-4 rounded-right">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="right-content">
                                        <div class="button-list b-bottom catgory-pad">
                                            <div class="form-row m-0" id="categories-listing">
                                            </div>
                                        </div>
                                        <div class="product-body-nop">
                                                <div class="form-row" id="product-listing">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 ps-lg-0">
                            <div class="card m-0" style="min-height: 200px;">
                                <div class="card-header p-2">
                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                                                <div class="input-group">
                                                    <?php echo e(Form::select('branch_id', ['' => __('Select Branch Type')], null, ['class' => 'form-control pos_branch_id'])); ?>

                                                </div>
                                                <span id="error_branch_id" style="color: red"></span>
                                            </div>
                                            
            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                                                <div class="input-group">
                                                    <?php echo e(Form::select('cash_register_id', ['' => __('Select Cash Register')], null, ['class' => 'form-control pos_cash_register_id'])); ?>

                                                    
                                                </div>
                                                <span id="error_cash_register_id" style="color: red"></span>
                                            </div>
                                            
            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group search_vendor_merge_input">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i data-feather="user"></i></span>
                                                </div>
                                                <?php echo e(Form::text('searchcustomers', null, ['class' => 'form-control pr-4 rounded-right', 'id' => 'searchcustomers', 'placeholder' => __('Search Customer')])); ?>

                                                <a href="#" id="clearinput">
                                                    <div class="input-group-text">
                                                        <i data-feather="x-square"></i>
                                                    </div>
                                                </a>
                                                <?php echo e(Form::hidden('vc_name_hidden', '', ['id' => 'vc_name_hidden'])); ?>

                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="card-body carttable cart-product-list carttable-scroll"  id="carthtml" >
                                        <?php $total = 0 ?>
                                        <div class="card-header card-body table-border-style">
            
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-center">QTY</th>
                                                        <th>Tax</th>
                                                        <th class="text-center" >Price</th>
                                                        <th class="text-center" >Sub Total</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                        <?php $total = 0 ?>
                                                    <?php if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0): ?>
                                                    <?php $__currentLoopData = session($lastsegment); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                           $product = \App\Models\Product::find($details['id']);
                                                            $image_url = !empty($product->image) && Storage::exists($product->image) ? $product->image : 'logo/placeholder.png';
                                                            $total += $details['subtotal'];
                                                        ?>
                                                            <tr data-product-id="<?php echo e($id); ?>" id="product-id-<?php echo e($id); ?>">
                                                                <td class="col-sm-3 cart-images">
                                                                    <img alt="col-sm-3 Image placeholder" src="<?php echo e(asset(Storage::url($image_url))); ?>" class="card-image avatar sale shadow hover-shadow-lg">
                                                                </td>
                                                                <td class="col-sm-3 name"><?php echo e($details['name']); ?></td>
                                                                <td>
                                                                    <span class="col-sm-6 quantity buttons_added">
                                                                        <input type="button" value="-" class="minus">
                                                                        <input type="number" step="1" min="1" max="" name="quantity"
                                                                                                   title="<?php echo e(__('Quantity')); ?>" class="input-number"
                                                                                                   data-url="<?php echo e(url('update-cart/')); ?>" data-id="<?php echo e($id); ?>"
                                                                                                   size="4" value="<?php echo e($details['quantity']); ?>">
                                                                        <input type="button" value="+" class="plus">
                                                                    </span>
                                                                </td>
                                                                <td class="col-sm-3 tax"><?php echo e($details['tax']); ?>%</td>
                                                                <td class="col-sm-6 price text-center"><?php echo e(Auth::user()->priceFormat($details['price'])); ?></td>
                                                                <td class="col-sm-3 text-center">
                                                                    <span class="subtotal"><?php echo e(Auth::user()->priceFormat($details['subtotal'])); ?></span>
                                                                </td>
            
                                                                <td class="col-sm-2 mt-2">
                                                                    <a href="#" class="action-btn bg-danger bs-pass-para" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                       data-confirm-yes="delete-form-<?php echo e($id); ?>" title="<?php echo e(__('Delete')); ?>" data-id="<?php echo e($id); ?>">
                                                                        <i class="ti ti-trash text-white mx-3 btn btn-sm" title="<?php echo e(__('Delete')); ?>"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'delete', 'url' => ['remove-from-cart'],'id' => 'delete-form-'.$id]); ?>

                                                                    <input type="hidden" name="session_key" value="<?php echo e($lastsegment); ?>">
                                                                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                                                    <?php echo Form::close(); ?>

                                                                </td>
                                                            </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr class="text-center no-found">
                                                            <td colspan="7"><?php echo e(__('No Data Found.!')); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="total-section">
                                                <div class="sub-total">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h4 class="mb-0 text-gray-800">Total</h4>
                                                            <h4 class="mb-0 text-gray-800" id="displaytotal"><?php echo e(Auth::user()->priceFormat($total)); ?></h4>
                                                        </div>
                                                    <div class="d-flex align-items-center justify-content-between pt-3" id="btn-pur">
                                                        
                                                        <div class="tab-content">
                                                            <button type="button" class="btn btn-primary rounded" style="width: 100%"
                                                                 id="pos_payment"  <?php if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0): ?> <?php else: ?> disabled="disabled" <?php endif; ?>><?php echo e(__('PAY')); ?></button>
    
    
    
                                                                 <a href="" id="pos_pay" data-ajax-popup="true" data-size="lg" data-align="centered"
                                                                 data-url="<?php echo e(route('sales.create')); ?>"
                                                                 data-title="<?php echo e(__('Sale Products')); ?>"></a>
                                                        </div>


                                                        


                                                        <div class="tab-content btn-empty text-end">
                                                            <a href="#" class="btn btn-danger bs-pass-para rounded m-0"  data-toggle="tooltip" data-original-title="<?php echo e(__('Empty Cart')); ?>"
                                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                       data-confirm-yes="delete-form-emptycart">
                                                                        <?php echo e(__('Empty Cart')); ?>

                                                                    </a>
                                                            <?php echo Form::open(['method' => 'post', 'url' => ['empty-cart'],'id' => 'delete-form-emptycart']); ?>

                                                            <input type="hidden" name="session_key" value="<?php echo e($lastsegment); ?>" id="empty_cart">
                                                            <?php echo Form::close(); ?>

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

    <script src="<?php echo e(asset('custom/js/jquery.min.js')); ?>"></script>




    
    <script src="<?php echo e(asset('custom/js/jquery.form.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/select2/dist/js/select2.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/libs/moment/moment.js')); ?>"></script>
    
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    <script>
        if ($("#pc-dt-simple").length > 0) {
            const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
        }
    </script>

    <!-- Apex Chart -->
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>



    <script>
        $('#pos_payment').on('click', function() {

            var c_id = $('.pos_cash_register_id').val();
            var b_id = $('.pos_branch_id').val();

            $('#error_branch_id').empty();
            $('#error_cash_register_id').empty();

            if(!c_id){
                $('#error_cash_register_id').text('Cash register is require')
            }
            if(!b_id){
                $('#error_branch_id').text('Branch is require')
            }

            if(b_id && c_id ){
                $( "#pos_pay" ).trigger( "click" );
            }
            


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


    <?php if(\App\Models\Utility::getValByName('gdpr_cookie') == 'on'): ?>
        <script type="text/javascript">
            var defaults = {
                'messageLocales': {
                    /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                    'en': "<?php echo e(\App\Models\Utility::getValByName('cookie_text')); ?>"
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

        <script src="<?php echo e(asset('js/cookie.notice.js')); ?>"></script>
    <?php endif; ?>




    <script>
        var toster_pos = "<?php echo e($SITE_RTL == 'on' ? 'left' : 'right'); ?>";
    </script>


<style type="text/css">

</style>

<?php echo $__env->yieldPushContent('scripts'); ?>

<script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery-ui.js')); ?>"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $( document ).ready(function() {
        
        $( "#vc_name_hidden" ).val($('.customer_select').val());
        $( "#warehouse_name_hidden" ).val($('.warehouse_select').val());

        $(function () {
            getProductCategories();

            var url = '<?php echo e(route('search.products')); ?>'
            searchProducts(url,'','');

        });

        if ($('#searchproduct').length > 0) {
            var url = $('#searchproduct').data('url');
            searchProducts(url,'','0');
        }

        $( '#warehouse' ).change(function() {
           var ware_id = $( "#warehouse" ).val();
            searchProducts(url,'','0',ware_id);
        });
        $( '.customer_select' ).change(function() {
            $( "#vc_name_hidden" ).val($(this).val());
        });
       



        $(document).on('click', '#clearinput', function (e) {
            var IDs = [];
            $(this).closest('div').find("input").each(function () {
                IDs.push('#' + this.id);
            });
            $(IDs.toString()).val('');
        });




        $(document).on('keyup', 'input#searchproduct', function () {
            var url = $(this).data('url');
            var value = this.value;
            var cat = $('.cat-active').children().data('cat-id');
            // console.log(cat);
            searchProducts(url, value,cat);
        });


        function searchProducts(url, value,cat_id,war_id = '0') {
            $.ajax({
                type: 'GET',
                url: url,
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

        function getProductCategories() {
            
            $.ajax({
                type: 'GET',
                url: '<?php echo e(route('product.categories')); ?>',
                success: function (data) {
                    // console.log(data);
                    $('#categories-listing').html(data);
                }
            });
        }

        $(document).on('click', '.toacart', function () {
             // alert('hey');
            var sum = 0;
            $.ajax({
                url: $(this).data('url'),

                success: function (data) {

                    if (data.code == '200') {

                        $('#displaytotal').text(addCommas(data.product.subtotal));

                        if ('carttotal' in data) {
                            $.each(data.carttotal, function (key, value) {
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                sum += value.subtotal;
                            });
                            $('#displaytotal').text(addCommas(sum));
                        }

                        $('#tbody').append(data.carthtml);
                        $('.no-found').addClass('d-none');
                        $('.carttable #product-id-' + data.product.id + ' input[name="quantity"]').val(data.product.quantity);
                        $('#btn-pur button').removeAttr('disabled');
                        $('.btn-empty button').addClass('btn-clear-cart');
                        loadConfirm();
                        }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('<?php echo e(__("Error")); ?>', data.error, 'error');
                }
            });
        });

        $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
            e.preventDefault();
            var ele = $(this);
            var sum = 0;
            var quantity = ele.closest('span').find('input[name="quantity"]').val();

            // console.log(quantity)

            $.ajax({
                url: ele.data('url'),
                method: "patch",
                data: {
                    id: ele.attr("data-id"),
                    quantity: quantity,
                    session_key: session_key
                },
                success: function (data) {

                    if (data.code == '200') {

                        if (quantity == 0) {
                            ele.closest(".row").hide(250, function () {
                                ele.closest(".row").remove();
                            });
                            if (ele.closest(".row").is(":last-child")) {
                                $('#btn-pur button').attr('disabled', 'disabled');
                                $('.btn-empty button').removeClass('btn-clear-cart');
                            }
                        }

                        $.each(data.product, function (key, value) {
                            sum += value.subtotal;
                            $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                        });

                        $('#displaytotal').text(addCommas(sum));
                    }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('<?php echo e(__("Error")); ?>', data.error, 'error');
                }
            });
        });

        $(document).on('click', '.remove-from-cart', function (e) {
            e.preventDefault();

            var ele = $(this);
            var sum = 0;

            if (confirm('<?php echo e(__("Are you sure?")); ?>')) {
                ele.closest(".row").hide(250, function () {
                    ele.closest(".row").parent().parent().remove();
                });
                if (ele.closest(".row").is(":last-child")) {
                    $('#btn-pur button').attr('disabled', 'disabled');
                    $('.btn-empty button').removeClass('btn-clear-cart');
                }
                $.ajax({
                    url: ele.data('url'),
                    method: "DELETE",
                    data: {
                        id: ele.attr("data-id"),
                        // session_key: session_key
                    },
                    success: function (data) {
                        if (data.code == '200') {

                            $.each(data.product, function (key, value) {
                                sum += value.subtotal;
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                            });

                            $('#displaytotal').text(addCommas(sum));

                            show_toastr('Success', data.success, 'success')
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__("Error")); ?>', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-clear-cart', function (e) {
            e.preventDefault();

            if (confirm('<?php echo e(__("Remove all items from cart?")); ?>')) {

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
                        show_toastr('<?php echo e(__("Error")); ?>', data.error, 'error');
                    }
                });
            }
        });

      
        $(document).on('click', '.category-select', function (e) {
            var cat = $(this).data('cat-id');
            var white = 'text-white';
            var dark = 'text-dark';
            $('.category-select').parent().removeClass('cat-active');
            $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
            $('.category-select').find('.card-title').parent().removeClass('text-white').addClass('text-dark');
            $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
            $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
            $(this).parent().addClass('cat-active');
            var url = '<?php echo e(route('search.products')); ?>'
            searchProducts(url,'',cat);
        });
    });


            $(document).on('click', '.btn-done-payment', function(e) {
                e.preventDefault();

                var ele = $(this);

                $.ajax({
                    url: ele.data('url'),
                    method: 'POST',
                    data: {
                        vc_name: $('#vc_name_hidden').val(),
                        branch_id: $('#branch_id').val(),
                        cash_register_id: $('#cash_register_id').val(),
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
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });
            });




            $.ajax({
                url: '<?php echo e(route('user.type')); ?>',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data) {

                        if (data[0].isOwner = 'false') {
                            $.ajax({
                                url: '<?php echo e(route('get.branches')); ?>',
                                dataType: 'json',
                                success: function(data) {

                                    if (data.length == 0) {
                                        // $('#branchModal').modal('show');  
                                        $('#branchModal .branch-warning').show();
                                    } else {
                                        // $('#branchModal .select-warning').show();

                                        $('#branchModal ').modal('show');
                                        // $('#branchModal .select-warning').modal();
                                        $.each(data, function(key, value) {
                                            $('#branch_id')
                                                .append($("<option></option>")
                                                    .attr("value", value.id)
                                                    .text(value.name));
                                        });

                                    }

                                    if ($('[data-toggle="select"]').length > 0) {
                                        $("select option[value='']").prop('disabled', !$(
                                            "select option[value='']").prop(
                                            'disabled'));
                                        $('[data-toggle="select"]').select2({});
                                    }
                                    $('#branchModal').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    })
                                },
                                error: function(data) {
                                    data = data.responseJSON;
                                    show_toastr('<?php echo e(__('Error')); ?>', data.error,
                                        'error');
                                }
                            });
                        } else if (data[0].isUser = 'false') {

                            $('#display-branch').text(data[0].branchname);
                            $('#display-cash-register').text(data[0].cashregistername);

                            $('#branch_id')
                                .append($("<option></option>")
                                    .attr("value", data[0].branch_id)
                                    .text(data[0].branchname));
                            $('#cash_register_id')
                                .append($("<option></option>")
                                    .attr("value", data[0].cash_register_id)
                                    .text(data[0].cashregistername));
                            $('#branch_id').val(data[0].branch_id);
                            $('#cash_register_id').val(data[0].cash_register_id);
                            $('#display-bnc').removeClass('d-none');
                            $('#display-bnc').show();
                        }
                    }
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                }
            });


            $(document).on('change', '#branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
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
            });

            $(document).on('change', '#cash_register_id', function(e) {
                if ($(this).val() != '') {
                    $('#display-branch').text($('#branch_id option:selected').text());
                    $('#display-cash-register').text($('#cash_register_id option:selected').text());
                    $('#display-bnc').removeClass('d-none');
                    $('#display-bnc').show();
                    $('#branchModal').modal('toggle');
                    var cat = $('.cat-active').children().data('cat-id');
                    searchProducts(url, '', cat);
                }
            });



            $("#searchcustomers").autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        $.getJSON("<?php echo e(route('search.customers')); ?>", {
                            search: request.term
                        }, response);
                    },
                    search: function() {
                        var term = this.value;
                        if (term.length == 0) {
                            $("#vc_name_hidden").val('');
                        }
                        if (term.length < 2) {
                            return false;
                        }
                    },
                    focus: function(event, ui) {
                        $("#searchcustomers, #vc_name_hidden").val(ui.item.label);
                        return false;
                    },
                    select: function(event, ui) {
                        $("#searchcustomers, #vc_name_hidden").val(ui.item.label);
                        return false;
                    }
                })
                .autocomplete("instance")._renderItem = function(ul, item) {

                    return $("<li>")
                        .append("<div>" + item.label + "<br>" + item.email + "</div>")
                        .appendTo(ul);
                };

               


</script>


<script>
    var site_currency_symbol_position = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol_position')); ?>';
    var site_currency_symbol = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol')); ?>';
</script>


    <?php if(Session::has('success')): ?>
        <script>
            show_toastr("<?php echo e(__('Success')); ?>", "<?php echo session('success'); ?>", 'success');
        </script>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <script>
            show_toastr("<?php echo e(__('Error')); ?>", "<?php echo session('error'); ?>", 'error');
        </script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/sales/index.blade.php ENDPATH**/ ?>