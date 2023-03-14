<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Engine extends Model
{
    use HasFactory,
        HasTranslations;
    protected $translatable = ['name'];
    protected $guarded = [];
    protected $appends = ['name_text'];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public function getNameTextAttribute()
    {
        return @$this->name;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($engine) {
            $engine->uuid = Str::uuid();
        });
    }
}
