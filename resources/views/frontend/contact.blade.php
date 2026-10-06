@php
$version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
{{ !empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact') }}
@endsection

@section('metaKeywords')
@if (!empty($seoInfo))
{{ $seoInfo->meta_keyword_contact }}
@endif
@endsection

@section('metaDescription')
@if (!empty($seoInfo))
{{ $seoInfo->meta_description_contact }}
@endif
@endsection

@section('content')
@includeIf('frontend.partials.breadcrumb', [
'breadcrumb' => $bgImg->breadcrumb,
'title' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact'),
'subtitle' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact'),
])

<!--====================================================-->
<!--============== Start Contact Section ===============-->
<!--====================================================-->
<div class="contact-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            @if (!empty($info->contact_number))
            <div class="col-lg-4 col-md-6">
                <div class="card mb-30 color-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon">
                        <i class="fal fa-phone-plus"></i>
                    </div>
                    <div class="card-text">

                        <p><a href="tel:{{ $info->contact_number }}">{{ $info->contact_number }}</a></p>

                    </div>
                </div>
            </div>
            @endif
            @if (!empty($info->address))
            <div class="col-lg-4 col-md-6">
                <div class="card mb-30 color-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon">
                        <i class="fal fa-envelope"></i>
                    </div>
                    <div class="card-text">

                        <p><a href="javascript:void(0)">{{ $info->address }}</a></p>

                    </div>
                </div>
            </div>
            @endif
            @if (!empty($info->email_address))
            <div class="col-lg-4 col-md-6">
                <div class="card mb-30 color-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon">
                        <i class="fal fa-map-marker-alt"></i>
                    </div>
                    <div class="card-text">

                        <p><a href="mailTo:{{ $info->email_address }}">{{ $info->email_address }}</a></p>

                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="pb-70"></div>

        <div class="row gx-xl-5">
            <div class="col-lg-6 mb-30" data-aos="fade-left">
                @if (!empty($info->latitude) && !empty($info->longitude))
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33041.67410914395!2d-105.32268649035558!3d55.11301064299811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5255250a9f36fc6f%3A0xd6cb198708cd6b6!2sLa%20Ronge%2C%20SK%2C%20Canada!5e1!3m2!1sen!2sin!4v1783767143924!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                @endif
            </div>
            <div class="col-lg-6 mb-30 order-lg-first" data-aos="fade-right">
                @if (Session::has('success'))
                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
                @endif
                @if (Session::has('error'))
                <div class="alert alert-success">{{ __(Session::get('error')) }}</div>
                @endif
                <form id="contactForm" action="{{ route('contact.send_mail') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-20">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="{{ __('Enter Your Full Name') }}" />
                                @error('name')
                                <div class="help-block with-errors text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-20">
                                <input type="email" name="email" class="form-control" id="email" required
                                    data-error="Enter your email" placeholder="{{ __('Enter Your Email') }}" />
                                @error('email')
                                <div class="help-block with-errors text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-20">
                                <input type="text" name="subject" class="form-control" id="" required
                                    placeholder="{{ __('Enter Email Subject') }}" />
                                @error('subject')
                                <div class="help-block with-errors text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-20">
                                <textarea name="message" id="message" class="form-control" cols="30" rows="8" required
                                    placeholder="{{ __('Write Your Message') }}"></textarea>
                                @error('message')
                                <div class="help-block with-errors text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if ($info->google_recaptcha_status == 1)
                        <div class="col-md-12">
                            <div class="form-group mb-20">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                <div class="help-block with-errors text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-primary"
                                title="{{ __('Send message') }}">{{ __('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="pb-70"></div>
    </div>

    @if (!empty(showAd(3)))
    <div class="text-center">
        {!! showAd(3) !!}
    </div>
    @endif
</div>
<!--============ End Contact Section =============-->
@endsection