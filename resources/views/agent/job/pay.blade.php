@extends('agent.layout')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Pay for Job</h4>
        </div>
        <div class="card-body">
            <p>Job Amount: <strong>{{ $jobApplication->expected_salary ?? 'N/A' }}</strong></p>
            <p>Platform Fee (20%): <strong>{{ isset($jobApplication->expected_salary) ? number_format($jobApplication->expected_salary * 0.2, 2) : 'N/A' }}</strong></p>
            <p>Amount to Show Agent (80%): <strong>{{ isset($jobApplication->expected_salary) ? number_format($jobApplication->expected_salary * 0.8, 2) : 'N/A' }}</strong></p>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form id="agent-job-pay-form" method="POST" action="{{ route('agent.job_management.payment.success') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="job_id" value="{{ $jobApplication->id }}">
                <div class="form-group">
                    <label for="payment_method">Select Payment Method</label>
                    <select name="payment_method" class="form-control input-solid" id="payment-gateway" required>
                        <option value="" disabled selected>{{ __('Select a Payment Method') }}</option>
                        @foreach ($payment_methods as $payment_method)
                            <option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="instructions" class="text-left"></div>
                <input type="hidden" name="is_receipt" value="0" id="is_receipt">

                <div id="stripe-element" class="d-none">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <div id="stripe-errors" class="pb-2 text-danger text-left" role="alert"></div>

                <div class="row gateway-details pt-3" id="tab-anet" style="display: none;">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input class="form-control" type="text" id="anetCardNumber" placeholder="Card Number" disabled />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <input class="form-control" type="text" id="anetExpMonth" placeholder="Expire Month" disabled />
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="form-group">
                            <input class="form-control" type="text" id="anetExpYear" placeholder="Expire Year" disabled />
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="form-group">
                            <input class="form-control" type="text" id="anetCardCode" placeholder="Card Code" disabled />
                        </div>
                    </div>
                    <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" disabled />
                    <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" disabled />
                    <ul id="anetErrors" style="display: none;"></ul>
                </div>

                <button type="submit" class="btn btn-primary">Pay Now</button>
            </form>
@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    "use strict";
    $(document).ready(function() {
        let offline = @json($offline ?? []);
        let data = [];
        offline.map(({ id, name }) => { data.push(name); });
        let stripe = null;
        let card = null;
        let stripeKey = "{{ config('services.stripe.key') }}";
    var processPayUrl = "{{ route('agent.job_management.pay.process', $jobApplication->id) }}";
    var paymentSuccessUrl = "{{ route('agent.job_management.payment.success') }}";
    $("#payment-gateway").on('change', function() {
            let paymentMethod = $("#payment-gateway").val();
            $(".gateway-details").hide();
            $(".gateway-details input").attr('disabled', true);
            if (paymentMethod == 'Stripe') {
                $('#agent-job-pay-form').attr('action', processPayUrl);
                $('#stripe-element').removeClass('d-none');
                if (!stripe) {
                    stripe = Stripe(stripeKey);
                    let elements = stripe.elements();
                    card = elements.create('card');
                    card.mount('#stripe-element');
                }
            } else {
                $('#agent-job-pay-form').attr('action', paymentSuccessUrl);
                $('#stripe-element').addClass('d-none');
            }
            if (paymentMethod == 'Authorize.net') {
                $("#tab-anet").show();
                $("#tab-anet input").removeAttr('disabled');
            }
            if (data.indexOf(paymentMethod) != -1) {
                let formData = new FormData();
                formData.append('name', paymentMethod);
                $.ajax({
                    url: '{{ route('vendor.payment.instructions') }}',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST', contentType: false, processData: false, cache: false, data: formData,
                    success: function(data) {
                        let instruction = $("#instructions");
                        let instructions = `<div class="gateway-desc">${data.instructions}</div>`;
                        var description = data.description != null ? `<div class="gateway-desc"><p>${data.description}</p></div>` : `<div></div>`;
                        let receipt = `<div class="form-element mb-2"><label>Receipt<span>*</span></label><br><input type="file" name="receipt" value="" class="file-input" required><p class="mb-0 text-warning">** Receipt image must be .jpg / .jpeg / .png</p></div>`;
                        if (data.has_attachment == 1) {
                            $("#is_receipt").val(1);
                            let finalInstruction = instructions + description + receipt;
                            instruction.html(finalInstruction);
                        } else {
                            $("#is_receipt").val(0);
                            let finalInstruction = instructions + description;
                            instruction.html(finalInstruction);
                        }
                        $('#instructions').fadeIn();
                    },
                    error: function(data) {}
                })
            } else {
                $('#instructions').fadeOut();
            }
        });

        // Stripe form submission
        $('#agent-job-pay-form').on('submit', function(e) {
            if ($('#payment-gateway').val() === 'Stripe') {
                e.preventDefault();
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        $('#stripe-errors').text(result.error.message);
                    } else {
                        $('#stripe-errors').text('');
                        // Append token to form and submit
                        $('<input>').attr({type: 'hidden', name: 'stripeToken', value: result.token.id}).appendTo('#agent-job-pay-form');
                        $('#agent-job-pay-form')[0].submit();
                    }
                });
            }
        });
    });
</script>
@endsection
        </div>
    </div>
</div>
@endsection
