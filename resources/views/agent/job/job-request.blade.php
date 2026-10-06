@extends('agent.layout')

@includeIf('backend.partials.rtl_style')

@section('content')


<div class="page-header">
        <h4 class="page-title">{{ __('Jobs Requests') }}</h4>
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
                <a href="#">{{ __('Jobs Request') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card-title d-inline-block">{{ __('Jobs Request') }}</div>
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
                        
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($jobApplications) == 0)
                                <h3 class="text-center">{{ __('NO JOB FOUND!') }}</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col">{{ __('Cover Letter') }}</th>
                                                <th scope="col">{{ __('Experience') }}</th>
                                                <!--<th scope="col">{{ __('Expected Amount') }}</th>-->
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Applied At') }}</th>
                                                <th scope="col">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jobApplications as $jobApplication)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $jobApplication->id }}">
                                                    </td>
                                                    <td class="table-title">
                                                        {{ $jobApplication->cover_letter }}
                                                       
                                                    </td>
                                                    
                                                    <td>
                                                        @if($jobApplication->experience == 1)
                                                        Yes
                                                        @else
                                                        No
                                                        @endif
                                                   
                                                    </td>
                                                    <!--<td>-->
                                                    <!--    {{ $jobApplication->expected_salary }}-->
                                                    <!--</td>-->
                                                    <td>
                                                        {{ $jobApplication->applied_at }}
                                                    </td>
                                                   
                                                    <td>
                                                        <form id="statusForm{{ $jobApplication->id }}" class="d-inline-block"
                                                            action="{{ route('agent.job_management.update_application_status') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="jobId"
                                                                value="{{ $jobApplication->id }}">

                                                            <select
                                                            class="form-control form-control-sm
                                                                {{ $jobApplication->status == 'applied' ? 'bg-info text-white' : '' }}
                                                                {{ $jobApplication->status == 'shortlisted' ? 'bg-warning text-dark' : '' }}
                                                                {{ $jobApplication->status == 'hired' ? 'bg-success text-white' : '' }}
                                                                {{ $jobApplication->status == 'rejected' ? 'bg-danger text-white' : '' }}"
                                                                name="status"
                                                                onchange="document.getElementById('statusForm{{ $jobApplication->id }}').submit();" >
                                                                <option value="applied"
                                                                        {{ $jobApplication->status == "applied" ? 'selected' : '' }}>
                                                                    {{ __('Applied') }}
                                                                </option>
                                                                    <option value="shortlisted"
                                                                        {{ $jobApplication->status == "shortlisted" ? 'selected' : '' }}>
                                                                    {{ __('Shortlisted') }}
                                                                </option>
                                                                </option>
                                                                    <option value="hired"
                                                                        {{ $jobApplication->status == "hired" ? 'selected' : '' }}>
                                                                    {{ __('Hired') }}
                                                                </option>
                                                                </option>
                                                                    <option value="rejected"
                                                                        {{ $jobApplication->status == "rejected" ? 'selected' : '' }}>
                                                                    {{ __('Rejected') }}
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
                                                                    href="{{ route('agent.job_application.user_profile', $jobApplication->id) }}">
                                                                    <span class="btn-label">
                                                                        <i class="fas fa-user"></i> {{ __('Profile') }}
                                                                    </span>
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('agent.job_management.pay', $jobApplication->id) }}">
                                                                    <span class="btn-label">
                                                                        <i class="fas fa-credit-card"></i> {{ __('Pay') }}
                                                                    </span>
                                                                </a>
                                                               
                                                               {{-- <form class="deleteForm d-inline-block dropdown-item"
                                                                    action="{{ route('agent.job_management.destroy_job', $jobApplication->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="job_id"
                                                                        value="{{ $jobApplication->id }}">

                                                                    <button type="submit" class="p-0 deleteBtn">
                                                                        <span class="btn-label">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                            {{ __('Delete') }}
                                                                        </span>
                                                                    </button>
                                                                </form> --}}
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
                    {{ $jobApplications->appends([
                            'agent_id' => request()->input('agent_id'),
                            'title' => request()->input('title'),
                        ])->links() }}
                </div>

            </div>
        </div>
    </div>




@endsection