<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Agent(): BelongsTo
    {
        return $this->belongsTo(User::class,'agent_id','id');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
