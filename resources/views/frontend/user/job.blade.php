@php
$version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")
@section('pageHeading')
{{ __('Applied Job') }}
@endsection


@section('content')
@includeIf('frontend.partials.breadcrumb', [
'breadcrumb' => $bgImg->breadcrumb,
'title' => !empty($pageHeading) ? $pageHeading->wishlist_page_title : __('Applied Job'),
'subtitle' => __('Applied Job'),
])


<!--====== Start Dashboard Section ======-->
<div class="user-dashboard pt-100 pb-60">
    <div class="container">
        <div class="row gx-xl-5">
            @includeIf('frontend.user.side-navbar')
            <div class="col-lg-9">
                <div class="account-info radius-md mb-40">
                    <div class="title">
                        <h4>{{ __('Applied Job') }}</h4>
                    </div>
                    <div class="main-info">
                        <div class="main-table">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">{{ __('Cover Letter') }}</th>
                                            <th scope="col">{{ __('Experience') }}</th>
                                            <!--<th scope="col">{{ __('Expected Salary') }}</th>-->
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Applied At') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobApply as $jobApplication)
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
                                            <!--    ${{ $jobApplication->expected_salary }}-->
                                            <!--</td>-->
                                            <td>
                                                <span class="
                                                {{ $jobApplication->status == 'applied' ? ' bg-info text-white' : '' }}
                                                {{ $jobApplication->status == 'shortlisted' ? ' bg-warning text-dark' : '' }}
                                                {{ $jobApplication->status == 'hired' ? ' bg-success text-white' : '' }}
                                                {{ $jobApplication->status == 'rejected' ? ' bg-danger text-white' : '' }}
                                            ">
                                                    {{ ucfirst($jobApplication->status) }}
                                                </span>

                                            </td>
                                            <td>
                                                {{ $jobApplication->applied_at }}
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
        </div>
    </div>
</div>
<!--====== End Dashboard Section ======-->
@endsection