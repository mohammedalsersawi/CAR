<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specification extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=[
        'car_uuid'
    ];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($specification) {
            $specification->uuid = Str::uuid();
        });

    }
}
