<?php

namespace Database\Factories\Media;

use App\Enums\Files\FileSubTypes;
use App\Enums\Files\FileTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media\Files>
 */
class FilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
       
       

        $paths = [
            'https://download.samplelib.com/xls/sample-heavy-1.xls',
            'https://download.samplelib.com/xls/sample-simple-2.xls',
            'https://samplelib.com/lib/preview/png/sample-bumblebee-400x300.png',
            'https://samplelib.com/lib/preview/mp4/sample-5s.mp4',
            'https://samplelib.com/lib/preview/jpeg/sample-clouds-400x300.jpg'
        ];
            $filePath = fake()->randomElement($paths);
             // اختيار امتداد ملف عشوائي
            $extensions =   FileSubTypes::toArray();
            $extension = fake()->randomElement($extensions);

            $fileTypes =   FileTypes::toArray();
            $fileType = fake()->randomElement($fileTypes);
          
        return [
            'name' => fake()->word . '.' . $extension,
        'path' => $filePath, // استبدل بمسار الملف الفعلي
        'size' => fake()->randomNumber(6), // حجم الفعلي للملف
        'type' => $fileType,
        'sub_type' => $extension,
        ];
    }
}
