<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();




        UserType::create([
                'name_en'=> 'gest',
                'name_ar'=>'ضيف'
        ]);
        UserType::create([
            'name_en'=> 'ShowRoom',
            'name_ar'=>'صالة عرض
'
        ]);
        UserType::create([
            'name_en'=> 'Discount',
            'name_ar'=>'الخصم'
        ]);
        UserType::create([
            'name_en'=> 'Potographer',
            'name_ar'=>'مصور فوتوغرافي'
        ]);
        UserType::create([
            'name_en'=> 'user',
            'name_ar'=>'المستخدمين'
        ]);
    }
}
