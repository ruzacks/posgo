@extends('layouts.app')

@section('page-title', __('Agencies'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Agencies') }}</h5>
    </div>
@endsection

@section('action-btn')

    @can('Create Agency')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Agency') }}"
            title="{{ __('New Agency') }}" data-url="{{ route('agencies.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('talents.index') }}">{{ __('Talent') }}</a></li>
    <li class="breadcrumb-item">{{ __('Agency') }}</li>
@endsection

@section('content')
    @can('Manage Agency')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th style="text-align: center">{{ __('Jumlah Talent') }}</th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agencies as $key => $agency)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $agency->code }}</td>
                                            <td>{{ $agency->name }}</td>
                                            <td>{{ $agency->phone_number }}</td>
                                            <td style="text-align: center">{{ $agency->numOfTalent() }}</td>
                                            <td class="Action">
                                                @if ($agency->is_active == 1)
                                                    @can('Edit Agency')
                                                        <div class="action-btn btn-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-ajax-popup="true" title="{{ __('Edit Agency') }}"
                                                                data-title="{{ __('Edit Agency') }}" data-size="lg"
                                                                data-url="{{ route('agencies.edit', $agency->id) }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit Agency') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('Delete Agency')
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action cannot be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $agency->id }}"
                                                                title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['agencies.destroy', $agency->id], 'id' => 'delete-form-' . $agency->id]) !!}
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
