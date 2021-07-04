<?php

namespace Database\Seeders;

use App\Models\Images;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $contents = \Storage::disk('public')->listContents('images');

        foreach ($contents as $content) {
            Images::updateOrCreate([
                'name' => $content['basename'],
                'path' => $content['path']
            ]);
        }
    }
}
