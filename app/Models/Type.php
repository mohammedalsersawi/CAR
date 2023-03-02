<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];
    protected $fillable = [
        'name',
    ];
    protected $appends=['text_name'];
    public function getTextNameAttribute()
    {
        return $this->name;
    }

}
