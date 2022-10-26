<?php

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
        $this->call(
            [
            ServiceSeeder::class,
            SponsorSeeder::class,
            UserSeeder::class,
            ApartmentSeeder::class,
            MessageSeeder::class,
            ViewSeeder::class
            ]
    );
    }
}
