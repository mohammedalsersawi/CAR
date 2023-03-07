<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Code_Deals extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $appends=['deals_name'];
protected $hidden=[
    'deals',
    'code',
];


    public function deals(){
        return @$this->belongsTo(deals::class);
    }

    public function getDealNameAttribute()
    {
        return @$this->deals->name;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($deal_code) {
            $deal_code->uuid = Str::uuid();
        });

    }
}
