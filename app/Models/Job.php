<?php

namespace App\Models;
    
use App\Models\Property\Property;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $guarded = [];

   
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }
}
