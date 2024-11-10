@extends('layouts.app')

@section('page-title', __('Location List') )

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Location List')}}</h5>
    </div>
@endsection

@section('action-btn')
    @can('Create Location Type')
        <a href="#" data-ajax-popup="true" data-size="md"
            data-title="{{__('Add New Location Type')}}" title="{{__('Add Location Type')}}" data-bs-toggle="tooltip" data-url="{{route('location-types.create')}}"
            class="btn btn-sm btn-primary btn-icon ">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan
@endsection

@section('breadcrumb')
         <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item">{{ __('Location') }}</li>
@endsection

@section('content')
    @can('Manage Location Type')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                     <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Location Name') }}</th>
                                    <th>{{ __('Number of Location') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($location_types as $key => $location_type)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $location_type->name }}</td>
                                        <td>{{ $location_type->location_count }}</td>
                                        <td>{{ $location_type->getTotalLocation('available') }} {{ __('Available') }}</td>
                                        <td><a href="#" data-ajax-popup="true" data-size="lg"
                                            data-title="{{$location_type->name .__(' Location Price')}}" title="{{__('View Price')}}" data-bs-toggle="tooltip" data-url="{{route('location-prices.index',$location_type->id)}}" class="btn btn-primary">{{ __('PRICE') }}</a></td>
                                        <td class="Action">
                                            @can('Manage Location')
                                            <div class="action-btn btn-info ms-2">
                                                <a href="{{ route('locations.detail', ['locationType' => $location_type->id]) }}" data-bs-toggle="tooltip" 
                                                    
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                    <i class="ti ti-search text-white" title="{{ __('Edit') }}"></i>
                                                </a>
                                            </div>
                                            @endcan
                                            @can('Edit Location')
                                            <div class="action-btn btn-info ms-2">
                                                <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{__('Edit Location Type')}}" title="{{__('Edit Location Type')}}"
                                                    data-size="md" data-url="{{route('location-types.edit', $location_type->id)}}"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                    <i class="ti ti-pencil text-white" title="{{ __('Edit') }}"></i>
                                                </a>
                                            </div>
                                            @endcan
                                            @can('Delete Location')
                                            <div class="action-btn bg-danger ms-2">
                                                <a href="#" class=" bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="sweet-alert"
                                                    data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}" data-bs-toggle="tooltip"
                                                    data-confirm-yes="delete-form-{{$location_type->id}}" title="{{ __('Delete') }}">
                                                    <i class="ti ti-trash text-white"></i>
                                                </a>
                                            </div>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['location-types.destroy', $location_type->id],'id' => 'delete-form-'.$location_type->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
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
