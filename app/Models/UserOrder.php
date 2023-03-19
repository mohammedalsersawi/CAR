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
    protected $appends = ['area_name', 'city_name',  'status_type'];
    protected $primaryKey = 'uuid';
    protected $hidden = [
        'city_uuid',
        'area_uuid',
        'area',
        'city',
        'user',
        'created_at',
        'updated_at',

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
        return $this->belongsTo(User::class, 'user_uuid');
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

    public function getStatusTypeAttribute()
    {
        if ($this->status === 2) {
            return (app()->currentLocale() == 'ar') ? 'تم الرفض' : 'rejected';

        } elseif ($this->status == 1) {
            return (app()->currentLocale() == 'ar') ? 'تم القبول' : 'accepted';
        } else {
            return (app()->currentLocale() == 'ar') ? 'معلق' : 'pending';        }
    }
}
