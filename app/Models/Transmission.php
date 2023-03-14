<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($transmission) {
            $transmission->uuid = Str::uuid();
        });

    }


}
