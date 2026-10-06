@extends('backend.layout')



@includeIf('backend.partials.rtl-style')



@section('content')

<div class="container-fluid">

    <div class="card mt-4">

        <div class="card-header">

            <h4>Job Payments</h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>S No.</th>

                        <!-- <th>Job Application</th> -->

                        <th>Agent</th>

                        <th>Show Agent</th>

                        <th>Amount</th>

                        <th>Platform Fee</th>

                        <th>Show Agent Amount</th>

                        <th>Payment Method</th>

                        <th>Status</th>

                        <!-- <th>Transaction ID</th> -->

                        <th>Details</th>

                        <!-- <th>Date</th> -->

                    </tr>

                </thead>

                <tbody>

                    @php

                    $index = 1;

                    @endphp

                    @foreach($jobPayments as $payment)

                    <tr>

                        <td>{{ $index++ }}</td>

                        <!-- <td>{{ $payment->job_application_id }}</td> -->

                        <td>{{ optional($payment->agent)->username ?? '-' }}</td>

                        <td>{{ optional($payment->showAgent)->name ?? '-' }}</td>

                        <td>{{ $payment->amount }}</td>

                        <td>{{ $payment->platform_fee }}</td>

                        <td>{{ $payment->show_agent_amount }}</td>

                        <td>{{ $payment->payment_method }}</td>

                        <td>

                            @if($payment->status == 'succeeded' || $payment->status == 'approved')

                            <span class="badge badge-success">Success</span>

                            @elseif($payment->status == 'pending')

                            <span class="badge badge-warning">Pending</span>

                            @else

                            <span class="badge badge-danger">{{ ucfirst($payment->status) }}</span>

                            @endif

                        </td>

                        <!-- <td>{{ $payment->transaction_id }}</td> -->

                        <td>

                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal{{ $payment->id }}">Details</button>

                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showAgentModal{{ $payment->id }}">Show Agent</button>

                            <!-- Transaction Details Modal -->

                            <div class="modal fade" id="detailsModal{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $payment->id }}" aria-hidden="true">

                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title" id="detailsModalLabel{{ $payment->id }}">Transaction Details</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                <span aria-hidden="true">&times;</span>

                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <pre>{{ json_encode(json_decode($payment->transaction_details), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Show Agent Details Modal -->

                            <div class="modal fade" id="showAgentModal{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="showAgentModalLabel{{ $payment->id }}" aria-hidden="true">

                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title" id="showAgentModalLabel{{ $payment->id }}">Show Agent Details</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                <span aria-hidden="true">&times;</span>

                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            @if($payment->showAgent)

                                            <ul class="list-group">

                                                <li class="list-group-item"><strong>Name:</strong> {{ $payment->showAgent->name ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Email:</strong> {{ $payment->showAgent->email ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Account Holder Name:</strong> {{ $payment->showAgent->account_holder_name ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Bank Name:</strong> {{ $payment->showAgent->bank_name ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Institution Number:</strong> {{ $payment->showAgent->institution_number ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Transit Number:</strong> {{ $payment->showAgent->transit_number ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Account Number:</strong> {{ $payment->showAgent->account_number ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Routing Number:</strong> {{ $payment->showAgent->routing_number ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Swift Code:</strong> {{ $payment->showAgent->swift_code ?? '-' }}</li>

                                                <li class="list-group-item"><strong>Bank KYC:</strong> {{ $payment->showAgent->is_bank_kyc == 1 ? 'Verified' : 'Not Verified' }}</li>

                                                <!-- Add more fields as needed -->

                                            </ul>

                                            @else

                                            <p>No show agent details found.</p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </td>

                        <!-- <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td> -->

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="d-flex justify-content-center">

                {{ $jobPayments->links() }}

            </div>

        </div>

    </div>

</div>

@endsection