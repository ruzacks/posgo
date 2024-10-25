@extends('layouts.app')

@section('page-title', __('Talents'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Talents') }}</h5>
    </div>
@endsection

@section('action-btn')

    <a href="{{ route('talent.export') }}" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip"
        title="{{ __('Export') }}">
        <i class="ti ti-file-export text-white"></i>
    </a>

    <a href="#" class="btn btn-sm btn-primary btn-icon" data-url="{{ route('talent.file.import') }}"
        data-bs-toggle="tooltip" data-bs-toggle="tooltip" title="{{ __('Import') }}" data-ajax-popup="true"
        data-title="{{ __('Import talent CSV file') }}">
        <i class="ti ti-file-import text-white"></i>
    </a>

    @can('Create Talent')
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-title="{{ __('Add New Talent') }}"
            title="{{ __(' New Talent') }}" data-url="{{ route('talents.create') }}"
            class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Talent') }}</li>
@endsection

@section('content')
    @can('Manage Talent')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Date/Time Added') }} </th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($talents as $key => $talent)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $talent->name }}</td>
                                            <td>{{ $talent->phone_number }}</td>
                                            <td>{{ Auth::user()->datetimeFormat($talent->created_at) }}</td>
                                            <td class="Action">
                                                @if ($talent->is_active == 1)
                                                    @can('Edit Talent')
                                                        <div class="action-btn btn-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-ajax-popup="true" title="{{ __('Edit Talent') }}"
                                                                data-title="{{ __('Edit Talent') }}" data-size="lg"
                                                                data-url="{{ route('talents.edit', $talent->id) }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit Talent') }}">
                                                                <i class="ti ti-pencil text-white"></i>

                                                            </a>
                                                        </div>
                                                    @endcan
                
                                                    @can('Delete Talent')
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $talent->id }}"
                                                                title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['talents.destroy', $talent->id], 'id' => 'delete-form-' . $talent->id]) !!}
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
