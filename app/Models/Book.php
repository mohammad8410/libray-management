<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'authors'     => 'array',
        'translators' => 'array',
    ];

    protected $fillable = [
        'isbn',
        'name',
        'maximumTime',
        'year',
        'authors',
        'translators',
        'volume',
        'pages',
        'price',
        'number',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
