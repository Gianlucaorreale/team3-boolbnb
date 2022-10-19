<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Apartment;
use App\Models\Sponsor;
use App\Models\Service;
use App\Models\Message;
use App\Models\View;
use Faker\Generator as Faker;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for($i = 0; $i < 10; $i++) {

            $new_apartment = new Apartment();

            $new_apartment->descriptive_title = $faker->text(100);
            $new_apartment->num_rooms = $faker->randomNumber(2, false);
            $new_apartment->num_bed = $faker->randomNumber(2, false);
            $new_apartment->num_bathroom = $faker->randomNumber(2, false);
            $new_apartment->square_meters = $faker->numberBetween(30, 500);
            $new_apartment->visibility = $faker->boolean();
            $new_apartment->address = $faker->address();
            $new_apartment->latitude = $faker->latitude($min = 40, $max = 42);
            $new_apartment->longitude = $faker->longitude($min = 11, $max = 13);
            $new_apartment->image = $faker->imageUrl();

            $new_apartment->save();
        }
    }
}
