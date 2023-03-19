<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $guarded=[];
    protected $appends=[
        'type_attachment'
    ];
    const IMAGE = 1;
    const VIDEO = 2;
    public function getTypeAttachmentAttribute()
    {
        if ($this->type==2){
            return  'video';
        }else{
            return  'image';

        }
    }
    public function imageable()
    {
        return $this->morphTo();
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($image) {
            $image->uuid = Str::uuid();
        });

    }
}
