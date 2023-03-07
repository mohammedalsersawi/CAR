<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class Deals extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $guarded = [];
    protected $appends = ['user_name','image','discount_store_type'];
    protected $hidden=[
        'user',
        'updated_at',
        'updated_at',
        'imageDeal',
        'user_id'
    ];

    public function getUserNameAttribute()
    {
        return @$this->user->name;
    }
    public function getDiscountStoreTypeAttribute()
    {
        return @$this->user->Discount_Type->name;
    }
    public function imageDeal()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function getImageAttribute()
    {
        return url()->previous(). '/uploads/'.@$this->imageDeal->filename;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($deal) {
            $deal->uuid = Str::uuid();
        });

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleted(function ($deal) {
            File::delete(public_path('uploads/'.$deal->imageDeal->filename));
            $deal->imageDeal()->delete();
        });
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
