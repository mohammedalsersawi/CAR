<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserType extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $appends=['Name'];
    protected $fillable = [
        'name_ar',
        'name_en',
    ];
    public function getNameAttribute()
    {
        return (app()->currentLocale()=='ar')?@$this->name_ar:@$this->name_en;

    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($usertype) {
            $usertype->uuid = Str::uuid();
        });

    }
}
