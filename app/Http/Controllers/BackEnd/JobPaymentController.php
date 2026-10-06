<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\JobPayment;
use App\Models\Language;


class JobPaymentController extends Controller
{
    public function index()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['language'] = $currentLang;
        $data['jobPayments'] = JobPayment::with(['agent', 'showAgent'])->orderBy('id', 'desc')->paginate(20);
        // return view('backend.job_payment.index', compact('data'));
        return view('backend.job_payment.index', $data);
    }
}
