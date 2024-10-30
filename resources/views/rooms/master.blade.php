@extends('layouts.app')

@section('page-title', __('Rooms'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Rooms') }}</h5>
    </div>
@endsection

@section('action-btn')

    {{-- @can('Create Room')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Room') }}"
            title="{{ __(' New Room') }}" data-url="{{ route('rooms.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan --}}

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Room') }}</li>
@endsection

@section('content')
    @can('Manage Room')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        {{ Form::open(['url' => 'update-number-rooms', 'enctype' => 'multipart/form-data', 'method' => 'POST']) }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <a href="{{ route('rooms.detail', ['type' => 'hall']) }}" class="breadcrumb-item">
                                    {{ Form::label('Hall', __('Hall'), ['class' => 'col-form-label']) }}
                                </a>
                                {{ Form::number('hall', $numberOfRooms->hall ?? null, ['class' => 'form-control', 'placeholder' => __('Enter Hall Number'), 'step' => '1']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <a href="{{ route('rooms.detail', ['type' => 'room']) }}" class="breadcrumb-item">
                                    {{ Form::label('Room', __('Room'), ['class' => 'col-form-label']) }}
                                </a>
                                {{ Form::number('room', $numberOfRooms->room ?? null, ['class' => 'form-control', 'placeholder' => __('Enter Room Number'), 'step' => '1']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <a href="{{ route('rooms.detail', ['type' => 'vip']) }}" class="breadcrumb-item">
                                    {{ Form::label('VIP', __('VIP'), ['class' => 'col-form-label']) }}
                                </a>
                                {{ Form::number('vip', $numberOfRooms->vip ?? null, ['class' => 'form-control', 'placeholder' => __('Enter VIP Number'), 'step' => '1']) }}
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
