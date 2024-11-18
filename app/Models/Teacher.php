<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'classroom_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'address',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'classroom_id' => 'integer',
        ];
    }

    protected static function booted()
    {
        static::created(function ($teacher) {
            $fullName = trim("{$teacher->first_name} {$teacher->middle_name} {$teacher->last_name}");

            do {
                $randomNumber = rand(1000, 9999);
                $email = strtolower($teacher->first_name) . $randomNumber . '@guru.stemoneska.com';
            } while (User::where('email', $email)->exists());

            $randomPassword = 'stemsa' . rand(100000, 999999);

            User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => bcrypt($randomPassword),
                'role' => 'teacher',
            ]);

            Log::channel('user_credentials')->info("Generated credentials for {$email}: {$randomPassword}");
        });
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
