<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequirements extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function platform(){
        return $this->belongsTo(Platform::class);
    }

    public function influencerClass(){
        return $this->belongsTo(InfluencerClass::class);
    }
}
