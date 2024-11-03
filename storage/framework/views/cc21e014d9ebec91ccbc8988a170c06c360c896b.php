<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Dashboard')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', __('Dashboard')); ?>


<?php $__env->startSection('header-content'); ?>
    <div class="row">
        



    <?php if($branches == 0 || $cashregisters == 0 || $productscount == 0 || $customers == 0 || $vendors == 0): ?>
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
                <?php if(isset($result) && !empty($result) && count($result) > 0): ?>
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-warning alert-dismissible fade show  mt-1" role="alert">
                            <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
                            <strong><?php echo e($alert); ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="row">

        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-hand-finger"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Sales Of This Month')); ?></p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0"><?php echo e($monthlySelledAmount); ?><span
                                            class="text-success text-sm"><i class=""></i> </span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-chart-pie"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total Sales Amount')); ?></p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0"><?php echo e($totalSelledAmount); ?><span
                                            class="text-danger text-sm"><i class=""></i></span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card" style="min-height: 225px;">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Purchase Of This Month')); ?></p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0"><?php echo e($monthlyPurchasedAmount); ?><span
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
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total Purchase Amount')); ?></p>
                                    <h6 class="mb-3"></h6>
                                    <h3 class="mb-0"><?php echo e($totalPurchasedAmount); ?><span
                                            class="text-danger text-sm"><i class=""></i> </span></h3>
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
                                            <th><?php echo e(__('Room Code')); ?></th>
                                            <th><?php echo e(__('Room Status')); ?></th>
                                            <th><?php echo e(__('Check In')); ?></th>
                                            <th><?php echo e(__('Check Out')); ?></th>
                                            <th><?php echo e(__('Elapsed')); ?></th>
                                            <th width="200px"><?php echo e(__('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                // Generate random check-in time within a specific range
                                                $randomCheckIn = \Carbon\Carbon::now()->subDays(rand(0, 5))->setTime(rand(0, 23), rand(0, 59));
                                                // Set check-out 2 hours after check-in
                                                $randomCheckOut = $randomCheckIn->copy()->addHours(2);
                                                // Determine color based on room status
                                                $statusColor = '';
                                                switch ($room->status) {
                                                    case 'occupied':
                                                        $checkInDisplay = $randomCheckIn->format('d M H:i');
                                                        $checkOutDisplay = $randomCheckOut->format('d M H:i');
                                                        $statusColor = 'text-success'; // Green for occupied
                                                        break;
                                                    case 'booked':
                                                        $checkInDisplay = $randomCheckIn->format('d M H:i');
                                                        $checkOutDisplay = ''; // No check-out time for booked
                                                        $statusColor = 'text-warning'; // Yellow for booked
                                                        break;
                                                    case 'available':
                                                        $checkInDisplay = '';
                                                        $checkOutDisplay = '';
                                                        $statusColor = 'text-info'; // Blue for available
                                                        break;
                                                    case 'maintenance':
                                                        $checkInDisplay = '';
                                                        $checkOutDisplay = '';
                                                        $statusColor = 'text-secondary'; // Gray for maintenance
                                                        break;
                                                    default:
                                                        $checkInDisplay = '';
                                                        $checkOutDisplay = '';
                                                        $statusColor = 'text-muted'; // Default for unknown status
                                                        break;
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($room->code); ?></td>
                                                <td class="<?php echo e($statusColor); ?>"><?php echo e($room->status); ?></td>
                                                <td><?php echo e($checkInDisplay); ?></td>
                                                <td><?php echo e($checkOutDisplay); ?></td>
                                                <td class="elapsed-time" data-start="<?php echo e($randomCheckIn); ?>">
                                                    00:00:00
                                                </td>
                                                <td class="Action">
                                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                                        <?php if($room->is_active == 1): ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Room')): ?>
                                                                <div class="action-btn btn-info">
                                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                        data-ajax-popup="true" title="<?php echo e(__('Edit Room')); ?>"
                                                                        data-title="<?php echo e(__('Edit Room')); ?>" data-size="lg"
                                                                        data-url="<?php echo e(route('rooms.edit', $room->id)); ?>"
                                                                        data-bs-toggle="tooltip" title="<?php echo e(__('Edit Room')); ?>">
                                                                        <i class="ti ti-pencil text-white"></i>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                    
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Room')): ?>
                                                                <div class="action-btn bg-danger">
                                                                    <a href="#"
                                                                        class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                        data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                        data-confirm-yes="delete-form-<?php echo e($room->id); ?>"
                                                                        title="<?php echo e(__('Delete')); ?>">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </a>
                                                                </div>
                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['rooms.destroy', $room->id], 'id' => 'delete-form-' . $room->id]); ?>

                                                                <?php echo Form::close(); ?>

                                                            <?php endif; ?>
                                    
                                                            <!-- Money Badge Button -->
                                                            <div class="action-btn bg-primary">
                                                                <a href="#"
                                                                    class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                    data-bs-toggle="tooltip"
                                                                    title="<?php echo e(__('Charge')); ?>">
                                                                    <i class="ti ti-credit-card text-white"></i>
                                                                </a>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="#" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-lock"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(count($lowstockproducts) > 0): ?>
                <div class="col-md-3">
                    <?php $__currentLoopData = $lowstockproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
                            <strong><?php echo e($product['name']); ?></strong><small> <?php echo e($product['quantity'] . __(' items left)')); ?></small>
                            
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

                <?php if(isset($saletarget) && !empty($saletarget) && count($saletarget) > 0): ?>

                    <?php $__currentLoopData = $saletarget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-5">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Branches Target')); ?> (<small><?php echo e(__('This Month')); ?></small>)</h5>
                                    <div class="row align-items-center">
                                        <div class="col">
                                        </div>

                                    </div>
                                </div>
                                <div class="">
                                    <table class="table align-items-center mb-0 ">
                                        <thead class="thead-light">
                                            <tr class="border-top-0">
                                                <th class="w-25"><?php echo e(__('Branch Name')); ?></th>
                                                <th class="w-25"><?php echo e(__('Target')); ?></th>
                                                <th class="w-25"><?php echo e(__('Sales')); ?></th>
                                                <th class="w-25"><?php echo e(__('Progress')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <?php if(isset($target['branch']) && count($target['branch']) > 0): ?>
                                                <?php for($i = 0; $i < count($target['branch']); $i++): ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <span
                                                                        class="name mb-0 text-sm"><?php echo e($target['branch'][$i]); ?></span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="budget">
                                                            <?php echo e($target['totaltarget'][$i]); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($target['totalselledprice'][$i]); ?>

                                                        </td>
                                                        <td class="circular-progressbar p-0">
                                                            <?php
                                                            $percentage = $target['percentage'][$i];
                                                            
                                                            $status = $percentage > 0 && $percentage <= 25 ? 'red' : ($percentage > 25 && $percentage <= 50 ? 'orange' : ($percentage > 50 && $percentage <= 75 ? 'blue' : ($percentage > 75 && $percentage <= 100 ? 'green' : '')));
                                                            ?>
                                                            <div class="flex-wrapper">
                                                                <div class="single-chart">
                                                                    <svg viewBox="0 0 36 36"
                                                                        class="circular-chart <?php echo e($status); ?>">
                                                                        <path class="circle-bg"
                                                                            d="M18 2.0845
                                                                                                      a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                      a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <path class="circle"
                                                                            stroke-dasharray="<?php echo e($percentage); ?>, 100"
                                                                            d="M18 2.0845
                                                                                                      a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                      a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                                        <text x="18" y="20.35"
                                                                            class="percentage"><?php echo e($percentage); ?>%</text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <?php endif; ?>

            </div>
        </div>





    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>

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
                        name: '<?php echo e(__('Purchase')); ?>',
                        data: <?php echo json_encode($purchasesArray['value']); ?>

                        // data: [200,300,400,500,600,700,800,500,400,600,500,700,700,300,500]

                    },
                    {
                        name: '<?php echo e(__('Sales')); ?>',
                        data: <?php echo json_encode($salesArray['value']); ?>

                        // data: [300,400,450,500,600,700,600,400,450,500,600,700,750,550,600]

                    },
                ],
                xaxis: {
                    categories: <?php echo json_encode($purchasesArray['label']); ?>,
                    title: {
                        text: '<?php echo e(__('Days')); ?>'
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
                        text: '<?php echo e(__('Amount')); ?>'
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
                    show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error')
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>


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
                    timeGridDay: "<?php echo e(__('Day')); ?>",
                    timeGridWeek: "<?php echo e(__('Week')); ?>",
                    dayGridMonth: "<?php echo e(__('Month')); ?>"
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
                events: <?php echo $arrEvents; ?>,



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
        // Ticking Elapsed Time Counter
        function updateElapsedTime() {
            document.querySelectorAll('.elapsed-time').forEach(function(element) {
                const startTime = new Date(element.getAttribute('data-start')).getTime();
                const now = new Date().getTime();
                const elapsed = new Date(now - startTime);

                const hours = String(elapsed.getUTCHours()).padStart(2, '0');
                const minutes = String(elapsed.getUTCMinutes()).padStart(2, '0');
                const seconds = String(elapsed.getUTCSeconds()).padStart(2, '0');

                element.textContent = `${hours}:${minutes}:${seconds}`;
            });
        }

        setInterval(updateElapsedTime, 1000);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8\htdocs\posgo\resources\views/dashboard.blade.php ENDPATH**/ ?>