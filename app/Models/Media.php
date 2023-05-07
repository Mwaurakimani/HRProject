<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsToMany(User::class, 'media_owners', 'media_id', 'user_id')->withPivot('id');
    }
}
