<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = false;
    protected $appends = ['area_name', 'city_name', 'user_name', 'status_type'];
    protected $primaryKey = 'uuid';
    protected $hidden = [
        'city_id',
        'area_id',


    ];
    const rejected = 2;
    const accepted = 1;
    const pending = 3;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($rpw) {
            $rpw->uuid = Str::uuid();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function city()
    {
        return @$this->belongsTo(City::class);
    }
    public function area()
    {
        return @$this->belongsTo(Area::class);
    }
    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }
    public function getUserNameAttribute()
    {
        return @$this->user->name;
    }
    public function getStatusTypeAttribute()
    {
        if ($this->status == 3) {
            return (app()->currentLocale() == 'ar') ? 'معلق' : 'pending';
        } elseif ($this->status == 1) {
            return (app()->currentLocale() == 'ar') ? 'تم القبول' : 'accepted';
        } else {
            return (app()->currentLocale() == 'ar') ? 'تم الرفض' : 'rejected';
        }
    }
}
