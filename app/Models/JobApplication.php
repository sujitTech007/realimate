<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Agent;
use App\Models\JobApplication;
use App\Models\Property\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
    public function showAgent()
    {
        return $this->belongsTo(Agent::class, 'show_agent_id', 'id');
    }
    public function user()
    {
        // return $this->belongsTo(User::class, 'user_id', 'id');
        return $this->belongsTo(Agent::class, 'user_id', 'id');
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
    public function useragent()
    {
        return $this->belongsTo(User::class, 'show_agent_id');
    }
}
