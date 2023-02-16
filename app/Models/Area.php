<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ['name'];
    protected $guarded = [];
    protected $appends = ['name_text'];

    public function getNameTextAttribute()
    {
        return @$this->name;
    }
}
