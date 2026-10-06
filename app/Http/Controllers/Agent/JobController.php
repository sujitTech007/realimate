<?php

namespace App\Http\Controllers\Agent;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Property\Property;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    
    public function index()
    {    
        $language = Language::where('is_default', 1)->first();
        $languages = Language::get();
        $jobs = Job::where('agent_id', Auth::guard('agent')->user()->id)->paginate(10);
        return view('agent.job.index', compact('jobs', 'languages', 'language'));
    }

    public function jobRequest($id)
    {    
        $language = Language::where('is_default', 1)->first();
        $languages = Language::get();
        $jobs = Job::where('agent_id', Auth::guard('agent')->user()->id)->paginate(10);
        $jobApplications = JobApplication::where('job_id', $id)->paginate(10);
        return view('agent.job.job-request', compact('jobs', 'languages', 'language', 'jobApplications'));
    }

    public function create()
    {   
        $language = Language::where('is_default', 1)->first();
        $languages = Language::get();
        $properties = Property::where('agent_id', Auth::guard('agent')->user()->id)->with(['propertyContents' => function ($q) use ($language) {
            $q->where('language_id', $language->id);
        }])->get();
        return view('agent.job.create', compact('properties', 'languages', 'language'));
    }

    public function store(Request $request)
    {
        $job = Job::create([
            // 'agent_id' => Auth::guard('agent')->user()->id,
            'agent_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary' => $request->salary,
            'commission_amount' => $request->salary * 0.20,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $job->update([
            'job_id' => 'RM00' . $job->id
        ]);
        // return view('agent.job.store', compact('job'));
        return redirect()->route('agent.job_management.jobs')->with('success', 'Job created successfully');
        return redirect()->route('agent.job_management.jobs')->with('error', 'Job creation failed');
    }

    public function edit($id)
    {
        $language = Language::where('is_default', 1)->first();
        $languages = Language::get();
        $properties = Property::where('agent_id', Auth::guard('agent')->user()->id)->with(['propertyContents' => function ($q) use ($language) {
            $q->where('language_id', $language->id);
        }])->get();
        $job = Job::find($id);
        return view('agent.job.edit', compact('job', 'languages', 'language', 'properties'));
    }
    
    public function update(Request $request, $id)
    {
       
        $job = Job::find($id);
        $job->update([
            // 'agent_id' => Auth::guard('agent')->user()->id,
            // 'agent_id' => $request->agent_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary' => $request->salary,
            'commission_amount' => $request->salary * 0.20,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('agent.job_management.jobs')->with('success', 'Job updated successfully');
        return redirect()->route('agent.job_management.jobs')->with('error', 'Job update failed');
    }

    public function updateStatus(Request $request)
    {
        $job = Job::findOrFail($request->jobId);

        if ($request->status == "open") {
            $job->update(['status' => "open"]);

            Session::flash('success', 'Job Open successfully!');
        } else {
            $job->update(['status' => "closed"]);

            Session::flash('success', 'Job Closed successfully!');
        }

        return redirect()->back();
    }

    public function updateApplicationStatus(Request $request)
    {
        $jobApplication = JobApplication::findOrFail($request->jobId);
    
        // update with the selected status
        $jobApplication->update([
            'status' => $request->status
        ]);
    
        // Flash message according to status
        $message = match ($request->status) {
            'applied'     => 'Status updated to Applied successfully!',
            'shortlisted' => 'Candidate shortlisted successfully!',
            'hired'       => 'Candidate hired successfully!',
            'rejected'    => 'Candidate rejected successfully!',
            default       => 'Status updated successfully!',
        };
    
        Session::flash('success', $message);
    
        return redirect()->back();
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        $job->delete();
        return redirect()->route('agent.job_management.jobs')->with('success', 'Job deleted successfully');
        return redirect()->route('agent.job.index')->with('error', 'Job deletion failed');
    }

    public function show($id)
    {
        $job = Job::find($id);
        return view('agent.job.show', compact('job'));
    }

    public function applications($id)
    {
        $job = Job::find($id);
        return view('agent.job.applications', compact('job'));
    }

    public function applyJob(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'job_id'           => 'required|exists:jobs,id',
            'cover_letter'     => 'required|string|min:20|max:2000',
            'experience'       => 'required|numeric|min:0|max:50',
            'expected_salary'  => 'required|numeric|min:1000|max:10000000',
        ], [
            // ✅ Custom messages (optional)
            'job_id.required'          => 'Invalid job selection.',
            'job_id.exists'            => 'The selected job does not exist.',
            'cover_letter.required'    => 'Please write a cover letter.',
            'cover_letter.min'         => 'Cover letter must be at least 20 characters.',
            'experience.required'      => 'Please mention your experience in years.',
            'expected_salary.required' => 'Please enter your expected salary.',
        ]);

        // ✅ Check job status
        $job = Job::findOrFail($request->job_id);

        if ($job->status !== 'open') {
            return back()->with('error', 'This job is closed.');
        }

        // ✅ Store application
        JobApplication::create([
            'job_id'          => $job->id,
            'show_agent_id'   => auth()->id(),
            'cover_letter'    => $request->cover_letter,
            'experience'      => $request->experience,
            'expected_salary' => $request->expected_salary,
            'status'          => 'applied',
            'applied_at'      => now(),
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }


    public function showUserDetails($id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        // Ensure job application has valid user
        $user = User::find($jobApplication->show_agent_id);
        return view('agent.job.show_profile', compact('user')); 

    }

    // Payment initiation for job application
    public function pay($id)
    {
    $jobApplication = JobApplication::findOrFail($id);
    $payment_methods = \App\Models\PaymentGateway\OnlineGateway::where('status', 1)->get();
    $offline = \App\Models\PaymentGateway\OfflineGateway::where('status', 1)->get();
    return view('agent.job.pay', compact('jobApplication', 'payment_methods', 'offline'));
    }

     public function processPay(Request $request, $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $amount = $jobApplication->expected_salary;
        $platformFee = $amount * 0.2;
        $showAgentAmount = $amount * 0.8;
        $title = 'Job Payment';
        $description = 'Payment for job application.';
        $paymentMethod = $request->input('payment_method');
        $bs = \App\Models\BasicSettings\Basic::first();

        // Currency and gateway logic (mirroring VendorCheckoutController)
        if ($paymentMethod == 'PayPal') {
            if ($bs->base_currency_text !== 'USD') {
                $rate = floatval($bs->base_currency_rate);
                $amount = round(($amount / $rate), 2);
            }
            $paypal = new \App\Http\Controllers\Payment\PaypalController;
            $cancel_url = route('membership.paypal.cancel');
            $success_url = route('membership.paypal.success');
            return $paypal->paymentProcess($request, $amount, $title, $success_url, $cancel_url);
        } elseif ($paymentMethod == 'Stripe') {
            if ($bs->base_currency_text !== 'USD') {
                $rate = floatval($bs->base_currency_rate);
                $amount = round(($amount / $rate), 2);
            }
            $stripe = new \App\Http\Controllers\Payment\StripeController();
            $cancel_url = route('membership.stripe.cancel');
            return $stripe->paymentProcess($request, $amount, $title, null, $cancel_url);
        } elseif ($paymentMethod == 'Paytm') {
            if ($bs->base_currency_text != 'INR') {
                session()->flash('warning', 'Only INR is supported currency for Paytm');
                return back()->withInput($request->all());
            }
            $item_number = uniqid('paytm-') . time();
            $callback_url = route('membership.paytm.status');
            $paytm = new \App\Http\Controllers\Payment\PaytmController();
            return $paytm->paymentProcess($request, $amount, $item_number, $callback_url);
        } elseif ($paymentMethod == 'Paystack') {
            if ($bs->base_currency_text != "NGN") {
                session()->flash('warning', 'Only NGN is supported currency for Paystack');
                return back()->withInput($request->all());
            }
            $amountNaira = $amount * 100;
            $email = $request->email;
            $success_url = route('membership.paystack.success');
            $payStack = new \App\Http\Controllers\Payment\PaystackController();
            return $payStack->paymentProcess($request, $amountNaira, $email, $success_url, $bs);
        } elseif ($paymentMethod == 'Razorpay') {
            if ($bs->base_currency_text != "INR") {
                session()->flash('warning', $bs->base_currency_text . " is not allowed for Razorpay");
                return back()->with($request->all());
            }
            $item_number = uniqid('razorpay-') . time();
            $cancel_url = route('membership.razorpay.cancel');
            $success_url = route('membership.razorpay.success');
            $razorpay = new \App\Http\Controllers\Payment\RazorpayController();
            return $razorpay->paymentProcess($request, $amount, $item_number, $cancel_url, $success_url, $title, $description, $bs);
        } elseif ($paymentMethod == 'Instamojo') {
            if ($bs->base_currency_text != "INR") {
                session()->flash('warning', $bs->base_currency_text . " is not allowed for Instamojo");
                return back()->withInput($request->all());
            }
            if ($amount < 9) {
                return redirect()->back()->with('error', 'Minimum 10 INR required for this payment gateway')->withInput($request->all());
            }
            $success_url = route('membership.instamojo.success');
            $cancel_url = route('membership.instamojo.cancel');
            $instaMojo = new \App\Http\Controllers\Payment\InstamojoController();
            return $instaMojo->paymentProcess($request, $amount, $success_url, $cancel_url, $title, $bs);
        } elseif ($paymentMethod == 'MercadoPago') {
            if ($bs->base_currency_text != "BRL") {
                session()->flash('warning', $bs->base_currency_text . " is not allowed for MercadoPago");
                return back()->withInput($request->all());
            }
            $email = $request->email;
            $success_url = route('membership.mercadopago.success');
            $cancel_url = route('membership.mercadopago.cancel');
            $mercadopagoPayment = new \App\Http\Controllers\Payment\MercadopagoController();
            return $mercadopagoPayment->paymentProcess($request, $amount, $success_url, $cancel_url, $email, $title, $description, $bs);
        } elseif ($paymentMethod == 'Flutterwave') {
            $available_currency = array(
                'BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD'
            );
            if (!in_array($bs->base_currency_text, $available_currency)) {
                session()->flash('warning', $bs->base_currency_text . " is not allowed for Flutterwave.");
                return back()->withInput($request->all());
            }
            $email = $request->email;
            $item_number = uniqid('flutterwave-') . time();
            $cancel_url = route('membership.flutterwave.cancel');
            $success_url = route('membership.flutterwave.success');
            $flutterWave = new \App\Http\Controllers\Payment\FlutterWaveController();
            return $flutterWave->paymentProcess($request, $amount, $email, $item_number, $success_url, $cancel_url, $bs);
        } elseif ($paymentMethod == 'Authorize.net') {
            $available_currency = array('USD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'AUD', 'NZD');
            if (!in_array($bs->base_currency_text, $available_currency)) {
                session()->flash('warning', $bs->base_currency_text . " is not allowed for Authorize.net");
                return back()->withInput($request->all());
            }
            $success_url = route('membership.mollie.success');
            $cancel_url = route('membership.anet.cancel');
            $authorizePayment = new \App\Http\Controllers\Payment\AuthorizeController();
            return $authorizePayment->paymentProcess($request, $amount, $success_url, $cancel_url, $title, $bs);
        } else {
            return back()->with('error', 'Invalid payment method selected.');
        }
    }
    /**
     * Handle job payment success callback from payment gateways.
     * Save job payment record in job_payments table.
     */
    public function jobPaymentSuccess(Request $request)
    {
        // This handles direct POST from the agent pay form for offline/manual payments
        $job_application_id = $request->input('job_id');
        $payment_method = $request->input('payment_method');

        // Generate transaction_id if not provided (for offline/manual payments)
        $transaction_id = $request->input('transaction_id');
        if (empty($transaction_id)) {
            $transaction_id = \App\Http\Helpers\VendorPermissionHelper::uniqidReal(8);
        }
        $status = $request->input('status', 'pending');
        $transaction_details = $request->input('transaction_details');
        if (empty($transaction_details)) {
            $transaction_details = json_encode(['method' => $payment_method, 'type' => 'manual', 'created_at' => now()->toDateTimeString()]);
        }

        $jobApplication = \App\Models\JobApplication::findOrFail($job_application_id);
        $amount = $jobApplication->expected_salary;
        $platformFee = $amount * 0.2;
        $showAgentAmount = $amount * 0.8;

        $jobPayment = new \App\Models\JobPayment();
        $jobPayment->job_application_id = $job_application_id;
        $agent_id = Auth::guard('agent')->user()->id;
        $jobPayment->agent_id = $agent_id;
        $jobPayment->show_agent_id = $jobApplication->show_agent_id;
        $jobPayment->amount = $amount;
        $jobPayment->platform_fee = $platformFee;
        $jobPayment->show_agent_amount = $showAgentAmount;
        $jobPayment->payment_method = $payment_method;
        $jobPayment->transaction_id = $transaction_id;
        $jobPayment->status = $status;
        $jobPayment->transaction_details = $transaction_details;
        $jobPayment->save();

        return redirect()->back()->with('success', 'Job payment recorded successfully.');
    }

    /**
     * Save job payment after successful Stripe payment.
     */
    public function saveJobPaymentAfterStripe($job_application_id, $transaction_id, $payment_method, $status, $transaction_details)
    {
        $jobApplication = \App\Models\JobApplication::findOrFail($job_application_id);
        $amount = $jobApplication->expected_salary;
        $platformFee = $amount * 0.2;
        $showAgentAmount = $amount * 0.8;

        $jobPayment = new \App\Models\JobPayment();
        $jobPayment->job_application_id = $job_application_id;
        $agent_id = Auth::guard('agent')->user()->id;
        $jobPayment->agent_id = $agent_id;
        $jobPayment->show_agent_id = $jobApplication->show_agent_id;
        $jobPayment->amount = $amount;
        $jobPayment->platform_fee = $platformFee;
        $jobPayment->show_agent_amount = $showAgentAmount;
        $jobPayment->payment_method = $payment_method;
        $jobPayment->transaction_id = $transaction_id;
        $jobPayment->status = $status;
        $jobPayment->transaction_details = $transaction_details;
        $jobPayment->save();
    }

}
