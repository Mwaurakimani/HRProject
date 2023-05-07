<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function projectRequirements()
    {
        return $this->hasMany(ProjectRequirements::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(
            Platform::class,
            'project_requirements',
            'project_id','platform_id')->withPivot(
                'influencer_classes_id');
    }

    public function bids(){
        return $this->hasMany(Bid::class);
    }

    public function marketer(){
        return $this->belongsTo(Marketer::class);
    }

}
