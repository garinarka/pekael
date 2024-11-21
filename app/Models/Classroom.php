<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classroom extends Model
{
    protected $fillable = [
        'level',
        'department',
        'paralel',
        'name',
    ];

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
