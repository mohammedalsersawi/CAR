<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photographer extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function imagephotographer()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function videophotographer()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
