<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserScores extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
