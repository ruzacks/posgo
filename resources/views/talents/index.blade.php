@extends('layouts.app')

@section('page-title', __('Talents'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Talents') }}</h5>
    </div>
@endsection

@section('action-btn')

    @can('Manage Agency')
        <a href="{{ route('agencies.index') }}" data-bs-toggle="tooltip"
            class="btn btn-sm btn-primary btn-icon m-1">
            {{ __('Agencies') }}</a>
        </a>
    @endcan

    @can('Manage Talent Grade')
        <a href="{{ route('talent-grades.index') }}" data-bs-toggle="tooltip"
            class="btn btn-sm btn-primary btn-icon m-1">
            {{ __('Talent Grade') }}</a>
        </a>
    @endcan

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
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th style="text-align: center">{{ __('Grade') }} </th>
                                        <th style="text-align: center">{{ __('Agency') }} </th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($talents as $key => $talent)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $talent->code }}</td>
                                            <td>{{ $talent->name }}</td>
                                            <td>{{ $talent->status }}</td>
                                            <td>{{ $talent->phone_number }}</td>
                                            <td style="text-align: center">{{ $talent->talentGrade() }}</td>
                                            <td style="text-align: center">{{ $talent->talentAgency() }}</td>
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
