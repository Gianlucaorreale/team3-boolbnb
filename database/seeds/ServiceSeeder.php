<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['Piscina', 'Portineria', 'Sauna', 'WiFi', 'Posto Macchina', 
        'Vista Mare', 'Terrazza', 'Giardino', 'Spiaggia privata', 'Biancheria', 
        'Smart Assistance', 'Camera fumatori'];

        
        forEach($services as $service) {
        $new_service = new Service();

        $new_service->label = $service;
        
        $new_service->save();
        };

    }
}
