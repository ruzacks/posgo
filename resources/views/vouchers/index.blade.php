@extends('layouts.app')

@section('page-title', __('Vouchers'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Vouchers') }}</h5>
    </div>
@endsection

@section('action-btn')

    @can('Create Voucher')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Voucher') }}"
            title="{{ __(' New Voucher') }}" data-url="{{ route('vouchers.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Voucher') }}</li>
@endsection

@section('content')
    @can('Manage Voucher')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Voucher Code') }}</th>
                                        <th>{{ __('Discount Type') }}</th>
                                        <th>{{ __('Discount Value') }}</th>
                                        <th>{{ __('Date/Time Added') }}</th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $key => $voucher)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $voucher->voucher_code }}</td>
                                            <td>{{ ucfirst($voucher->discount_type) }}</td>
                                            <td>
                                                @if ($voucher->discount_type == 'fixed')
                                                    {{ __('$') . $voucher->discount_value }}
                                                @else
                                                    {{ $voucher->discount_value . __('%') }}
                                                @endif
                                            </td>
                                            <td>{{ Auth::user()->datetimeFormat($voucher->created_at) }}</td>
                                            <td class="Action">
                                                @if ($voucher->is_active == 1)
                                                    @can('Edit Voucher')
                                                        <div class="action-btn btn-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-ajax-popup="true" title="{{ __('Edit Voucher') }}"
                                                                data-title="{{ __('Edit Voucher') }}" data-size="lg"
                                                                data-url="{{ route('vouchers.edit', $voucher->id) }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit Voucher') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('Delete Voucher')
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $voucher->id }}"
                                                                title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['vouchers.destroy', $voucher->id], 'id' => 'delete-form-' . $voucher->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @else
                                                    <a href="#" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-lock"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
