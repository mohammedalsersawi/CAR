<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];
    protected $appends=['text_name'];
    protected $fillable = [
        'name',
        'deals'
    ];
    protected $hidden=[
        'name'
    ];
    public function users(){
        return $this->hasMany(User::class,'discount_type_id')->select('id');
    }


    public function getTextNameAttribute()
    {
        return $this->name;
    }

}
