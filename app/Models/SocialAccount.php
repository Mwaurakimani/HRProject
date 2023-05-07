<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id','id');
    }

    public function influencerClass(){
        return $this->belongsTo(InfluencerClass::class,'influencer_class_id','id');
    }
}
