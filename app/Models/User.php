<?php

namespace App\Models;

use App\Support\Traits\HasEloquentAnnotations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User wherePassword($value)
 */

class User extends Authenticatable
{
    use HasEloquentAnnotations;
    use HasFactory;
    use HasApiTokens;
    use HasUlids;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->name = substr($user->email, 0, strpos($user->email, '@'));
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
