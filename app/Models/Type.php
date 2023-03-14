<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use HasFactory,HasTranslations;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $translatable = ['name'];
    protected $appends=['text_name'];
   protected $guarded=[];
    protected $hidden=[
        'name'
    ];
    public function users(){
        return $this->hasMany(User::class,'discount_type_uuid')->select('uuid');
    }


    public function getTextNameAttribute()
    {
        return $this->name;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($discount_type) {
            $discount_type->uuid = Str::uuid();
        });

    }

}
