@extends('layouts.app')

@section('page-title', __('Locations'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Locations') }}</h5>
    </div>
@endsection

@section('action-btn')

    {{-- @can('Create Location')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Location') }}"
            title="{{ __(' New Location') }}" data-url="{{ route('locations.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan --}}

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Location') }}</li>
@endsection

@section('content')
    @can('Manage Location')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        {{ Form::open(['url' => 'update-number-locations', 'enctype' => 'multipart/form-data', 'method' => 'POST']) }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <a href="{{ route('locations.detail', ['type' => 'hall']) }}" class="badge bg-primary text-white d-inline-flex align-items-center">
                                    <i class="ti ti-search me-1"></i> {{ __('Hall') }}
                                </a>
                                {{ Form::number('hall', $numberOfLocations->hall ?? null, ['class' => 'form-control mt-2', 'placeholder' => __('Enter Hall Number'), 'step' => '1']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <a href="{{ route('locations.detail', ['type' => 'location']) }}" class="badge bg-primary text-white d-inline-flex align-items-center">
                                    <i class="ti ti-search me-1"></i> {{ __('Location') }}
                                </a>
                                {{ Form::number('location', $numberOfLocations->location ?? null, ['class' => 'form-control mt-2', 'placeholder' => __('Enter Location Number'), 'step' => '1']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <a href="{{ route('locations.detail', ['type' => 'vip']) }}" class="badge bg-primary text-white d-inline-flex align-items-center">
                                    <i class="ti ti-search me-1"></i> {{ __('VIP') }}
                                </a>
                                {{ Form::number('vip', $numberOfLocations->vip ?? null, ['class' => 'form-control mt-2', 'placeholder' => __('Enter VIP Number'), 'step' => '1']) }}
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-1">
                                <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
                            </div>
                        </div>
                        {{ Form::close() }}                        
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
