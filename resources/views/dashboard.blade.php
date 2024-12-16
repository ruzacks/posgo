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

                @include('sales.sale-transaction', ['locations' => $locations])

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

//ADD PRODUCT HANDLING
$("#name").autocomplete({
        minLength: 0, // Trigger even when no input is entered
        source: function(request, response) {
            $.getJSON("{{ route('search.product.json') }}", {
                search: request.term, // Send the input value as 'search'
                type: 'sale'
            }, response);
        },
        search: function() {
            var term = this.value;
            if (term.length == 0) {
                $("#product_id").val(''); // Clear product_id when input is empty
            }
            if (term.length < 2) {
                return false; // Don't search if input is less than 2 characters
            }
        },
        focus: function(event, ui) {
            $("#name").val(ui.item.label); // Focus does not select an item
            return false;
        },
        select: function(event, ui) {
            console.log(ui.item);
            addOrUpdateRow(ui.item);
            $("#name").val('');
            return false; // Prevent default action
        },
    }).autocomplete("instance")._renderItem = function(ul, item) {
        // Render the dropdown menu items
        return $("<li>")
            .append("<div>" + item.label + "<br>Stock: " + item.stock + ", Harga: " + item.purchase_price +
                "</div>")
            .appendTo(ul);
    };




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

        
    </script>
@endpush
