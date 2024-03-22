<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory(3)->create();
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'first_name' => 'Dung',
            'last_name'  => 'HM',
            'email'      => 'dunghm@thientu.com.vn',
            'username'   => 'dunghm',
            'is_super'   => true,
            'password'   => Hash::make('123456@'),
        ]);
    }
}
