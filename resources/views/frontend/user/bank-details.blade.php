@php
$version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")
@section('pageHeading')
{{ __('Bank Details') }}
@endsection


@section('content')
@includeIf('frontend.partials.breadcrumb', [
'breadcrumb' => $bgImg->breadcrumb,
'title' => !empty($pageHeading) ? $pageHeading->edit_profile_page_title : __('Bank Details'),
'subtitle' => __('Bank Details'),
])


<!--====== Start Dashboard Section ======-->
<div class="user-dashboard pt-100 pb-60">
    <div class="container">
        <div class="row gx-xl-5">
            @includeIf('frontend.user.side-navbar')
            <div class="col-lg-9">
                <div class="user-profile-details mb-40">
                    <div class="account-info radius-md">
                        <div class="title">
                            <h4>{{ __('Bank Details') }}</h4>
                        </div>
                        <div class="edit-info-area">
                            @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif
                            <form action="{{ route('user.update_bank_details') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Account Holder Name') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="account_holder_name"
                                                value="{{ old('account_holder_name', Auth::guard('web')->user()->account_holder_name) }}"
                                                placeholder="{{ __('Account Holder Name') }}" required>
                                            @error('account_holder_name')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Bank Name') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="bank_name"
                                                value="{{ old('bank_name', Auth::guard('web')->user()->bank_name) }}"
                                                placeholder="{{ __('Bank Name') }}" required>
                                            @error('bank_name')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Institution Number') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="institution_number"
                                                value="{{ old('institution_number', Auth::guard('web')->user()->institution_number) }}"
                                                placeholder="{{ __('Institution Number') }}" required>
                                            @error('institution_number')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Transit Number') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="transit_number"
                                                value="{{ old('transit_number', Auth::guard('web')->user()->transit_number) }}"
                                                placeholder="{{ __('Transit Number') }}" required>
                                            @error('transit_number')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Account Number') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="account_number"
                                                value="{{ old('account_number', Auth::guard('web')->user()->account_number) }}"
                                                placeholder="{{ __('Account Number') }}" required>
                                            @error('account_number')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('Routing Number') . ' *' }} ( Transit + Institution )</label>
                                            <input type="text" class="form-control"
                                                name="routing_number"
                                                value="{{ old('routing_number', Auth::guard('web')->user()->routing_number) }}"
                                                placeholder="{{ __('Routing Number') }}" required>
                                            @error('routing_number')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-30">
                                            <label for="" class="mb-1">{{ __('SWIFT Code') . ' *' }}</label>
                                            <input type="text" class="form-control"
                                                name="swift_code"
                                                value="{{ old('swift_code', Auth::guard('web')->user()->swift_code) }}"
                                                placeholder="{{ __('SWIFT Code') }}" required>
                                            @error('swift_code')
                                            <p class="text-danger mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                        <input type="hidden" name="is_bank_kyc" value="1">
                                    <div class="col-lg-12 mb-15">
                                        <div class="form-button">
                                            <button type="submit" class="btn btn-lg btn-primary">{{ __('Update Bank Details') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--====== End Dashboard Section ======-->
        @endsection