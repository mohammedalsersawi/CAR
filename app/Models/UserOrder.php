<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['area_name','city_name'];
    protected $primaryKey = 'uuid';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($rpw) {
            $rpw->uuid = Str::uuid();
        });
    }

    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }

}
