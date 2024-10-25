@extends('layouts.app')

@section('page-title', __('Rooms'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Rooms') }}</h5>
    </div>
@endsection

@section('action-btn')

    @can('Create Room')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Room') }}"
            title="{{ __(' New Room') }}" data-url="{{ route('rooms.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan

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

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Room Code') }}</th>
                                        <th>{{ __('Room Type') }}</th>
                                        <th>{{ __('Room Price') }}</th>
                                        <th>{{ __('Date/Time Added') }} </th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $key => $room)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $room->room_code }}</td>
                                            <td>{{ $room->room_type }}</td>
                                            <td>{{ $room->price }}</td>
                                            <td>{{ Auth::user()->datetimeFormat($room->created_at) }}</td>
                                            <td class="Action">
                                                @if ($room->is_active == 1)
                                                    @can('Edit Room')
                                                        <div class="action-btn btn-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-ajax-popup="true" title="{{ __('Edit Room') }}"
                                                                data-title="{{ __('Edit Room') }}" data-size="lg"
                                                                data-url="{{ route('rooms.edit', $room->id) }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit Room') }}">
                                                                <i class="ti ti-pencil text-white"></i>

                                                            </a>
                                                        </div>
                                                    @endcan
                
                                                    @can('Delete Room')
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $room->id }}"
                                                                title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['rooms.destroy', $room->id], 'id' => 'delete-form-' . $room->id]) !!}
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
