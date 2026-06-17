<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate the next sequential username in the format USR00001.
     *
     * @return string
     */
    public static function generateNextUsername(): string
    {
        $lastUser = self::where('username', 'LIKE', 'PISCT%')
            ->orderBy('username', 'desc')
            ->first();

        if (!$lastUser) {
            return 'PISCT0001';
        }

        $lastNumber = (int) substr($lastUser->username, 5);
        $nextNumber = $lastNumber + 1;

        return 'PISCT' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
