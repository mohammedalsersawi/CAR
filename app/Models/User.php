<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasTranslations,HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $translatable = ['about'];
    protected $appends = ['name_about','name_area','name_city','name_type'];
    protected $fillable = [
        'phone',
        'password',
        'number',
        'about',
        'city_id',
        'area_id',
        'user_type_id',
        'lat',
        'lng'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'about',
        'city_id',
        'area_id',
        'user_type_id',
        'city',
        'area',
        'type'
    ];
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
        return @$this->morphOne(Image::class, 'imageable');
    }
    public function getNameAboutAttribute()
    {
        return @$this->about;
    }
    public function getNameCityAttribute()
    {
        return @$this->city->name;
    }
    public function getNameAreaAttribute()
    {
        return @$this->area->name;
    }
    public function getNameTextAttribute()
    {
        return @$this->name;
    }
    public function getNameTypeAttribute()
    {
        return @$this->type->Name;
    }
//    public function getAboutAttribute()
//{
//    return @$this->about;
//}

//    public function getTypeAttribute()
//    {
//        return @$this->type->name_en;
//    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    protected static function booted()
    {
        self::deleted(function ($user) {
            File::delete(public_path('uploads/'.$user->image->filename));
            $user->image()->delete();
        });

    }


}
