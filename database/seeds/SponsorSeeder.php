<?php

use Illuminate\Database\Seeder;
use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                'type' => 'Silver',
                'duration' => '24',
                'price' => '2.99'
            ],
            [
                'type' => 'Gold',
                'duration' => '72',
                'price' => '5.99'
            ],
            [
                'type' => 'Platinum',
                'duration' => '144',
                'price' => '9.99'
            ],
        ];

        forEach($sponsors as $sponsor) {

            $new_sponsor = new Sponsor();

            $new_sponsor->type = $sponsor['type'];
            $new_sponsor->duration = $sponsor['duration'];
            $new_sponsor->price = $sponsor['price'];
           

            $new_sponsor->save();
        }
    }
}
