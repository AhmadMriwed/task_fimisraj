<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id'=>1,
                'first_name'=>'Ahmad',
                'last_name'=>'Mriwed',
                'email'=>'mr.ahmadmriwed@gmail.com',
                'password' =>Hash::make('12345678'),
                'image' => fake()->imageUrl(200, 200, 'people', true),
                'about_me' => fake()->paragraph(),
                'email_verified_at'=>Carbon::now()
                
            ],

        ]);
        User::factory(10)->create();
    }
}
