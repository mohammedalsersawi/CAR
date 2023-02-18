<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    protected $appends=['Name'];
    protected $fillable = [
        'name_ar',
        'name_en',
    ];
    public function getNameAttribute()
    {
        return (app()->currentLocale()=='ar')?@$this->name_ar:@$this->name_en;

    }
}
