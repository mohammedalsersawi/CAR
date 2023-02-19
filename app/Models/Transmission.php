<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Transmission extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];
    protected $appends = ['name_text'];
    protected $fillable = [
        'name',
    ];
    public function getNameTextAttribute()
    {
        return @$this->name;
    }

}
