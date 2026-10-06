@extends('agent.layout')



@includeIf('backend.partials.rtl_style')



@section('content')





<div class="page-header">

        <h4 class="page-title">{{ __('Jobs') }}</h4>

        <ul class="breadcrumbs">

            <li class="nav-home">

                <a href="{{ route('admin.dashboard') }}">

                    <i class="flaticon-home"></i>

                </a>

            </li>

            <li class="separator">

                <i class="flaticon-right-arrow"></i>

            </li>

            <li class="nav-item">

                <a href="#">{{ __('Job Management') }}</a>

            </li>

            <li class="separator">

                <i class="flaticon-right-arrow"></i>

            </li>

            <li class="nav-item">

                <a href="#">{{ __('Jobs') }}</a>

            </li>

        </ul>

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="row">

                        <div class="col-lg-3">

                            <div class="card-title d-inline-block">{{ __('Jobs') }}</div>

                        </div>



                        <div class="col-lg-3">

                            <form action="{{ route('agent.job_management.jobs') }}" method="get"

                                id="carSearchForm">

                                <div class="row">



                                    <div class="col-lg-12">

                                        <div class="form-group">

                                            <input type="text" name="title" value="{{ request()->input('title') }}"

                                                class="form-control" placeholder="Title">

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                        <div class="col-lg-3">

                            <div class="form-group">

                                @includeIf('agent.partials.languages')

                            </div>

                        </div>

                        <div class="col-lg-3 mt-2 mt-lg-0">

                            <a href="{{ route('agent.job_management.create_job') }}"

                                class="btn btn-primary btn-sm float-lg-right"><i class="fas fa-plus"></i>

                                {{ __('Add Job') }}</a>



                            <button class="btn btn-danger btn-sm float-lg-right mr-2 d-none bulk-delete"

                                data-href="{{ route('agent.job_management.bulk_delete_job') }}"><i

                                    class="flaticon-interface-5"></i>

                                {{ __('Delete') }}</button>

                        </div>

                    </div>

                </div>



                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-12">

                            @if (count($jobs) == 0)

                                <h3 class="text-center">{{ __('NO JOB FOUND!') }}</h3>

                            @else

                                <div class="table-responsive">

                                    <table class="table table-striped mt-3">

                                        <thead>

                                            <tr>

                                                <th scope="col">

                                                    <input type="checkbox" class="bulk-check" data-val="all">

                                                </th>

                                                <th scope="col">{{ __('Job ID') }}</th>

                                                <th scope="col">{{ __('Title') }}</th>

                                                <th scope="col">{{ __('Property') }}</th>

                                                <th scope="col">{{ __('Amount') }}</th>

                                                <th scope="col">{{ __('Location') }}</th>

                                                <th scope="col">{{ __('Status') }}</th>

                                                <th scope="col">{{ __('Actions') }}</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($jobs as $job)

                                                <tr>

                                                    <td>

                                                        <input type="checkbox" class="bulk-check"

                                                            data-val="{{ $job->id }}">

                                                    </td>

                                                    <td>

                                                        {{ $job->job_id }}

                                                       

                                                    </td>

                                                    <td>

                                                        {{ $job->title }}

                                                       

                                                    </td>

                                                    

                                                    <td>

                                                        @php
    $property_content = null;

    if ($job->property) {
        $property_content = $job->property->propertyContents()->first();
    }
@endphp

{{ $property_content->title ?? '' }}

                                                    </td>

                                                    <td>

                                                        ${{ $job->salary }}

                                                    </td>

                                                    <td>

                                                        {{ $job->location }}

                                                    </td>

                                                   

                                                    <td>

                                                        <form id="statusForm{{ $job->id }}" class="d-inline-block"

                                                            action="{{ route('agent.job_management.update_status') }}"

                                                            method="post">

                                                            @csrf

                                                            <input type="hidden" name="jobId"

                                                                value="{{ $job->id }}">



                                                            <select

                                                                class="form-control {{ $job->status == "open" ? 'bg-success' : 'bg-danger' }} form-control-sm"

                                                                name="status"

                                                                onchange="document.getElementById('statusForm{{ $job->id }}').submit();">

                                                                <option value="open"

                                                                        {{ $job->status == "open" ? 'selected' : '' }}>

                                                                    {{ __('Open') }}

                                                                </option>

                                                                    <option value="closed"

                                                                        {{ $job->status == "closed" ? 'selected' : '' }}>

                                                                    {{ __('Closed') }}

                                                                </option>

                                                            </select>

                                                        </form>

                                                    </td>



                                                    <td>

                                                        <div class="dropdown">

                                                            <button class="btn btn-secondary dropdown-toggle btn-sm"

                                                                type="button" id="dropdownMenuButton"

                                                                data-toggle="dropdown" aria-haspopup="true"

                                                                aria-expanded="false">

                                                                {{ __('Select') }}

                                                            </button>



                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">



                                                                <a class="dropdown-item"

                                                                    href="{{ route('agent.job_management.edit_job', $job->id) }}">

                                                                    <span class="btn-label">

                                                                        <i class="fas fa-edit"></i> {{ __('Edit') }}

                                                                    </span>

                                                                </a>

                                                                <a class="dropdown-item"

                                                                    href="{{ route('agent.job_management.job_request', $job->id) }}">

                                                                    <span class="btn-label">

                                                                        <i class="fas fa-list"></i> {{ __('Job Request') }}

                                                                    </span>

                                                                </a>



                                                                <form class="deleteForm d-inline-block dropdown-item"

                                                                    action="{{ route('agent.job_management.destroy_job', $job->id) }}"

                                                                    method="post">

                                                                    @csrf

                                                                    <input type="hidden" name="job_id"

                                                                        value="{{ $job->id }}">



                                                                    <button type="submit" class="p-0 deleteBtn">

                                                                        <span class="btn-label">

                                                                            <i class="fas fa-trash-alt"></i>

                                                                            {{ __('Delete') }}

                                                                        </span>

                                                                    </button>

                                                                </form>

                                                            </div>

                                                        </div>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>



                <div class="card-footer">

                    {{ $jobs->appends([

                            'agent_id' => request()->input('agent_id'),

                            'title' => request()->input('title'),

                        ])->links() }}

                </div>



            </div>

        </div>

    </div>









@endsection