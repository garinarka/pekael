<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    protected $fillable = [
        'classroom_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'address',
    ];

    protected $casts = [
        'classroom_id' => 'integer',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
