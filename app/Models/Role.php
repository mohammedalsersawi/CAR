<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $guarded=[];
    public function abilities()
    {
        return $this->hasMany(RoleAblity::class);
    }
    public static function createWithAbilities(Request $request){
        DB::beginTransaction();
        try {
            $role = Role::create(
                [
                    'name' => $request->name
                ]
            );
            foreach ($request->post('abilities') as $ability=> $value) {
                RoleAblity::create([
                    'role_uuid' => $role->uuid,
                    'ablity' => $ability,
                    'type' => $value
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $role;
    }

    public function updateWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability => $value) {
                RoleAblity::updateOrCreate([
                    'role_uuid' => $this->uuid,
                    'ablity' => $ability,
                ], [
                    'type' => $value,
                ]);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($item) {
            $item->uuid = Str::uuid();
        });
    }
}
