@extends('layouts.app')

@section('page-title', __('Locations'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Locations') . ' '. $locationType->name }}</h5>
    </div>
@endsection

@section('action-btn')

    @can('Create Location')
        <a href="{{ route('locations.type.create', ['type' => $locationType->id]) }}" data-ajax-popup="false" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Location') }}"
            title="{{ __(' New Location') }}" data-url="{{ route('locations.type.create', ['type' => $locationType->id]) }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('location-types.index') }}">{{ __('Location') }}</a></li>
    <li class="breadcrumb-item">{{ ucfirst($locationType->name) }}</li>

@endsection

@section('content')
    @can('Manage Location')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Location Code') }}</th>
                                        <th>{{ __('Location Status') }}</th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $key => $location)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $location->code }}</td>
                                            <td>{{ $location->status }}</td>
                                            <td class="Action">
                                                @if ($location->is_active == 1)
                                                    @can('Edit Location')
                                                        <div class="action-btn btn-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-ajax-popup="true" title="{{ __('Edit Location') }}"
                                                                data-title="{{ __('Edit Location') }}" data-size="lg"
                                                                data-url="{{ route('locations.edit', $location->id) }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit Location') }}">
                                                                <i class="ti ti-pencil text-white"></i>

                                                            </a>
                                                        </div>
                                                    @endcan
                
                                                    @can('Delete Location')
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $location->id }}"
                                                                title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['locations.destroy', $location->id], 'id' => 'delete-form-' . $location->id]) !!}
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
