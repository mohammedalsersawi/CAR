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

    protected $translatable = ['name','about'];
    protected $appends = ['about_name','area_name','city_name','type_name','text_name'];
    protected $fillable = [
        'phone',
        'password',
//        'number',
        'about',
        'city_id',
        'area_id',
        'user_type_id',
        'lat',
        'lng',
        'name'
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

        'city',
        'area',
        'type',
        'created_at',
        'updated_at'
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
    public function getTextNameAttribute()
    {
        return @$this->name;
    }
    public function getTypeNameAttribute()
    {
        return @$this->type->Name;
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
