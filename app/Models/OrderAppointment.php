<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OrderAppointment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'uuid';
    protected $hidden=[
        'city_uuid',
        'area_uuid',
        'updated_at',
        'created_at',
        'user_uuid',
        'user',
        'city',
        'area',
    ];
    public $incrementing = false;
    protected $appends = ['area_name', 'city_name', 'photographer','status_appointment'];

    const image=1;
    const imagevideo=2;
    const accept='accept';
    const pending='pending';
    const complete='complete';
    public static function boot()
    {
        parent::boot();
        self::creating(function ($photographer) {
            $photographer->uuid = Str::uuid();
        });
    }

    public const TYPES = [
        1 => 'image',
        2 => 'imageVideo',
    ];
    public function photographer()
    {
        return $this->belongsTo(User::class, 'photographer_uuid');
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
    public function getStatusAppointmentAttribute()
    {
        if ($this->status == 'pending' ) {
            return (app()->currentLocale() == 'ar') ? 'معلق' : 'pending';
        } elseif ($this->status == 'accept') {
            return (app()->currentLocale() == 'ar') ? 'تم القبول' : 'accept';
        } else {
            return (app()->currentLocale() == 'ar') ? 'مكمل' : 'complete';
        }
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }
    public function getPhotographerAttribute()
    {
        return @$this->photographer->name;
    }
}
