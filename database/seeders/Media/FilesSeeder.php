<?php

namespace Database\Seeders\Media;

use App\Models\MailBox\ReplayBox;
use App\Models\MailBox\RequestBox;
use App\Models\Media\Files;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Files::factory(30)->create(); 
    }
}
