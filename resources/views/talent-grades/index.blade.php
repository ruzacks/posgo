@extends('layouts.app')

@section('page-title', __('Talent Grades List'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Talent Grades List') }}</h5>
    </div>
@endsection

@section('action-btn')
    @can('Create Talent Grade')
        <a href="#" data-ajax-popup="true" data-size="md"
            data-title="{{ __('Add New Talent Grade') }}" title="{{ __('Add Talent Grade') }}" data-bs-toggle="tooltip" data-url="{{ route('talent-grades.create') }}"
            class="btn btn-sm btn-primary btn-icon">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Talent Grades') }}</li>
@endsection

@section('content')
    @can('Manage Talent Grade')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Talent Grade Name') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th width="200px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($talentGrades as $key => $grade)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $grade->name }}</td>
                                            <td>{{ $grade->price ? $grade->price : __('N/A') }}</td>
                                            <td class="Action">
                                                @can('Edit Talent Grade')
                                                    <div class="action-btn btn-info ms-2">
                                                        <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Edit Talent Grade') }}" title="{{ __('Edit Talent Grade') }}"
                                                            data-size="md" data-url="{{ route('talent-grades.edit', $grade->id) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                            <i class="ti ti-pencil text-white" title="{{ __('Edit') }}"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('Delete Talent Grade')
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="sweet-alert"
                                                            data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action cannot be undone. Do you want to continue?') }}" data-bs-toggle="tooltip"
                                                            data-confirm-yes="delete-form-{{ $grade->id }}" title="{{ __('Delete') }}">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['talent-grades.destroy', $grade->id], 'id' => 'delete-form-' . $grade->id]) !!}
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
