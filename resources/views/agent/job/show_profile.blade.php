@extends('agent.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-4">
                    <!-- Profile Image -->
                    <div class="mb-3">
                        <img src="{{ $user->profile_image ?? asset('default.png') }}" 
                             alt="{{ @$user->name }}" 
                             class="rounded-circle shadow" 
                             width="120" height="120">
                    </div>
                    
                    <!-- Name and Role -->
                    <h4 class="fw-bold mb-1">{{ @$user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->username }}</p>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <!-- Extra Details -->
                    <div class="d-flex justify-content-around text-start mt-4">
                        <div>
                            <h6 class="text-muted">Phone</h6>
                            <p class="fw-semibold">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <h6 class="text-muted">Location</h6>
                            <p class="fw-semibold">{{ $user->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around text-start mt-4">
                        <div>
                            <h6 class="text-muted">Country</h6>
                            <p class="fw-semibold">{{ $user->country ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h6 class="text-muted">City</h6>
                            <p class="fw-semibold">{{ $user->city ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around text-start mt-4">
                        <div>
                            <h6 class="text-muted">State</h6>
                            <p class="fw-semibold">{{ $user->state ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h6 class="text-muted">Zip Code</h6>
                            <p class="fw-semibold">{{ $user->zip_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around text-start mt-4">
                        <div>
                            <h6 class="text-muted">Address</h6>
                            <p class="fw-semibold">{{ $user->address ?? 'N/A' }}</p>
                        </div>
                        
                    </div>
                    

                    <!-- Action Buttons -->
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


