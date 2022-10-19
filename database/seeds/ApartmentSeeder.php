<?php

use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;
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

        $apartments = config('apartments');
        
        forEach($apartments as $apartment) {

            $new_apartment = new Apartment();

            $new_apartment->user_id = 1;
            $new_apartment->descriptive_title = $apartment['descriptive_title'];
            $new_apartment->num_rooms = $apartment['num_rooms'];
            $new_apartment->num_bed = $apartment['num_bed'];
            $new_apartment->num_bathroom = $apartment['num_bathroom'];
            $new_apartment->square_meters = $apartment['square_meters'];
            $new_apartment->visibility = $apartment['visibility'];
            $new_apartment->address = $apartment['address'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->image = $apartment['image'];

            $new_apartment->save();
            $services = Service::all();
            $new_apartment->services()->attach($services);
        }
    }
}
