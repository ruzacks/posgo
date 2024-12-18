@extends('layouts.app')

@section('page-title', __('Report Stock'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Report Stock') }}</h5>
    </div>
@endsection

@section('action-btn')
    {{-- <a class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="collapse" data-bs-toggle="tooltip"
        title="{{ __('Filter') }}" data-title="{{ __('Filter') }}" data-bs-target=".multi-collapse">
        <i class="ti ti-filter text-white"></i>
    </a> --}}
@endsection

@push('old-datatable-css')
    <link rel="stylesheet" href="{{ asset('custom/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/customdatatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Reports Stock') }}</li>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script>
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            onChange: function(selectedDates, dateStr, instance) {
                var dates = dateStr.split(" to ");
                var start = moment(dates[0]).format('YYYY-MM-DD');
                var end = moment(dates[1]).format('YYYY-MM-DD');
                $('#start_date1').val(start);
                $('#end_date1').val(end);
               
            }
        });
    </script>
@endpush

@can('Manage Expense')

    @section('content')
    <form action="{{ route('import.report.stock') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="row input-daterange analysis-datepicker align-items-center">
                            <div class="form-group col-md-4 mb-0">
                                {{ Form::label('duration1', __('Date Duration'), ['class' => 'col-form-label']) }}
                                <div class="input-group" style="width: 1052px;">
                                    {{-- {{ Form::text('duration', __('Select Date Range'), ['class' => 'form-control','id' => 'duration1','placeholder' => __('Select Date Range')]) }}
                                    {{ Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start-date']) }}
                                    {{ Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end-date']) }} --}}


                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type='text' class="form-control" id="pc-daterangepicker-1"
                                            placeholder="Select time" type="text" />
                                        {{ Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1']) }}
                                        {{ Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1']) }}
                                    </div>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4  mb-0">
                <button type="submit" class="btn btn-primary">IMPORT</button>
            </div>
        </div>
    </form>
    @endsection

    @push('scripts')
        <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
        <script type="text/javascript">
            function ajax_product_expense_analysis_filter() {

                var data = {
                    'start_date': $('#start-date').val(),
                    'end_date': $('#end-date').val(),
                    'expense_category_id': $('#expense_category_id').val(),
                    'branch_id': $('#branch_id').val(),
                }

                $('#expense-analysis-datatable .expense-analysis-datatable').DataTable({
                        "destroy": true,
                        "paging": true,
                        "ordering": false,
                        "processing": true,
                        "pageLength": 10,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": '{{ route('expense.analysis.filter') }}',
                            "data": data,
                        },
                        "columns": [{
                                "data": "date"
                            },
                            {
                                "data": "expense_category"
                            },
                            {
                                "data": "note"
                            },
                            {
                                "data": "created_by"
                            },
                            {
                                "data": "amount"
                            },
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalexpenseamount').html(json.totalExpenseAmount);
                    });
            }

            // $(function() {
            //     function cb(start, end) {
            //         $("#duration1").val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            //         $('input[name="start_date1"]').val(start.format('YYYY-MM-DD'));
            //         $('input[name="due_date1"]').val(end.format('YYYY-MM-DD'));
            //         ajax_product_expense_analysis_filter();
            //     }

            //     $('#duration1').daterangepicker({
            //         // timePicker: true,
            //         autoApply: true,
            //         autoclose: true,
            //         autoUpdateInput: false,
            //         // startDate: start,
            //         // endDate: end,
            //         locale: {
            //             format: 'MMM D, YY hh:mm A',
            //             applyLabel: "Apply",
            //             cancelLabel: "Cancel",
            //             fromLabel: "From",
            //             toLabel: "To",
            //             daysOfWeek: [
            //                 '{{ __('Sun') }}',
            //                 '{{ __('Mon') }}',
            //                 '{{ __('Tue') }}',
            //                 '{{ __('Wed') }}',
            //                 '{{ __('Thu') }}',
            //                 '{{ __('Fri') }}',
            //                 '{{ __('Sat') }}',
            //             ],
            //             monthNames: [
            //                 '{{ __('January') }}',
            //                 '{{ __('February') }}',
            //                 '{{ __('March') }}',
            //                 '{{ __('April') }}',
            //                 '{{ __('May') }}',
            //                 '{{ __('June') }}',
            //                 '{{ __('July') }}',
            //                 '{{ __('August') }}',
            //                 '{{ __('September') }}',
            //                 '{{ __('October') }}',
            //                 '{{ __('November') }}',
            //                 '{{ __('December') }}'
            //             ],
            //         }
            //     }, cb);
            // });


            $(document).ready(function() {
                ajax_product_expense_analysis_filter();
                $(document).on('change', '#expense_category_id', function(e) {
                    ajax_product_expense_analysis_filter();
                });
            });

            $(document).on('change', '#branch_id', function(e) {

                ajax_product_expense_analysis_filter();
            });
        </script>
    @endpush
@endcan


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
