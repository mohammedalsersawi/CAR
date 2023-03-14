<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $appends = ['area_name','city_name','type_name','image_user','DiscountStoreType'];
    protected $fillable = [
        'phone',
        'password',
        'about',
        'code',
        'city_uuid',
        'area_uuid',
        'user_type_id',
        'lat',
        'lng',
        'discount_type_uuid',
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
        'city_uuid',
        'area_uuid',
        'discount_type_uuid',
        'code',
        'image',
        'city',
        'area',
        'type',
        'user_type_id',
        'created_at',
        'updated_at'
    ];

    const SHOWROOM = 1;
    const DISCOUNT_STORE = 2;
    const PHOTOGRAPHER = 3;
    const USER = 4;
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
    public function cars(){
        return @$this->hasMany(Car::class);
    }
    public function deals(){
        if ($this->user_type_uuid==User::DISCOUNT_STORE){
            return @$this->hasMany(Deals::class);
        }else{
            return 'sorry';
        }
    }
    public function photographer(){
        if ($this->user_type_uuid==User::PHOTOGRAPHER){
            return $this->hasMany(Photographer::class);
        }else{
            return 'sorry';
        }
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function Discount_Type(){
        return @$this->belongsTo(Type::class,'discount_type_uuid');

    }
    public function getDiscountStoreTypeAttribute()
    {
        return @$this->Discount_Type->name;
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
    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->uuid = Str::uuid();
        });

    }

}
