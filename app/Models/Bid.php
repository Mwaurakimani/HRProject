<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function influencer(){
        return $this->belongsTo(Influencer::class);
    }

    public function assignments(){
        return $this->hasOne(Assignment::class);
    }

    public function media(){
        return $this->hasManyThrough(Media::class,Assignment::class);
    }
}
