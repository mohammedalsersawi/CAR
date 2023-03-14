<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Year extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($year) {
            $year->uuid = Str::uuid();
        });
    }


}
