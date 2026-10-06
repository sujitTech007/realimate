@php

$version = $basicInfo->theme_version;

@endphp

@extends("frontend.layouts.layout-v$version")



@section('pageHeading')

{{ !empty($pageHeading) ? $pageHeading->contact_page_title : __('Jobs') }}

@endsection



@section('metaKeywords')

@if (!empty($seoInfo))

{{ $seoInfo->meta_keyword_jobs }}

@endif

@endsection



@section('metaDescription')

@if (!empty($seoInfo))

{{ $seoInfo->meta_description_jobs }}

@endif

@endsection



<style>
    .team-section {

        text-align: center;

        padding: 60px 20px;

        background-color: #fff;

    }



    .job-section {

        border: 1px solid #eee !important;

        border-radius: 12px !important;

        transition: all 0.3s ease-in-out !important;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;

        overflow: hidden !important;

    }



    .job-section:hover {

        transform: translateY(-6px) !important;

        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;

    }





    .modal-content {

        border-radius: 16px;

        border: none;

        overflow: hidden;

        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);

        animation: fadeInUp 0.4s ease;

    }



    /* Header */

    .modal-header {

        border-bottom: none;

        padding: 1rem 1.5rem;

    }



    .modal-header h5 {

        font-size: 1.25rem;

        font-weight: 600;

    }



    /* Body */

    .modal-body {

        background-color: #f9f9f9;

        padding: 2rem;

    }



    .modal-body .form-label {

        font-weight: 600;

        color: #333;

    }



    .modal-body .form-control,

    .modal-body .form-select {

        border-radius: 10px;

        border: 1px solid #ddd;

        padding: 0.75rem;

        transition: all 0.2s ease;

    }



    .modal-body .form-control:focus,

    .modal-body .form-select:focus {

        border-color: #0d6efd;

        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);

    }



    /* Footer */

    .modal-footer {

        background: #fff;

        padding: 1rem 1.5rem;

        border-top: 1px solid #eee;

    }



    .modal-footer .btn {

        border-radius: 8px;

        padding: 0.5rem 1.25rem;

        font-weight: 500;

        transition: transform 0.2s ease;

    }



    .modal-footer .btn:hover {

        transform: translateY(-2px);

    }

    .btn-success {

        background-color: #28a745 !important;

        border-color: #28a745 !important;

        color: #fff !important;

    }

    .btn-success:hover {

        background-color: #218838 !important;

        border-color: #1e7e34 !important;

    }



    .btn-secondary {

        background-color: #6c757d !important;

        border-color: #6c757d !important;

        color: #fff !important;

    }

    .btn-secondary:hover {

        background-color: #6C7570 !important;

        border-color: #6C7570 !important;

    }



    /* Animation */

    @keyframes fadeInUp {

        from {

            opacity: 0;

            transform: translateY(30px);

        }

        to {

            opacity: 1;

            transform: translateY(0);

        }

    }
</style>





@section('content')

@includeIf('frontend.partials.breadcrumb', [

'breadcrumb' => $bgImg->breadcrumb,

'title' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Jobs'),

'subtitle' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Jobs'),

])



<!--====================================================-->

<!--============== Start Contact Section ===============-->

<!--====================================================-->





<section id="team" class="team-section">

    <!--<h1 class="section-heading">Our Team</h1>-->

    <!--<p class="section-subtitle"><b>Meet the Leaders Who Shape Our Success</b></p>-->



    <div class="container">

        <!-- <h2 class="mb-4">Available Jobs</h2> -->


        <div class="row">

            @foreach($jobs as $job)

            <div class="col-md-4 mb-4">

                <div class="card h-100 job-section">

                    <!-- Job Image -->

                    <img src="{{ !empty($job->property->featured_image)
        ? asset('assets/img/property/featureds/' . $job->property->featured_image)
        : 'assets/img/68bd9e8705053.png' }}"

                        class="card-img-top img-fluid rounded-top"

                        alt="Property Image"

                        style="height:200px; object-fit:cover;">



                    <div class="card-body d-flex flex-column align-items-start">

                        <!-- Property Name -->



                        <h5 class="fw-bold text-primary">{{ $job->title }}</h5>

                        <h6 class="text-muted mb-2">

                            <i class="bi bi-house-door"></i>

                            {{ $job->property?->propertyContents()->first()?->title ?? 'N/A' }}
                        </h6>



                        <!-- Job Title -->





                        <!-- Job Description -->

                        <p class="text-muted mb-2" style="text-align:left;">{{ Str::limit($job->description, 100) }}</p>



                        <!-- Salary -->

                        <p class="mb-1">

                            <strong>Commercial:</strong> ${{ $job->salary }}

                            <i class="fas fa-info-circle text-primary ms-1"

                                data-bs-toggle="tooltip"

                                data-bs-placement="right"

                                title="20% commission on your amount (Platform Fee)">

                            </i>

                        </p>

                        <script>
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

                            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {

                                return new bootstrap.Tooltip(tooltipTriggerEl)

                            })
                        </script>



                        <!-- Location -->

                        <p class="mb-1">

                            <strong> Location:</strong> {{ $job->location ?? 'N/A' }}

                        </p>



                        <!-- Status -->

                        <!-- <p class="mb-2">

                        <strong>Status:</strong>

                        <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'danger' }}">

                            {{ ucfirst($job->status) }}

                        </span>

                    </p> -->



                        <div class="mt-auto w-100">

                            @if($job->status == 'open')

                            @auth



                            <button class="btn btn-primary w-100 btn-sm"

                                data-bs-toggle="modal"

                                data-bs-target="#applyModal"

                                data-job="{{ $job->id }}">

                                Apply Now

                            </button>



                            @else

                            <div class="alert alert-info p-2 w-100 mt-2 text-center small">

                                Please <a href="{{ route('user.login') }}">Login</a> to apply.

                            </div>

                            @endauth

                            @else

                            <button class="btn btn-secondary w-100 btn-sm" disabled>Closed</button>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>





    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <form method="POST" action="{{ route('user.job_management.apply_job_application') }}" id="applyForm" class="w-100">

                @csrf

                <div class="modal-content border-0 shadow-lg rounded-3">



                    <!-- Header -->

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title fw-bold" id="applyModalLabel">

                            <i class="bi bi-briefcase-fill me-2"></i> Apply for Job

                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                    </div>



                    <!-- Body -->

                    <div class="modal-body p-4">

                        <input type="hidden" name="job_id" id="job_id">



                        <!-- Cover Letter -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold d-flex text-left">Why do you want to apply for this job?</label>

                            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Write a short cover letter..." required></textarea>

                        </div>



                        <!-- Experience -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold d-flex text-left">Do you have prior experience?</label>

                            <select name="experience" class="form-select" required>

                                <option value="">Select an option</option>

                                <option value="1">Yes</option>

                                <option value="0">No</option>

                            </select>

                        </div>



                        <!-- Expected Salary -->

                        <!--<div class="mb-3">-->

                        <!--    <label class="form-label fw-semibold">Expected Amount (₹)</label>-->

                        <!--    <input type="number" name="expected_salary" class="form-control" placeholder="Enter your expected salary">-->

                        <!--</div>-->

                    </div>

                    <!-- Footer -->

                    <div class="modal-footer border-0 d-flex justify-content-between">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-send-fill me-1"></i> Submit Application

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>





</section>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        var applyModal = document.getElementById('applyModal');

        applyModal.addEventListener('show.bs.modal', function(event) {

            var button = event.relatedTarget;

            var jobId = button.getAttribute('data-job');

            document.getElementById('job_id').value = jobId;



            // Update action URL with job ID

            let form = document.getElementById('applyForm');

            form.action = form.action.replace('job_id', jobId);

        });

    });
</script>

<!--============ End Contact Section =============-->

@endsection