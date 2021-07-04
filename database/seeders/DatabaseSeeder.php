<?php

namespace Database\Seeders;

use Faker\Provider\Image;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ImageSeeder::class,
        ]);
    }
}
