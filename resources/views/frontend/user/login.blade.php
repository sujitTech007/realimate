@php

$version = $basicInfo->theme_version;

@endphp

@extends('frontend.layouts.layout-v' . $version)

@section('pageHeading')

{{ !empty($pageHeading) ? $pageHeading->login_page_title : __('Login') }}

@endsection

@section('metaKeywords')

@if (!empty($seoInfo))

{{ $seoInfo->meta_keyword_login }}

@endif

@endsection



@section('metaDescription')

@if (!empty($seoInfo))

{{ $seoInfo->meta_description_login }}

@endif

@endsection



@section('content')

@includeIf('frontend.partials.breadcrumb', [

'breadcrumb' => $bgImg->breadcrumb,

'title' => !empty($pageHeading) ? $pageHeading->login_page_title : __('Login'),

'subtitle' => __('Login'),

])

<!-- Authentication-area start -->

<div class="authentication-area ptb-100">

    <div class="container">



        <div class="auth-form border radius-md">

            <div class="form-group overflow-hidden mb-3">

                <div class="row justify-content-between">

            {{--       @if ($basicInfo->facebook_login_status == 1)

                    <a class="text-center w-50 pt-2 py-2 bg-facebook" href="{{ route('user.login.facebook') }}"><i

                            class="fas fa-facebook-f"></i>

                        {{ __('Login with Facebook') }}</a>

                    @endif

                    @if ($basicInfo->google_login_status == 1)

                    <a class="text-center w-50 pt-2 py-2 bg-google" href="{{ route('user.login.google') }}"> <i

                            class="fas fa-google"></i>

                        {{ __('Login with Google') }}</a>

                    @endif --}}

                </div>

            </div>

            @if (Session::has('success'))

            <div class="alert alert-success">{{ __(Session::get('success')) }}</div>

            @endif

            @if (Session::has('error'))

            <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>

            @endif

            <form action="{{ route('user.login_submit') }}" method="POST" id="loginForm">

                @csrf

                <div class="title">

                    <h4 class="mb-20">{{ __('Login') }}</h4>

                </div>

                <div class="form-group mb-30">

                    <input type="text" class="form-control" name="phone" placeholder="{{ __('Phone Number') }}" required>

                    @error('phone')

                    <p class="text-danger mt-2">{{ $message }}</p>

                    @enderror

                </div>



                <div class="form-group mb-30">

                    <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required>

                    @error('password')

                    <p class="text-danger mt-2">{{ $message }}</p>

                    @enderror

                </div>



                @if ($bs->google_recaptcha_status == 1)

                <div class="form-group mb-30">

                    {!! NoCaptcha::renderJs() !!}

                    {!! NoCaptcha::display() !!}

                    @error('g-recaptcha-response')

                    <p class="mt-1 text-danger">{{ $message }}</p>

                    @enderror

                </div>

                @endif



                <div class="row align-items-center mb-20">

                    <div class="col-4 col-xs-12">

                        <div class="link">

                            <a href="{{ route('user.forget_password') }}">{{ __('Forgot password') . '?' }}</a>

                        </div>

                    </div>

                    <div class="col-8 col-xs-12">

                        <div class="link go-signup">

                            {{ __("don't have an account") . '?' }} <a href="{{ route('user.signup') }}">{{ __('Click Here') }}</a>

                            {{ __('to Signup') }}

                        </div>

                    </div>

                </div>

                <button type="button" id="sendOtpBtn" class="btn btn-lg btn-primary radius-md w-100 mb-2"> {{ __('Send OTP') }} </button>

            </form>

       
             
            <!-- <button type="button" id="sendOtpBtn" class="btn btn-lg btn-primary radius-md w-100 mb-2"> Login as a <a href="{{ route('vendor.login') }}"> Vendor </a> </button> -->
            <div class="d-flex justify-content-center mt-4">
    <a href="{{ route('vendor.login') }}" class="btn btn-lg btn-primary rounded w-50 mb-2">
        Login as a Vendor
    </a>
</div>
       
            <!-- OTP Form (hidden by default) -->

            <div id="otpBox" style="display:none; margin-top:20px;">

                <div class="title text-center">

                    <h4 class="mb-20">{{ __('Enter OTP') }}</h4>

                </div>

                <div class="d-flex justify-content-center gap-2">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">

                    <input type="text" maxlength="1" class="form-control text-center otp-input" placeholder="*" style="width:50px; border:1px solid #bda588;">
                </div>

                <div id="otpMessage" class="mt-2"></div>

                <button type="button" id="verifyOtpBtn" class="btn btn-lg btn-primary radius-md w-100 mt-3">Verify OTP</button>
                
                <div class="text-center mt-3">

                    <p class="mb-2 text-muted">
                        Didn't receive the OTP?
                    </p>
                
                    <span id="otpTimer" class="text-muted">
                        Resend OTP in <span id="countdown">30</span>s
                    </span>
                
                    <a href="javascript:void(0)"
                       id="resendOtp"
                       class="text-primary fw-bold text-decoration-none"
                       style="display:none;">
                        Resend OTP
                    </a>
                
                </div>
            </div>

            <div id="otpLoader" style="display:none; text-align:center; margin-top:10px;">

                <div class="spinner-border text-primary" role="status">

                    <span class="visually-hidden">Verifying...</span>

                </div>

                <p class="mt-2">Verifying OTP...</p>

            </div>

        </div>

    </div>

</div>



<script>

    // Send OTP after validating credentials

    document.getElementById('sendOtpBtn').addEventListener('click', function() {

    let formData = new FormData(document.getElementById('loginForm'));



    fetch("{{ route('user.login_submit') }}", {

        method: "POST",

        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },

        body: formData

    })

    .then(res => res.json())

    .then(data => {

        if (data.status === "otp_sent") {

            // Add user_id for OTP verification

            let hidden = document.createElement('input');

            hidden.type = 'hidden';

            hidden.id = 'otp_user_id';

            hidden.value = data.user_id;

            document.getElementById('otpBox').appendChild(hidden);



            // Show success message

            let msg = document.createElement('div');

            msg.className = "alert alert-success mt-3";

            msg.innerText = data.message;

            document.getElementById('otpBox').prepend(msg);



            // Animate: slide login left, show OTP box

            const loginForm = document.getElementById('loginForm');

            const otpBox = document.getElementById('otpBox');

            loginForm.style.transition = "transform 0.5s ease, opacity 0.5s ease";

            loginForm.style.transform = "translateX(-100%)";

            loginForm.style.opacity = 0;



            setTimeout(() => {

                loginForm.style.display = "none";

                otpBox.style.display = "block";
                
                startOtpTimer();

                otpBox.style.opacity = 0;

                otpBox.style.transform = "translateX(100%)";

                setTimeout(() => {

                    otpBox.style.transition = "transform 0.5s ease, opacity 0.5s ease";

                    otpBox.style.transform = "translateX(0)";

                    otpBox.style.opacity = 1;

                }, 50);

            }, 500);

        } else if (data.error) {

            alert(data.error);

        }

    })

    .catch(err => console.error(err));

});






// resend otp

let countdown = 30;
let timer;

function startOtpTimer()
{
    countdown = 30;

    document.getElementById("otpTimer").style.display = "inline";
    document.getElementById("resendOtp").style.display = "none";

    document.getElementById("countdown").innerHTML = countdown;

    clearInterval(timer);

    timer = setInterval(function(){

        countdown--;

        document.getElementById("countdown").innerHTML = countdown;

        if(countdown <= 0){

            clearInterval(timer);

            document.getElementById("otpTimer").style.display = "none";
            document.getElementById("resendOtp").style.display = "inline";

        }

    },1000);

}

// resend otp end


    // Verify OTP

    document.getElementById('verifyOtpBtn').addEventListener('click', function () {

    let otpInputs = document.querySelectorAll('.otp-input');

    let otp = Array.from(otpInputs).map(i => i.value).join('');

    let userId = document.getElementById('otp_user_id').value;

    let messageBox = document.getElementById('otpMessage');



    // Clear previous messages

    messageBox.innerHTML = "";



    // ✅ Validation before sending

    if (otp.length < otpInputs.length) {

        messageBox.innerHTML = `<div class="text-danger">Please enter the full OTP.</div>`;

        return;

    }



    // Show loader

    document.getElementById('otpLoader').style.display = "block";

    document.getElementById('verifyOtpBtn').disabled = true;



    fetch("{{ route('user.verify_otp') }}", {

        method: "POST",

        headers: {

            "X-CSRF-TOKEN": "{{ csrf_token() }}",

            "Content-Type": "application/json"

        },

        body: JSON.stringify({ user_id: userId, otp: otp })

    })

    .then(res => res.json())

    .then(data => {

        if (data.success) {

            messageBox.innerHTML = `<div class="text-success">${data.success}</div>`;

            setTimeout(() => {

                window.location.href = data.redirect;

            }, 1000);

        } else if (data.error) {

            messageBox.innerHTML = `<div class="text-danger">${data.error}</div>`;

        } else {

            messageBox.innerHTML = `<div class="text-danger">Invalid response from server.</div>`;

        }

    })

    .catch(err => {

        console.error(err);

        messageBox.innerHTML = `<div class="text-danger">Server error. Please try again.</div>`;

    })

    .finally(() => {

        // Hide loader & enable button

        document.getElementById('otpLoader').style.display = "none";

        document.getElementById('verifyOtpBtn').disabled = false;

    });

});



    // OTP Input Auto Focus (your same code)

    const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {

        input.addEventListener('input', () => {

            if (input.value.length === 1 && index < otpInputs.length - 1) {

                otpInputs[index + 1].focus();

            }

        });

        input.addEventListener('keydown', (e) => {

            if (e.key === 'Backspace' && input.value === '' && index > 0) {

                otpInputs[index - 1].focus();

            }

        });

    });
    
    
    
    //  resend otp route 
    
    document.getElementById("resendOtp").addEventListener("click",function(){

    let userId = document.getElementById("otp_user_id").value;

    fetch("{{ route('user.resend_otp') }}",{

        method:"POST",

        headers:{
            "X-CSRF-TOKEN":"{{ csrf_token() }}",
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            user_id:userId
        })

    })

    .then(res=>res.json())

    .then(data=>{

        if(data.success){

            document.getElementById("otpMessage").innerHTML =
                `<div class="text-success">${data.success}</div>`;

            startOtpTimer();

        }else{

            document.getElementById("otpMessage").innerHTML =
                `<div class="text-danger">${data.error}</div>`;

        }

    })

    .catch(function(){

        document.getElementById("otpMessage").innerHTML =
            `<div class="text-danger">Unable to resend OTP.</div>`;

    });

});
 
 

</script>



<!-- Authentication-area end -->

@endsection