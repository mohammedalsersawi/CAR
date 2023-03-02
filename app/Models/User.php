<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasTranslations,HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $translatable = ['about'];
    protected $appends = ['about_name','area_name','city_name','type_name','image_user','DiscountStoreType'];
    protected $fillable = [
        'phone',
        'password',
//        'number',
        'about',
        'code',
        'city_id',
        'area_id',
        'user_type_id',
        'lat',
        'lng',
        'type_id',
        'name',
        'verification'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'city_id',
        'area_id',
        'type_id',
        'code',
        'image',
        'city',
        'area',
        'type',
        'user_type_id',
        'created_at',
        'updated_at'
    ];
    const USER = 1;
    const SHOWROOM = 2;
    const DISCOUNT_STORE = 3;
    const PHOTOGRAPHER = 4;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function type(){
        return @$this->belongsTo(UserType::class,'user_type_id');
    }
    public function city(){
        return @$this->belongsTo(City::class);
    }
    public function area(){
        return @$this->belongsTo(Area::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function Discount_Type(){
        return @$this->belongsTo(Type::class,'type_id');

    }
    public function getDiscountStoreTypeAttribute()
    {
        return @$this->Discount_Type->name;
    }
    public function getAboutNameAttribute()
    {
        return @$this->about;
    }
    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }
    public function getTypeNameAttribute()
    {
        return @$this->type->Name;
    }
    public function getImageUserAttribute()
    {
        return url()->previous(). '/uploads/'. @$this->image->filename;
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    protected static function booted()
    {
        self::deleted(function ($user) {
            File::delete(public_path('uploads/'.@$user->image->filename));
            $user->image()->delete();
        });

    }


}
