<?php

namespace Database\Seeders;

use App\Models\MailBox\ReplayBox;
use App\Models\User;
use Database\Seeders\MailBox\ReplayBoxSeeder;
use Database\Seeders\MailBox\RequestBoxSeeder;
use Database\Seeders\MailBox\RequestTypeSeeder;
use Database\Seeders\Media\FilesSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
        
          UserSeeder::class,
          FilesSeeder::class,
          ExpenseSeeder::class,
            BudgetSeeder::class,
         
  ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
