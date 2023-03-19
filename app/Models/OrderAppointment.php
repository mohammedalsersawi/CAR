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
        'user_id',
        'user',
        'city',
        'area',
        'status',
        'type',
        'photographer_uuid',
        'photographer'
    ];
    public $incrementing = false;
    protected $appends = ['area_name', 'city_name', 'photographer_name','status_appointment','type_media'];

    const image=1;
    const imagevideo=2;
    const accept=2;
    const pending=1;
    const complete=3;
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
        if ($this->status == 1 ) {
            return (app()->currentLocale() == 'ar') ? 'معلق' : 'pending';
        } elseif ($this->status == 2) {
            return (app()->currentLocale() == 'ar') ? 'تم القبول' : 'accept';
        } else {
            return (app()->currentLocale() === 'ar') ? 'مكتمل' : 'complete';
        }
    }
    public function getTypeMediaAttribute()
    {
        if ($this->type == 1 ) {
            return (app()->currentLocale() == 'ar') ? 'صورة' : 'image';
        }else {
            return (app()->currentLocale() === 'ar') ? 'صورة+فيديو' : 'image+vedio';
        }
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }
    public function getPhotographerNameAttribute()
    {
        return @$this->photographer->name;
    }
}
