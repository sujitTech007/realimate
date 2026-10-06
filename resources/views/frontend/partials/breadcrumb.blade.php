<!-- Page title start-->
<div class="page-title-area header-next" style="height: 110px; width: 100%;">
    <img class="lazyload blur-up bg-img" src="{{ asset('assets/img/' . $breadcrumb) }}"> 
    <div class="container">
        <div class="content text-left">
            <h1 class="color-white" style="font-size: 36px; font-weight: 700; margin-top:-40px;"> {{ !empty($title) ? $title : '' }}</h1>
            <ul class="list-unstyled">
                <li class="d-inline-block"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                <li class="d-inline-block"> >> </li>
                <li class="d-inline-block active">{{ !empty($subtitle) ? $subtitle : '' }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Page title end-->
