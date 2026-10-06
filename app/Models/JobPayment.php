<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'agent_id',
        'show_agent_id',
        'amount',
        'platform_fee',
        'show_agent_amount',
        'payment_method',
        'transaction_id',
        'status',
        'transaction_details',
    ];

     public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class, 'agent_id');
    }

    public function showAgent()
    {
        return $this->belongsTo(\App\Models\User::class, 'show_agent_id');
    }
    
}
