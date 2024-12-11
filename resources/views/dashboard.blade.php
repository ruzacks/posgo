@extends('layouts.app')

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Dashboard') }}</h5>
    </div>
@endsection

@section('page-title', __('Dashboard'))


@section('header-content')
    <div class="row">
        {{-- @if (count($lowstockproducts) > 0)
            <div class="col-md-12">
                @foreach ($lowstockproducts as $product)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
                        <strong>{{ $product['name'] }}</strong><small>{{ __(' (Only ') . $product['quantity'] . __(' items left)') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            </div>
        @endif --}}

{{-- 
        @if (isset($notifications) && !empty($notifications) && count($notifications) > 0)
            <div class="col-md-12">
                @foreach ($notifications as $notification)
                    <div class="alert alert-{{ $notification->color }} alert-dismissible fade show" role="alert">
                        <strong>{!! $notification->description !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            </div>
        @endif
    </div> --}}

    @if ($branches == 0 || $cashregisters == 0 || $productscount == 0 || $customers == 0 || $vendors == 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <?php
                $alerts = [];
                
                $alerts[] = $branches == 0 ? __('Please add some Branches!') : '';
                
                $alerts[] = $cashregisters == 0 ? __('Please add some Cash Registers!') : '';
                
                $alerts[] = $productscount == 0 ? __('Please add some Products!') : '';
                
                $alerts[] = $customers == 0 ? __('Please add some Customers!') : '';
                
                $alerts[] = $vendors == 0 ? __('Please add some Vendors!') : '';
                
                $result = array_filter($alerts);
                ?>
                @if (isset($result) && !empty($result) && count($result) > 0)
                    @foreach ($result as $alert)
                        <div class="alert alert-warning alert-dismissible fade show  mt-1" role="alert">
                            <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
                            <strong>{{ $alert }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif


    <div class="row">

        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-chart-pie"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Sales Of This Day') }}</p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0">{{ $dailySelledAmount }}<span
                                            class="text-danger text-sm"><i class=""></i></span></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-hand-finger"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Sales Of This Month') }}</p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0">{{ $monthlySelledAmount }}<span
                                            class="text-success text-sm"><i class=""></i> </span></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-chart-bar"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Purchase Of This Day') }}</p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0">{{ $dailyPurchasedAmount }}<span
                                            class="text-danger text-sm"><i class=""></i> </span></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Purchase Of This Month') }}</p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0">{{ $monthlyPurchasedAmount }}<span
                                            class="text-success text-sm"><i class=""></i> </span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Sale') }}</th>
                                            <th>{{ __('Check In') }}</th>
                                            <th>{{ __('Check Out') }}</th>
                                            <th>{{ __('Elapsed') }}</th>
                                            <th width="200px">{{ __('Action') }}</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="2">
                                                {{-- <input type="text" id="codeFilter" class="form-control" placeholder="{{ __('Kode Lokasi') }}"> --}}
                                                {{ Form::select('', $locationTypes, null, ['class' => 'form-control', 'data-toggle' => 'select', 'id' => 'codeFilter']) }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($locations as $key => $location)
                                            @php
                                                // Generate random check-in time within a specific range
                                                $randomCheckIn = \Carbon\Carbon::now()->subDays(rand(0, 5))->setTime(rand(0, 23), rand(0, 59));
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="elapsed-time" data-start="">
                                                </td>
                                                <td class="Action">
                                                    <div class="d-flex justify-content-start align-items-center gap-2">
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
                                                            @if($location->status == 'available')
                                                            <div class="action-btn bg-primary">
                                                                <a href="{{ route('sales.index', ['location_id' => $location->id]) }}"
                                                                    class="mx-3 btn btn-primary d-inline-flex align-items-center"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ __('Transaction') }}">
                                                                    check-in</i>
                                                                </a>
                                                            </div>
                                                            @else
                                                            <div class="action-btn bg-primary">
                                                                <a href="#" class="mx-3 btn btn-success d-inline-flex align-items-center" data-bs-toggle="tooltip"
                                                                    title="{{ __('Transaction') }}"
                                                                    onclick="toggleWindow({{ $location->id }})">
                                                                    add-item/check-out</i>
                                                                </a>
                                                            </div>
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

                <div class="col-md-3">
                    <div class="card p-2 ">
                        {{ Form::select('stock_notif', ['min' => 'Min Stock', 'max' => 'Max Stock'], null, ['class' => 'form-control mb-3', 'data-toggle' => 'select', 'required' => '']) }}
                        <div class="stock_notification_area">
                            
                        </div>
                       
                    </div>
                </div>

                @if (isset($saletarget) && !empty($saletarget) && count($saletarget) > 0)

                    @foreach ($saletarget as $target)
                        <div class="col-xxl-5">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Branches Target') }} (<small>{{ __('This Month') }}</small>)</h5>
                                    <div class="row align-items-center">
                                        <div class="col">
                                        </div>

                                    </div>
                                </div>
                                <div class="">
                                    <table class="table align-items-center mb-0 ">
                                        <thead class="thead-light">
                                            <tr class="border-top-0">
                                                <th class="w-25">{{ __('Branch Name') }}</th>
                                                <th class="w-25">{{ __('Target') }}</th>
                                                <th class="w-25">{{ __('Sales') }}</th>
                                                <th class="w-25">{{ __('Progress') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @if (isset($target['branch']) && count($target['branch']) > 0)
                                                @for ($i = 0; $i < count($target['branch']); $i++)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <span
                                                                        class="name mb-0 text-sm">{{ $target['branch'][$i] }}</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="budget">
                                                            {{ $target['totaltarget'][$i] }}
                                                        </td>
                                                        <td>
                                                            {{ $target['totalselledprice'][$i] }}
                                                        </td>
                                                        <td class="circular-progressbar p-0">
                                                            <?php
                                                            $percentage = $target['percentage'][$i];
                                                            
                                                            $status = $percentage > 0 && $percentage <= 25 ? 'red' : ($percentage > 25 && $percentage <= 50 ? 'orange' : ($percentage > 50 && $percentage <= 75 ? 'blue' : ($percentage > 75 && $percentage <= 100 ? 'green' : '')));
                                                            ?>
                                                            <div class="flex-wrapper">
                                                                <div class="single-chart">
                                                                    <svg viewBox="0 0 36 36"
                                                                        class="circular-chart {{ $status }}">
                                                                        <path class="circle-bg"
                                                                            d="M18 2.0845
                                                                                                      a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                      a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <path class="circle"
                                                                            stroke-dasharray="{{ $percentage }}, 100"
                                                                            d="M18 2.0845
                                                                                                      a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                      a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <text x="18" y="20.35"
                                                                            class="percentage">{{ $percentage }}%</text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                @endif

            </div>
        </div>





    </div>

    {{-- <div class="window-backdrop" style="display: none;"></div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
        Open Payment Modal
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: #22242C; color: white;">
            <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="">
                <div class="sop-card card form-group p-2">
                <div class="row">
                    <div class="col-md-7">
                    <div class="row form-group-window">
                        <label for="invoice_id" class="col-md-3 form-window-label text-white text-right">
                        {{ __('No Invoice') }}
                        </label>
                        <div class="col-md-9">
                        {{ Form::text('invoice_id', '', ['class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="location" class="col-md-3 form-window-label text-white text-right">
                        {{ __('Location') }}
                        </label>
                        <div class="col-md-9">
                        {{ Form::text('location', '', ['class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="sal_date" class="col-md-3 form-window-label text-white text-right">
                        {{ __('Tanggal') }}
                        </label>
                        <div class="col-md-9">
                        {{ Form::text('sal_date', '', ['class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="check_in" class="col-md-3 form-window-label text-white text-right">
                        {{ __('Check-in') }}
                        </label>
                        <div class="col-md-3">
                        {{ Form::text('check_in', '', ['class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                        <label for="check_out" class="col-md-3 form-window-label text-white text-right">
                        {{ __('Check-out') }}
                        </label>
                        <div class="col-md-3">
                        {{ Form::text('check_out', '', ['class' => 'form-control form-window', 'readonly' => true]) }}
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12" id="regular-attribute">
                    <div class="label mb-1" id="additional-product-title"></div>
                    {{ Form::label('name', __('Product Name'), ['class' => 'col-form-label', 'hidden' => true]) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Add Product'), 'required' => '']) }}
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
                        <tbody id="additional-product-body">
                        </tbody>
                    </table>
                    </div>
                </div>                
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div> --}}


<!-- EasyUI Window (initially hidden) -->
<div id="paymentWindow" class="easyui-window" title="Payment" style="width:1024px;height:820px;padding:10px;background: #22242C;color: white;display:none" data-options="iconCls:'icon-save',modal:true">
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
                        </div>
                    </div>
                    <div class="row form-group-window">
                        <label for="location" class="col-md-3 form-window-label text-white text-right">
                            {{ __('Location') }}
                        </label>
                        <div class="col-md-9">
                            {{ Form::text('location', '', ['id' => 'location', 'class' => 'form-control form-window', 'readonly' => true]) }}
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
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                {{ Form::radio('pay_type', 'cash', null, ['class' => 'form-check-input', 'id' => 'cash_type']) }}
                                {{ Form::label('cash_type', __('Cash'), ['class' => 'form-check-label']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                {{ Form::radio('pay_type', 'Card', null, ['class' => 'form-check-input', 'id' => 'card_type']) }}
                                {{ Form::label('card_type', __('Card'), ['class' => 'form-check-label']) }}
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary">BAYAR</button>
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
                <button class="btn btn-primary mx-2">Save</button>
                <button class="btn btn-info" onclick="checkOut()">Check-Out</button>
            </div>
        </div>
    </div>
</div>

{{-- <div id="win" class="easyui-window" title="My Window" style="width:600px;height:400px"
        data-options="iconCls:'icon-save',modal:true">
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north',split:true" style="height:100px"></div>
        <div data-options="region:'center'">
            The Content.
        </div>
    </div>
</div> --}}

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script>
        (function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'area', 
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                        name: '{{ __('Purchase') }}',
                        data: {!! json_encode($purchasesArray['value']) !!}
                        // data: [200,300,400,500,600,700,800,500,400,600,500,700,700,300,500]

                    },
                    {
                        name: '{{ __('Sales') }}',
                        data: {!! json_encode($salesArray['value']) !!}
                        // data: [300,400,450,500,600,700,600,400,450,500,600,700,750,550,600]

                    },
                ],
                xaxis: {
                    categories: {!! json_encode($purchasesArray['label']) !!},
                    title: {
                        text: '{{ __('Days') }}'
                    }
                },
                colors: ['#FF3A6E', '#6fd943'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                // markers: {
                //     size: 4,
                //     colors: ['#ffa21d', '#FF3A6E'],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // },
                yaxis: {
                    title: {
                        text: '{{ __('Amount') }}'
                    },
                }
            };
            var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
            chart.render();
        })();


        $(document).on('click', '.custom-checkbox .custom-control-input', function(e) {
            $.ajax({
                url: $(this).data('url'),
                method: 'PATCH',
                success: function(response) {},
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('{{ __('Error') }}', data.error, 'error')
                }
            });
        });
    </script>
@endpush


@push('scripts')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.js') }}"></script>


    <script type="text/javascript">
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    timeGridDay: "{{__('Day')}}",
                    timeGridWeek: "{{__('Week')}}",
                    dayGridMonth: "{{__('Month')}}"
                    },
                themeSystem: 'bootstrap',

                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events: {!! $arrEvents !!},



                eventClick: function(e) {
                    e.jsEvent.preventDefault();
                    var title = e.title;
                    var url = e.el.href;

                    if (typeof url != 'undefined') {
                        $("#commonModal .modal-title").html(e.event.title);
                        $("#commonModal .modal-dialog").addClass('modal-md');
                        $("#commonModal").modal('show');

                        $.get(url, {}, function(data) {
                            console.log(data);
                            $('#commonModal .body ').html(data);

                            if ($(".d_week").length > 0) {
                                $($(".d_week")).each(function(index, element) {
                                    var id = $(element).attr('id');

                                    (function() {
                                        const d_week = new Datepicker(document
                                            .querySelector('#' + id), {
                                                buttonClass: 'btn',
                                                format: 'yyyy-mm-dd',
                                            });
                                    })();

                                });
                            }


                        });
                        return false;
                    }
                }

            });

            calendar.render();
        })();
    </script>

    <script>



$(document).ready(function() {
    const parentWindow = $('#paymentWindow').closest('.panel.window');
    const shadow = parentWindow.siblings('.window-shadow');
    const backdrop = $('.window-mask');
    // Make sure the elements are hidden initially
    parentWindow.hide();
    shadow.hide();
    backdrop.hide();

    $(document).ready(function () {
        $('#card_number').inputmask('9999-9999-9999-9999', { placeholder: '_' });
    });
});

function toggleWindow(locationId = null) {
        const parentWindow = $('#paymentWindow').closest('.panel.window');
        const shadow = parentWindow.siblings('.window-shadow'); // Selects the sibling shadow element
        const backdrop = $('.window-mask'); // The backdrop element

        console.log(locationId);

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
                top: '9px',               // Maintain the fixed top value
            });

            shadow.css({
                left: `${leftPosition}px`, // Match the shadow position
                top: '9px',               // Match the shadow top value
            });

            $.ajax({
                url: "{{ route('getLocation.sale', ':location_id') }}".replace(':location_id', locationId),
                success(response) {
                    // if (response.status == 200) {
                        populatePaymentWindow(response);
                    // }
                }
            });
        } else {
            // Hide backdrop when the window is not visible
            backdrop.fadeOut(200); // Fade-out effect
        }
    }

    function populatePaymentWindow(paymentData){
       $('#invoice_id').val(paymentData.invoice_id);
       $('#location').val(paymentData.location_code);
       $('#sal_date').val(paymentData.sal_date);
       $('#check_in').val(paymentData.formatted_check_in);

       //selled_item
       $('#additional-product-body').innerHTML = '';
       paymentData.selled_item.forEach(selledItem => {
            const productData = {
                id: selledItem.product_id,
                label: selledItem.product.name, // Name comes from the product object
                sale_price: selledItem.price,  // Price comes from selled_item
                unit_name: selledItem.unit,    // Unit comes from selled_item
                quantity: selledItem.quantity // Quantity comes from selled_item
            };

            // Call the existing addOrUpdateRow function
            addOrUpdateRow(productData);
        });

        $('#additional-talent-body').innerHTML = '';
    }

    function checkOut() {
        const location = $('#location').val(); // Get the value of the location input

        if (location) {
            // Redirect to the check-out URL with the location parameter
            window.location.href = `/check-out?location=${encodeURIComponent(location)}`;
        } else {
            alert('Please select a location before proceeding.');
        }
    }

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

                tbody.appendChild(newRow);
            }
            updateDisplayTotal();

            $(document).on('change keyup', '#additional-product-body input[name="quantity"]', function (e) {
                e.preventDefault();
                const $input = $(this);
                const quantity = parseInt($input.val());
                const $row = $input.closest('tr'); // Find the parent row
                const productId = $row.data('product-id');
                const price = parseFloat($row.find('.price').text().replace('Rp.', '').replace(/,/g, '')); // Extract price
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

        let selectedTalentIds = [];



        $('#add-talent').on('click', function () {
        // updateTalentModalTitle('Pilih Talent Tambahan');

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

        document.addEventListener('click', function (event) {
            if (event.target.closest('.pick-talent-btn')) {
                const talentBtn = event.target.closest('.pick-talent-btn');  // Get the clicked button
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
                                <input type="number" step="1" min="1" style="color: white" name="quantity" title="Quantity" class="input-number" size="4" data-talent-id="${talentId}" value="1">
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
            updateDisplayTotal();
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
                const paid = $('#paid').val() || 0;
                const unpaid = grandTotal - paid;

                // Update the form fields
                document.getElementById("total").value = `${total.toLocaleString()}`;
                document.getElementById("tax").value = `${tax.toLocaleString()}`;
                document.getElementById("grand_total").value = `${grandTotal.toLocaleString()}`;
                document.getElementById("paid").value = `${paid.toLocaleString()}`;
                document.getElementById("unpaid").value = `${unpaid.toLocaleString()}`;
            }

            // // Event listeners for quantity changes
            // document.querySelectorAll("#additional-product-body .quantity-input").forEach(input => {
            //     input.addEventListener("input", calculateTotals);
            // });

        // Define the function that makes the AJAX call
        function fetchStockNotification(stockType) {
            $.ajax({
                url: "{{ route('stock.notification', ':stock_type') }}".replace(':stock_type', stockType),
                type: 'GET',
                success: function (response) {
                    // Update the notification container with the response HTML
                    document.querySelector('.stock_notification_area').innerHTML = response.html;
                },
                error: function (error) {
                    console.error("Error fetching stock notifications:", error);
                }
            });
        }

        // Trigger the AJAX call on page load
        const initialStockType = $('select[name="stock_notif"]').val();
        fetchStockNotification(initialStockType);

        // Trigger the AJAX call when the dropdown changes
        $('select[name="stock_notif"]').on('change', function () {
            const selectedStockType = $(this).val();
            fetchStockNotification(selectedStockType);
        });

        // Ticking Elapsed Time Counter
        // function updateElapsedTime() {
        //     document.querySelectorAll('.elapsed-time').forEach(function(element) {
        //         const startTime = new Date(element.getAttribute('data-start')).getTime();
        //         const now = new Date().getTime();
        //         const elapsed = new Date(now - startTime);

        //         const hours = String(elapsed.getUTCHours()).padStart(2, '0');
        //         const minutes = String(elapsed.getUTCMinutes()).padStart(2, '0');
        //         const seconds = String(elapsed.getUTCSeconds()).padStart(2, '0');

        //         element.textContent = `${hours}:${minutes}:${seconds}`;
        //     });
        // }

        // setInterval(updateElapsedTime, 1000);

        function applyFilters() {
            // let categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
            // let nameFilter = document.getElementById('nameFilter').value.toLowerCase();
            let codeFilter = document.getElementById('codeFilter').value.toLowerCase();
            let rows = document.querySelectorAll('#pc-dt-simple tbody tr');

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
@endpush
