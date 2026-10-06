@php
    $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layouts.layout-v' . $version)

@section('pageHeading')
    {{ __('Home') }}
@endsection

@section('metaKeywords')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_keyword_home }}
    @endif
@endsection

@section('metaDescription')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_description_home }}
    @endif
@endsection


@section('content')

    <style>
        /* banner*/
        .rlm-hero.home-banner {
            position: relative;
            overflow: hidden;
            padding-top: 140px;
            padding-bottom: 40px;
        }


        .rlm-hero .home-img-slider {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .rlm-hero .home-img-slider .swiper-wrapper {
            height: 100%;
        }

        .rlm-hero .home-img-slider .swiper-slide {
            height: 100%;
        }

        .rlm-hero .home-img-slider .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rlm-hero .home-img-slider::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 12, 16, 0.55) 0%, rgba(10, 12, 16, 0.35) 40%, rgba(10, 12, 16, 0.85) 100%);
            z-index: 2;
            pointer-events: none;
        }

        .rlm-hero>.container {
            position: relative;
            z-index: 3;
            padding-top: 40px;
            padding-bottom: 40px;
            min-height: 560px;
        }

        .rlm-hero .home-slider .swiper-slide .row {
            align-items: start;
        }

        .rlm-hero .home-slider .content {
            max-width: 620px;
        }

        .rlm-hero .home-slider .subtitle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(20, 22, 26, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #E3B36A !important;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 8px 18px;
            border-radius: 999px;
            backdrop-filter: blur(6px);
            margin-bottom: 22px;
        }

        .rlm-hero .home-slider .subtitle::before {
            content: "\f3ed";
            font-family: "Font Awesome 5 Pro", "Font Awesome 5 Free";
            font-weight: 900;
            color: #E3B36A;
            font-size: 13px;
        }

        .rlm-hero .home-slider .title {
            font-size: 48px;
            line-height: 1.15;
            font-weight: 700;
            color: #fff !important;
            margin-bottom: 16px;
        }

        .rlm-hero .hero-subtext {
            color: rgba(255, 255, 255, 0.78);
            font-size: 16px;
            max-width: 460px;
            margin-bottom: 28px;
        }

        /* Feature info card */
        .rlm-hero .hero-feature-card {
            position: relative;
            z-index: 3;
            background: rgba(18, 20, 24, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px 28px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            max-width: 460px;
            margin-left: auto;
        }

        .rlm-hero .hero-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 0 0 15px 0;
        }

        /* plus-shaped dividers between the 4 items */
        .rlm-hero .hero-feature-item:nth-child(odd) {
            border-right: 1px solid rgba(255, 255, 255, 0.12);
        }

        .rlm-hero .hero-feature-item:nth-child(-n+2) {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .rlm-hero .hero-feature-item:nth-child(n+3) {
            padding-top: 18px;
            padding-bottom: 0;
        }

        .rlm-hero .hero-feature-item:nth-child(even) {
            padding-left: 16px;
        }

        .rlm-hero .hero-feature-item .icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 10px;
            background: rgba(227, 179, 106, 0.15);
            color: #E3B36A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .rlm-hero .hero-feature-item h6 {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 2px;
        }

        .rlm-hero .hero-feature-item p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 12.5px;
            line-height: 1.4;
            margin: 0;
        }

        /* rent and sale tabs */

        .rlm-hero .tabs-navigation {
            margin-bottom: 0;
            max-width: 235px;
        }

        .rlm-hero .tabs-navigation .nav-tabs {
            display: inline-flex;
            border: 0;
            gap: 10px !important;
            background: transparent;
            padding: 15px;
            margin-bottom: 0px;
        }

        .rlm-hero .tabs-navigation .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 10px;
            color: #fff;
            background: transparent;
            padding: 10px 22px;
            font-weight: 600;
            font-size: 14px;
        }

        .rlm-hero .tabs-navigation .nav-link.active {
            background: #E3B36A;
            border-color: #E3B36A;
            color: #14161a;
        }

        .rlm-hero .tabs-navigation .nav-item:first-child .nav-link::before {
            content: "\f015";
            font-family: "Font Awesome 5 Pro", "Font Awesome 5 Free";
            font-weight: 900;
        }

        .rlm-hero .tabs-navigation .nav-item:last-child .nav-link::before {
            content: "\f02b";
            font-family: "Font Awesome 5 Pro", "Font Awesome 5 Free";
            font-weight: 900;
        }

        /* Search form card */
        .rlm-hero .form-wrapper {
            background: #fff;
            border-radius: 16px;
            padding: 25px 22px !important;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
            margin-top: -5px !important;
        }

        .rlm-hero .form-wrapper .grid {
            display: grid;
            grid-template-columns: 0.8fr 1.1fr 1.1fr 1fr 1.3fr auto;
            align-items: center;
            gap: 0;
        }

        .rlm-hero .form-wrapper .grid-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 18px;
            border-right: 1px solid #ECECEC;
        }

        .rlm-hero .form-wrapper .grid-item:last-child {
            border-right: 0;
            padding-right: 0;
        }

        .rlm-hero .form-wrapper .grid-item:first-child {
            padding-left: 4px;
        }

        .rlm-hero .form-wrapper .field-icon {
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #F6EFE3;
            color: #C89B5C;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .rlm-hero .form-wrapper .field-body {
            flex: 1 1 auto;
            min-width: 0;
        }

        .rlm-hero .form-wrapper label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #8B8F97;
            margin-bottom: 4px;
        }

        .rlm-hero .form-wrapper .form-control {
            border: 0;
            padding: 0;
            font-size: 14px;
            font-weight: 500;
            color: #14161a;
            box-shadow: none;
            background: transparent;
        }

        .rlm-hero .form-wrapper .price-value {
            font-size: 12px;
            font-weight: 600;
            color: #8B8F97;
            margin-bottom: 4px;
        }

        .rlm-hero .form-wrapper .price-value span {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #14161a;
            margin-top: 2px;
        }

        .rlm-hero .form-wrapper .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            padding: 14px 26px;
            white-space: nowrap;
            background: #14161a !important;
            border-color: #14161a;
        }

        @media (max-width: 991px) {
            .rlm-hero .form-wrapper .grid {
                grid-template-columns: 1fr 1fr;
            }

            .rlm-hero .form-wrapper .grid-item {
                border-right: 0;
                border-bottom: 1px solid #ECECEC;
                padding: 12px 4px;
            }

            .rlm-hero .home-slider .content {
                max-width: 100%;
            }

            .rlm-hero .hero-feature-card {
                margin-left: 0;
                margin-top: 24px;
                grid-template-columns: 1fr 1fr;
            }

            .rlm-hero .home-slider .title {
                font-size: 34px;
            }
        }

        .home-banner .banner-filter-form .nav .nav-item:not(:last-child) .nav-link:not(.active)::before {
            content: "\f015";
        }
    </style>

    <section class="home-banner home-banner-2 rlm-hero">
        <div class="container">
            <div class="swiper home-slider" id="home-slider-1">
                <div class="swiper-wrapper">
                    @foreach ($sliderInfos as $slider)
                        <div class="swiper-slide">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="content text-start mx-0">
                                        <span class="subtitle color-white">{{ $slider->title }}</span>
                                        <h1 class="title color-white mb-0">{{ $slider->text }}</h1>

                                        <p class="hero-subtext">
                                            {{ __('Discover premium properties in prime locations and build your tomorrow, today.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-5">

                                    <div class="hero-feature-card">
                                        <div class="hero-feature-item">
                                            <div class="icon"><i class="fal fa-map-marker-alt"></i></div>
                                            <div>
                                                <h6>{{ __('Premium Locations') }}</h6>
                                                <p>{{ __('Handpicked prime locations') }}</p>
                                            </div>
                                        </div>
                                        <div class="hero-feature-item">
                                            <div class="icon"><i class="fal fa-shield-check"></i></div>
                                            <div>
                                                <h6>{{ __('Verified Properties') }}</h6>
                                                <p>{{ __('100% verified and legal properties') }}</p>
                                            </div>
                                        </div>
                                        <div class="hero-feature-item">
                                            <div class="icon"><i class="fal fa-badge-percent"></i></div>
                                            <div>
                                                <h6>{{ __('Best Value') }}</h6>
                                                <p>{{ __('Competitive prices guaranteed') }}</p>
                                            </div>
                                        </div>
                                        <div class="hero-feature-item">
                                            <div class="icon"><i class="fal fa-headset"></i></div>
                                            <div>
                                                <h6>{{ __('Expert Support') }}</h6>
                                                <p>{{ __('Guidance at every step') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="banner-filter-form mt-5" data-aos="fade-up">
                <div class="row">
                    <div class="col-12">
                        <div class="tabs-navigation justify-content-start ms-2">
                            <ul class="nav nav-tabs w-100">
                                <li class="nav-item">
                                    <button class="nav-link btn-md active" data-bs-toggle="tab" data-bs-target="#rent"
                                        type="button">{{ __('Rent') }}</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link btn-md" data-bs-toggle="tab" data-bs-target="#sale"
                                        type="button">{{ __('Sale') }}</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content form-wrapper position-relative z-2">
                            <input type="hidden" id="currency_symbol" value="{{ $basicInfo->base_currency_symbol }}">
                            <input type="hidden" name="min" value="{{ $min }}" id="min">
                            <input type="hidden" name="max" value="{{ $max }}" id="max">

                            <input class="form-control" type="hidden" value="{{ $min }}" id="o_min">
                            <input class="form-control" type="hidden" value="{{ $max }}" id="o_max">
                            <div class="tab-pane fade show active" id="rent">
                                <form action="{{ route('frontend.properties') }}" method="get">
                                    <input type="hidden" name="purposre" value="rent">
                                    <input type="hidden" name="min" value="{{ $min }}" id="min1">
                                    <input type="hidden" name="max" value="{{ $max }}" id="max1">
                                    <div class="grid">
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fa fa-map-pin"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="search1">{{ __('Location') }}</label>
                                                    <input type="text" id="search1" name="location" class="form-control"
                                                        placeholder="{{ __('Location') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fas fa-building"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="type" class="icon-end">{{ __('Property Type') }}</label>
                                                    <select aria-label="#" name="type" class="form-control select2 type"
                                                        id="type">
                                                        <option selected disabled value="">{{ __('Select Property') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        <option value="residential">{{ __('Residential') }}</option>
                                                        <option value="commercial">{{ __('Commercial') }}</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fa fa-list-alt"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="category" class="icon-end">{{ __('Categories') }}</label>
                                                    <select aria-label="#" class="form-control select2 bringCategory"
                                                        id="category" name="category">
                                                        <option selected disabled value="">{{ __('Select Category') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        @foreach ($all_proeprty_categories as $category)
                                                            <option value="{{ @$category->categoryContent->slug }}">
                                                                {{ @$category->categoryContent->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-item city">
                                            <div class="field-icon"><i class="fas fa-city"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="city" class="icon-end">{{ __('City') }}</label>
                                                    <select aria-label="#" name="city" class="form-control select2 city_id"
                                                        id="city">
                                                        <option selected disabled value="">{{ __('Select City') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        @foreach ($all_cities as $city)
                                                            <option data-id="{{ $city->id }}"
                                                                value="{{ $city->cityContent?->name }}">
                                                                {{ $city->cityContent?->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fas fa-wallet"></i></div>
                                            <div class="field-body">
                                                <label class="price-value">{{ __('Price') }}
                                                    <span data-range-value="filterPriceSliderValue">{{ symbolPrice($min) }}
                                                        -
                                                        {{ symbolPrice($max) }}</span>
                                                </label>
                                                <div data-range-slider="filterPriceSlider"></div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary bg-primary icon-start w-100">
                                                <i class="fal fa-search"></i> {{ __('Search') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="sale">
                                <form action="{{ route('frontend.properties') }}" method="get">
                                    <input type="hidden" name="purposre" value="sale">
                                    <input type="hidden" name="min" value="{{ $min }}" id="min2">
                                    <input type="hidden" name="max" value="{{ $max }}" id="max2">
                                    <div class="grid">
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fa fa-map-pin"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="search1">{{ __('Location') }}</label>
                                                    <input type="text" id="search1" name="location" class="form-control"
                                                        placeholder="{{ __('Location') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fas fa-building"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="type1" class="icon-end">{{ __('Property Type') }}</label>
                                                    <select aria-label="#" name="type" class="form-control select2 type"
                                                        id="type1">
                                                        <option selected disabled value="">{{ __('Select Property') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        <option value="residential">{{ __('Residential') }}</option>
                                                        <option value="commercial">{{ __('Commercial') }}</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fas fa-grid-2"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="category1" class="icon-end">{{ __('Categories') }}</label>
                                                    <select aria-label="#" class="form-control select2 bringCategory"
                                                        id="category1" name="category">
                                                        <option selected disabled value="">{{ __('Select Category') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        @foreach ($all_proeprty_categories as $category)
                                                            <option value="{{ @$category->categoryContent->slug }}">
                                                                {{ @$category->categoryContent->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-item city">
                                            <div class="field-icon"><i class="fas fa-city"></i></div>
                                            <div class="field-body">
                                                <div class="form-group">
                                                    <label for="city1" class="icon-end">{{ __('City') }}</label>
                                                    <select aria-label="#" name="city" class="form-control select2 city_id"
                                                        id="city1">
                                                        <option selected disabled value="">{{ __('Select City') }}
                                                        </option>
                                                        <option value="all">{{ __('All') }}</option>

                                                        @foreach ($all_cities as $city)
                                                            <option data-id="{{ $city->id }}"
                                                                value="{{ @$city->cityContent->name }}">
                                                                {{ @$city->cityContent->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <div class="field-icon"><i class="fas fa-wallet"></i></div>
                                            <div class="field-body">
                                                <label class="price-value">{{ __('Price') }}
                                                    <span data-range-value="filterPriceSlider2Value">{{ symbolPrice($min) }}
                                                        -
                                                        {{ symbolPrice($max) }}</span>
                                                </label>
                                                <div data-range-slider="filterPriceSlider2"></div>
                                            </div>
                                        </div>
                                        <div class="grid-item">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary bg-primary icon-start w-100">
                                                <i class="fal fa-search"></i> {{ __('Search') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="swiper-pagination pagination-fraction mt-40" id="home-slider-1-pagination"></div>-->
        </div>

        <div class="swiper home-img-slider" id="home-img-slider-1">
            <div class="swiper-wrapper">
                @foreach ($sliderInfos as $slider)
                    <div class="swiper-slide">
                        <img class="lazyload bg-img" src=" {{ asset('assets/img/hero/sliders/' . $slider->background_image) }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($secInfo->category_section_status == 1)
        <section class="category pt-100 pb-70 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-inline mb-40" data-aos="fade-up">
                            <h2 class="title">{{ @$catgorySecInfo->title }}</h2>
                            <!-- Slider navigation buttons -->
                            <div class="slider-navigation">
                                <button type="button" title="Slide prev" class="slider-btn cat-slider-btn-prev rounded-pill">
                                    <i class="fal fa-angle-left"></i>
                                </button>
                                <button type="button" title="Slide next" class="slider-btn cat-slider-btn-next rounded-pill">
                                    <i class="fal fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-up">
                        <div class="swiper" id="category-slider-1">
                            <div class="swiper-wrapper">
                                @forelse ($property_categories as $category)
                                    <div class="swiper-slide mb-30 color-1">
                                        <a
                                            href="{{ route('frontend.properties', ['category' => $category->categoryContent?->slug]) }}">
                                            <div class="category-item bg-white radius-md text-center">
                                                <div class="category-icons ">
                                                    <img src="{{ asset('assets/img/property-category/' . $category->image) }}">
                                                </div>
                                                <span
                                                    class="category-title d-block mt-3 m-0 color-medium">{{ $category->categoryContent?->name }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class=" p-3 text-center mb-30">
                                            <h3 class="mb-0"> {{ __('No Categories Found') }}</h3>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->featured_properties_section_status == 1)
        <section class="featured-product pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-inline mb-40" data-aos="fade-up">
                            <h2 class="title">{{ @$featuredSecInfo->title }}</h2>
                            <!-- Slider navigation buttons -->
                            <div class="slider-navigation">
                                <button type="button" title="Slide prev"
                                    class="slider-btn product-slider-btn-prev rounded-pill">
                                    <i class="fal fa-angle-left"></i>
                                </button>
                                <button type="button" title="Slide next"
                                    class="slider-btn product-slider-btn-next rounded-pill">
                                    <i class="fal fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-up">
                        <div class="swiper product-slider">
                            <div class="swiper-wrapper">
                                @forelse ($featured_properties as $property)
                                    {{-- property component --}}
                                    <div class="swiper-slide">
                                        <x-property :property="$property" />
                                    </div>
                                @empty
                                    <div class=" p-3 text-center mb-30 w-100">
                                        <h3 class="mb-0"> {{ __('No Featured Property Found') }}</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->call_to_action_section_status == 1)
        <section class="video-banner with-radius pt-100 pb-70">
            <!-- Background Image -->
            <div class="bg-overlay">
                <img class="lazyload bg-img" src=" {{ asset('assets/img/' . $callToActionSectionImage) }}">
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="content mb-30" data-aos="fade-up">
                            <span class="subtitle text-white">{{ @$callToActionSecInfo->title }}</span>
                            <h2 class="title text-white mb-10">{{ $callToActionSecInfo?->subtitle }}</h2>
                            <p class="text-white m-0 w-75 w-sm-100">{{ $callToActionSecInfo?->text }}</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        @if (!empty($callToActionSecInfo?->video_url))
                            <div class="d-flex align-items-center justify-content-center h-100 mb-30" data-aos="fade-up">
                                <a href="{{ $callToActionSecInfo->video_url }}" class="video-btn youtube-popup">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->property_section_status == 1)
        <section class="popular-product pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-inline mb-40" data-aos="fade-up">
                            <h2 class="title">{{ @$propertySecInfo->title }}</h2>
                            <div class="tabs-navigation">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <button class="nav-link active btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forAll" type="button">{{ __('All Properties') }}</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forRent" type="button">{{ __('For Rent') }}</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forSell" type="button">{{ __('For Sale') }}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="tab-content" data-aos="fade-up">
                            <div class="tab-pane fade show active" id="forAll">
                                <div class="row">
                                    @forelse ($properties as $property)
                                        {{-- property component --}}
                                        <x-property :property="$property" class="col-xxl-3 col-lg-4 col-sm-6" />
                                    @empty
                                        <div class="p-3 text-center mb-30">
                                            <h3 class="mb-0"> {{ __('No Properties Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="forRent">
                                <div class="row">
                                    @forelse ($properties as $property)
                                        @if ($property->purpose == 'rent')
                                            {{-- property component --}}
                                            <x-property :property="$property" class="col-xxl-3 col-lg-4 col-sm-6" />
                                        @endif
                                    @empty
                                        <div class=" p-3 text-center mb-30">
                                            <h3 class="mb-0"> {{ __('No Properties Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="forSell">
                                <div class="row">
                                    @forelse ($properties as $property)
                                        @if ($property->purpose == 'sale')
                                            {{-- property component --}}
                                            <x-property :property="$property" class="col-xxl-3 col-lg-4 col-sm-6" />
                                        @endif
                                    @empty
                                        <div class=" p-3 text-center mb-30">
                                            <h3 class="mb-0"> {{ __('No Properties Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->work_process_section_status == 1)
        <section class="work-process pt-100 pb-70">
            <!-- Bg image -->
            <img class="lazyload bg-img" src="{{ asset('assets/front/images/2548hg445t5464676.png') }}">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-40" data-aos="fade-up">
                            <span class="subtitle">{{ @$workProcessSecInfo->title }}</span>
                            <h2 class="title">{{ $workProcessSecInfo?->subtitle }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row gx-xl-5">
                            @forelse ($processes as $process)
                                <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up">
                                    <div class="process-item text-center mb-30 color-1">
                                        <div class="process-icon">
                                            <div class="progress-content">
                                                <span class="h2 lh-1">{{ $loop->iteration }}</span>
                                                <i class="{{ $process->icon }}"></i>
                                            </div>
                                            <div class="progressbar-line-inner">
                                                <svg>
                                                    <circle class="progressbar-circle" r="96" cx="100" cy="100"
                                                        stroke-dasharray="500" stroke-dashoffset="180" stroke-width="6" fill="none"
                                                        transform="rotate(-5 100 100)">
                                                    </circle>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="process-content mt-20">
                                            <h3 class="process-title">{{ $process->title }}</h3>
                                            <p class="text m-0">{{ $process->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center mb-30 w-100">
                                    <h3 class="mb-0"> {{ __('No Work Process Found') }}</h3>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->pricing_section_status == 1)
        <section class="pricing-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title title-center mb-20" data-aos="fade-up">
                            <span class="subtitle">{{ @$pricingSecInfo->title }}</span>
                            <h2 class="title">{{ $pricingSecInfo?->subtitle }}</h2>
                            <p class="text mb-0 w-50 w-sm-100 mx-auto">{{ $pricingSecInfo?->description }}</p>
                        </div>
                    </div>

                    <div class="col-12 ">
                        <div class="section-title title-inline mb-40 justify-content-center" data-aos="fade-up">
                            <div class="tabs-navigation ">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <button class="nav-link active btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forAll1" type="button">{{ __('Monthly') }}</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forRent1" type="button">{{ __('Yearly') }}</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link btn-md rounded-pill" data-bs-toggle="tab"
                                            data-bs-target="#forSell1" type="button">{{ __('Lifetime') }}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="tab-content" data-aos="fade-up">
                            <div class="tab-pane fade show active" id="forAll1">
                                <div class="row justify-content-center">
                                    @forelse ($packages as $package)
                                        @if ($package->term == 'monthly')
                                            <div class="col-md-6 col-lg-4">
                                                <div class="pricing-item mb-30 radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon color-primary"><i class="{{ $package->icon }}"></i>
                                                        </div>
                                                        <div class="label">
                                                            <h3>{{ $package->title }}</h3>
                                                        </div>
                                                    </div>


                                                    <div class="d-flex align-items-center mt-15">
                                                        <span class="price">{{ symbolPrice($package->price) }}</span>
                                                        <span class="period text-capitalize">/
                                                            {{ __($package->term) }}</span>
                                                    </div>
                                                    <h5>{{ __("What's Included") }}</h5>
                                                    <ul class="item-list list-unstyled p-0 pricing-list">

                                                        @if ($package->number_of_agent >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_agent == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Agents') }}
                                                                @elseif ($package->number_of_agent > 1)
                                                                    {{ $package->number_of_agent }} {{ __('Agents') }}
                                                                @else
                                                                    {{ $package->number_of_agent }} {{ __('Agent') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Agent') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property >= 1)
                                                            <li><i class="fal fa-check"></i>


                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Properties') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Properties') }}
                                                                @else
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Property') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Property') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_adittionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_adittionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_adittionl_specifications }}
                                                                @endif
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_projects >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Projects') }}
                                                                @else
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Project') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_types >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_types == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_types }}
                                                                @endif
                                                                {{ __('Project Types') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project Types') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_additionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_project_additionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_additionl_specifications }}
                                                                @endif

                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                    </ul>
                                                    <a href="{{ auth('vendor')->check() ? route('vendor.plan.extend.index') : route('vendor.login') }}"
                                                        class="btn btn-outline btn-lg rounded-pill w-100">
                                                        {{ __('Get Started') }}</a>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="p-3 text-center mb-30 w-100">
                                            <h3 class="mb-0"> {{ __('No Pricing Plan Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="forRent1">
                                <div class="row justify-content-center">
                                    @forelse ($packages as $package)
                                        @if ($package->term == 'yearly')
                                            <div class="col-md-6 col-lg-4">
                                                <div class="pricing-item mb-30 radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon color-primary"><i class="{{ $package->icon }}"></i>
                                                        </div>
                                                        <div class="label">
                                                            <h3>{{ $package->title }}</h3>
                                                        </div>
                                                    </div>


                                                    <div class="d-flex align-items-center mt-15">
                                                        <span class="price">{{ symbolPrice($package->price) }}</span>
                                                        <span class="period text-capitalize">/
                                                            {{ __($package->term) }}</span>
                                                    </div>
                                                    <h5>{{ __("What's Included") }}</h5>
                                                    <ul class="item-list list-unstyled p-0 pricing-list">

                                                        @if ($package->number_of_agent >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_agent == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Agents') }}
                                                                @elseif ($package->number_of_agent > 1)
                                                                    {{ $package->number_of_agent }} {{ __('Agents') }}
                                                                @else
                                                                    {{ $package->number_of_agent }} {{ __('Agent') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Agent') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property >= 1)
                                                            <li><i class="fal fa-check"></i>


                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Properties') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Properties') }}
                                                                @else
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Property') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Property') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_adittionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_adittionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_adittionl_specifications }}
                                                                @endif
                                                                {{ __('Additional Features') }}({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_projects >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Projects') }}
                                                                @else
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Project') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_types >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_types == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_types }}
                                                                @endif
                                                                {{ __('Project Types') }}({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project Types') }}({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_additionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_project_additionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_additionl_specifications }}
                                                                @endif

                                                                {{ __('Additional Features') }}({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                    </ul>
                                                    <a href="{{ auth('vendor')->check() ? route('vendor.plan.extend.index') : route('vendor.login') }}"
                                                        class="btn btn-outline btn-lg rounded-pill w-100">
                                                        {{ __('Get Started') }} </a>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="p-3 text-center mb-30 w-100">
                                            <h3 class="mb-0"> {{ __('No Pricing Plan Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="forSell1">
                                <div class="row justify-content-center">
                                    @forelse ($packages as $package)
                                        @if ($package->term == 'lifetime')
                                            <div class="col-md-6 col-lg-4">
                                                <div class="pricing-item mb-30 radius-lg" data-aos="fade-up">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon color-primary"><i class="{{ $package->icon }}"></i>
                                                        </div>
                                                        <div class="label">
                                                            <h3>{{ $package->title }}</h3>
                                                        </div>
                                                    </div>


                                                    <div class="d-flex align-items-center mt-15">
                                                        <span class="price">{{ symbolPrice($package->price) }}</span>
                                                        <span class="period text-capitalize">/
                                                            {{ __($package->term) }}</span>
                                                    </div>
                                                    <h5>{{ __("What's Included") }}</h5>
                                                    <ul class="item-list list-unstyled p-0 pricing-list">

                                                        @if ($package->number_of_agent >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_agent == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Agents') }}
                                                                @elseif ($package->number_of_agent > 1)
                                                                    {{ $package->number_of_agent }} {{ __('Agents') }}
                                                                @else
                                                                    {{ $package->number_of_agent }} {{ __('Agent') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Agent') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property >= 1)
                                                            <li><i class="fal fa-check"></i>


                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }} {{ __('Properties') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Properties') }}
                                                                @else
                                                                    {{ $package->number_of_property }}
                                                                    {{ __('Property') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Property') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_property_adittionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property_adittionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_property_adittionl_specifications }}
                                                                @endif
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Property') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Property') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_projects >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_property == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @elseif ($package->number_of_property > 1)
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Projects') }}
                                                                @else
                                                                    {{ $package->number_of_projects }}
                                                                    {{ __('Project') }}
                                                                @endif
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project') }}
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_types >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_types == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_types }}
                                                                @endif
                                                                {{ __('Project Types') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Project Types') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_gallery_images >= 1)
                                                            <li><i class="fal fa-check"></i>
                                                                @if ($package->number_of_project_gallery_images == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_gallery_images }}
                                                                @endif
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Gallery Images') }} ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                        @if ($package->number_of_project_additionl_specifications >= 1)
                                                            <li><i class="fal fa-check"></i>

                                                                @if ($package->number_of_project_additionl_specifications == 999999)
                                                                    {{ __('Unlimited') }}
                                                                @else
                                                                    {{ $package->number_of_project_additionl_specifications }}
                                                                @endif

                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Project') }})
                                                            </li>
                                                        @else
                                                            <li class="disabled"><i class="fal fa-times"></i>
                                                                {{ __('Additional Features') }}
                                                                ({{ __('Per Project') }})
                                                            </li>
                                                        @endif

                                                    </ul>


                                                    <a href="{{ auth('vendor')->check() ? route('vendor.plan.extend.index') : route('vendor.login') }}"
                                                        class="btn btn-outline btn-lg rounded-pill w-100">
                                                        {{ __('Get Started') }} </a>


                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="p-3 text-center mb-30 w-100">
                                            <h3 class="mb-0"> {{ __('No Pricing Plan Found') }}</h3>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($secInfo->testimonial_section_status == 1)
        <section class="testimonial-area testimonial-2 with-radius pt-100 pb-70">
            <!-- Bg image -->
            <img class="lazyload bg-img" src="{{ asset('assets/img/' . $testimonialSecImage) }}">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="content mb-30" data-aos="fade-up">
                            <div class="content-title">
                                <span class="subtitle">
                                    {{ @$testimonialSecInfo->title }}</span>
                                <h2 class="title">
                                    {{ $testimonialSecInfo?->subtitle }}
                                </h2>
                            </div>
                            <p class="text mb-30">
                                {{ $testimonialSecInfo?->content }}
                            </p>
                            <!-- Slider pagination -->
                            <!--<div class="swiper-pagination pagination-fraction" id="testimonial-slider-2-pagination">-->
                            <!--</div>-->
                            <div class="slider-navigation">
                                <button type="button" title="Slide prev" class="slider-btn test-slider-btn-prev rounded-pill">
                                    <i class="fal fa-angle-left"></i>
                                </button>
                                <button type="button" title="Slide next" class="slider-btn test-slider-btn-next rounded-pill">
                                    <i class="fal fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" data-aos="fade-up">
                        <div class="swiper" id="testimonial-slider-2">
                            <div class="swiper-wrapper">
                                @forelse ($testimonials as $testimonial)
                                    <div class="swiper-slide pb-30">
                                        <div class="slider-item">
                                            <div class="client-content">
                                                <div class="quote">
                                                    <p class="text mb-20">{{ $testimonial->comment }}</p>
                                                    <div class="ratings">
                                                        <div class="rate">
                                                            <div class="rating-icon"
                                                                style="width: {{ $testimonial->rating * 20 }}%"></div>
                                                        </div>
                                                        <span class="ratings-total">({{ $testimonial->rating }}) </span>
                                                    </div>
                                                </div>
                                                <div class="client-info d-flex align-items-center">
                                                    <div class="client-img position-static">
                                                        <div class="lazy-container rounded-pill ratio ratio-1-1">
                                                            @if (is_null($testimonial->image))
                                                                <img data-src="{{ asset('assets/img/profile.jpg') }}" class="lazyload">
                                                            @else
                                                                <img class="lazyload"
                                                                    data-src="{{ asset('assets/img/clients/' . $testimonial->image) }}">
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="name">{{ $testimonial->name }}</h6>
                                                        <span class="designation">{{ $testimonial->occupation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3 text-center mb-30 w-100">
                                        <h3 class="mb-0"> {{ __('No Testimonials Found') }}</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

  
@endsection