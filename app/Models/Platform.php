<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function influencerClass(){
        return $this->hasOne(InfluencerClass::class);
    }

    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }
}
