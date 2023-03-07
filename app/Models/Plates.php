<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plates extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $guarded=[];
    protected $hidden=[
        'city',
        'city_id',
        'updated_at',
        'created_at'
    ];
    protected $appends = ['city_name'];

    public function city(){
        return @$this->belongsTo(City::class);
    }

    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($photographer) {
            $photographer->uuid = Str::uuid();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getUserNameAttribute()
    {
        return @$this->user->name;
    }
}
