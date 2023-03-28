<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_admins', 'admin_uuid','role_uuid');
    }

    public function hasAbility($ability)
    {
        $denied = $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ablity', $ability)
                ->where('type', '=', '1');
        })->exists();

        if ($denied) {
            return true;
        }


    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->uuid = Str::uuid();
        });

    }
}
