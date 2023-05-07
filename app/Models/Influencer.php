<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function accounts(){
        return $this->hasMany(SocialAccount::class);
    }

    public function platform(){
        return $this->hasOneThrough(Platform::class,SocialAccount::class,'influencer_id','platform_id','id','id');
    }

    public function bids(){
        return $this->hasMany(Bid::class);
    }

    public function projects(){
        return $this->belongsToMany(
            Project::class,
            'bids',
            'influencer_id','project_id')->withPivot(
                'bid_amount',
                'description',
                'status');
    }
}
