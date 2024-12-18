<?php
$user = Auth::user();
if ($user) {
    $currantLang = $user->lang;
    $languages = \App\Models\Utility::languages();
}

$emailTemplate     = App\Models\EmailTemplate::first();

// $logo = asset(Storage::url('logo'));
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

$cust_theme_bg = App\Models\Utility::getValByName('cust_theme_bg');
?>

<?php if((isset($cust_theme_bg) && $cust_theme_bg == 'on')): ?>
    <nav class="dash-sidebar light-sidebar transprent-bg">
<?php else: ?>
        <nav class="dash-sidebar light-sidebar">
<?php endif; ?>


<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="<?php echo e(route('home')); ?>" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            
            <img src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png')); ?>"
                alt="<?php echo e(config('app.name', 'Posgo')); ?>" class="logo logo-lg">
           
        </a>
    </div>
    <div class="navbar-content mb-5">
        <ul class="dash-navbar">
            <li class="dash-item  <?php echo e(Request::segment(1) == '' ? 'active' : ''); ?>">
                <a href="<?php echo e(route('home')); ?>" class="dash-link"><span class="dash-micon"><i
                            class="ti ti-home"></i></span><span class="dash-mtext"><?php echo e(__('Dashboard')); ?></span></a>
            </li>

            <?php if(Auth::user() && Auth::user()->parent_id == 0): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="<?php echo e(route('users.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span class="dash-mtext"><?php echo e(__('Owners')); ?></span></a>
                </li>
            <?php else: ?>
                <?php if(Gate::check('Manage User') || Gate::check('Manage Role') || Gate::check('Manage Permission')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-server"></i></span><span
                                class="dash-mtext"><?php echo e(__('Master')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-sub-item mx-2" style="display: none">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage User')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('users.index')); ?>">
                                        <span class="dash-micon"><i class="ti ti-users"></i></span><?php echo e(__('Users')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Vendor')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('vendors.index')); ?>">
                                        <span class="dash-micon"><i class="ti ti-package"></i></span><?php echo e(__('Vendors')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Product')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('products.index')); ?>">
                                        <span class="dash-micon"><i class="ti ti-box"></i></span><?php echo e(__('Products')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Talent')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('talents.index')); ?>">
                                        <span class="dash-micon"><i class="ti ti-star"></i></span><?php echo e(__('Talents')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Location')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('location-types.index')); ?>">
                                        <span class="dash-micon"><i class="ti ti-ticket"></i></span><?php echo e(__('Locations')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('Manage User') || Gate::check('Manage Role') || Gate::check('Manage Permission')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-server"></i></span><span
                                class="dash-mtext"><?php echo e(__('Transaction')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-sub-item mx-2" style="display: none">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchases')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('reports.purchases')); ?>">
                                        <span class="dash-micon"><i class="ti ti-users"></i></span><?php echo e(__('Purchase')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('reports.sales')); ?>">
                                        <span class="dash-micon"><i class="ti ti-users"></i></span><?php echo e(__('Sale')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(Gate::check('Manage User') || Gate::check('Manage Role') || Gate::check('Manage Permission')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-server"></i></span><span
                                class="dash-mtext"><?php echo e(__('Reports')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-sub-item mx-2" style="display: none">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Product')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link sub-item" href="<?php echo e(route('report-stock')); ?>">
                                        <span class="dash-micon"><i class="ti ti-users"></i></span><?php echo e(__('Report Stock')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

          
            <?php if(1<0): ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchases')): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#navbar-purchases"
                        class="dash-link <?php echo e(Request::segment(1) == 'purchases' || Request::segment(1) . '/' . Request::segment(2) == 'reports/purchases' ? 'active' : ''); ?>"><span
                            class="dash-micon"><i class="ti ti-shopping-cart"></i></span><span
                            class="dash-mtext"><?php echo e(__('Purchases')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>



                    <ul class="dash-submenu">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchase')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('purchases.index')); ?>"><?php echo e(__('Add Purchase')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchase')): ?>
                     
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('reports.purchases')); ?>"><?php echo e(__('Purchases')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#" class="dash-link"><span class="dash-micon"><i class="ti ti-book"></i></span><span
                            class="dash-mtext"><?php echo e(__('Sales')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>


                    <ul class="dash-submenu">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('sales.index')); ?>"><?php echo e(__('Add Sale')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                        
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('reports.sales')); ?>"><?php echo e(__('Sales')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#" class="dash-link"><span class="dash-micon"><i class="ti ti-book"></i></span><span
                            class="dash-mtext"><?php echo e(__('Reports')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>


                    <ul class="dash-submenu">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('product.stock.analysis')); ?>"><?php echo e(__('Reports Stock')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                        
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="<?php echo e(route('reports.sales')); ?>"><?php echo e(__('Sales')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Returns')): ?>
                

                <li class="dash-item <?php echo e(\Request::route()->getName() == 'productsreturn.index' || \Request::route()->getName() == 'productsreturn.edit' || \Request::route()->getName() == 'productsreturn.create' ? ' active' : ''); ?>">
                    <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('productsreturn')) ? route(\Auth::user()->getDefualtViewRouteByModule('productsreturn')) : route('productsreturn.index')); ?>" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-receipt-refund"></i></span><span class="dash-mtext"><?php echo e(__('Returns')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            

            


            <?php if(Auth::user()->isSuperAdmin()): ?>
                <li class="dash-item ">
                    <a href="<?php echo e(route('plan_request.index')); ?>"
                        class="dash-link <?php echo e(request()->is('plan_request*') ? 'active' : ''); ?>"><span
                            class="dash-micon"><i class="ti ti-arrow-down-right-circle"></i></span><span
                            class="dash-mtext"><?php echo e(__('Plan Request')); ?></span>
                    </a>
                </li>
            <?php endif; ?>  

            

                <?php if(Auth::user()->isSuperAdmin()): ?>
                    <li class="dash-item <?php echo e((Request::route()->getName() == 'email_template.index' || Request::segment(1) == 'email_template_lang' || Request::route()->getName() == 'manageemail.lang') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('manage.email.language',[$emailTemplate ->id,\Auth::user()->lang])); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-template"></i></span><span
                                class="dash-mtext"><?php echo e(__('Email Template')); ?></span></a>
                    </li>
                <?php endif; ?>

                



            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Coupon')): ?>
                <li class="dash-item dash-hasmenu">
                    <li class="dash-item <?php echo e(\Request::route()->getName() == 'coupons.index' || \Request::route()->getName() == 'coupons.show' ? ' active' : ''); ?>">
                        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('coupons')) ? route(\Auth::user()->getDefualtViewRouteByModule('coupons')) : route('coupons.index')); ?>" class="dash-link ">
                            <span class="dash-micon"><i class="ti ti-gift"></i></span><span class="dash-mtext"><?php echo e(__('Coupons')); ?></span>
                        </a>
                    </li>
                </li>
            <?php endif; ?>


            

            <?php if(Gate::check('Manage Product') || Gate::check('Manage Category') || Gate::check('Manage Brand') || Gate::check('Manage Tax') || Gate::check('Manage Expense') || Gate::check('Manage Customer') || Gate::check('Manage Vendor') || Gate::check('Manage Purchases') || Gate::check('Manage Sales')): ?>
                <li
                    class="dash-item dash-hasmenu 
                <?php echo e(Request::segment(1) == 'product-stock-analysis' ||
                Request::segment(1) == 'product-category-analysis' ||
                Request::segment(1) == 'product-brand-analysis' ||
                Request::segment(1) == 'product-tax-analysis' ||
                Request::segment(1) == 'expense-analysis' ||
                Request::segment(1) == 'customer-sales-analysis' ||
                Request::segment(1) == 'vendor-purchased-analysis' ||
                Request::segment(1) == 'purchased-daily-analysis' ||
                Request::segment(1) == 'purchased-monthly-analysis' ||
                Request::segment(1) == 'sold-daily-analysis' ||
                Request::segment(1) == 'sold-monthly-analysis'
                    ? 'active dash-trigger'
                    : ''); ?>">
                    <a href="#" class="dash-link "><span class="dash-micon"><i
                                class="ti ti-report"></i></span><span
                            class="dash-mtext"><?php echo e(__('Reports')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">


                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Product')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('product.stock.analysis')); ?>"><?php echo e(__('Stock Analysis')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Category')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('product.category.analysis')); ?>"><?php echo e(__('Category Report')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Brand')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('product.brand.analysis')); ?>"><?php echo e(__('Brand Report')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Tax')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('product.tax.analysis')); ?>"><?php echo e(__('Tax Report')); ?></a>
                            </li>
                        <?php endif; ?>

                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Customer')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('customer.sales.analysis')); ?>"><?php echo e(__('Customer Report')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Vendor')): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link"
                                    href="<?php echo e(route('vendor.purchased.analysis')); ?>"><?php echo e(__('Vendor Report')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Purchases')): ?>
                            <li
                                class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'purchased-daily-analysis' || Request::segment(1) == 'purchased-monthly-analysis' ? 'active' : ''); ?>">
                                <a class="dash-link "
                                    href="<?php echo e(route('purchased.daily.analysis')); ?>"><?php echo e(__('Purchase Daily/Monthly Report')); ?></a>
                            </li>
                        <?php endif; ?>


                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>
                            <li
                                class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'sold-daily-analysis' || Request::segment(1) == 'sold-monthly-analysis' ? 'active' : ''); ?>">
                                <a class="dash-link "
                                    href="<?php echo e(route('sold.daily.analysis')); ?>"><?php echo e(__('Sale Daily/Monthly Report')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- Setting -->
            <?php if(Auth::user() && Auth::user()->parent_id == 0): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="<?php echo e(route('settings.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-settings"></i></span><span
                            class="dash-mtext"><?php echo e(__('Settings')); ?></span></a>
                </li>
            <?php else: ?>

                <?php if(Gate::check('Store Settings') || Gate::check('Manage Branch') || Gate::check('Manage Cash Register') || Gate::check('Manage Branch Sales Target')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-settings"></i></span><span
                                class="dash-mtext"><?php echo e(__('Settings')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Store Settings')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link"
                                        href="<?php echo e(route('settings.index')); ?>"><?php echo e(__('Store Settings')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->isSuperAdmin()): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link"
                                        href="<?php echo e(route('branches.index')); ?>"><?php echo e(__('Branches')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->isSuperAdmin()): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link"
                                        href="<?php echo e(route('cashregisters.index')); ?>"><?php echo e(__('Cash Registers')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->isSuperAdmin()): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a class="dash-link"
                                        href="<?php echo e(route('branchsalestargets.index')); ?>"><?php echo e(__('Branch Sales Target')); ?></a>
                                </li>
                            <?php endif; ?>

                            <br>
                            <li class="dash-item dash-hasmenu">
                            </li>
                            <li class="dash-item dash-hasmenu">
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php endif; ?>


        </ul>
    </div>
    </ul>

</div>
</div>
</nav>
<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/sidenav.blade.php ENDPATH**/ ?>