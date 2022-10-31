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
        $services = [
            ['label' => 'Piscina', 'icon' => 'fa-solid fa-water-ladder'],
            ['label' => 'Portineria', 'icon' => 'fa-solid fa-bell-concierge'],
            ['label' => 'Sauna', 'icon' => 'fa-solid fa-hot-tub-person'],
            ['label' => 'WiFi', 'icon' => 'fa-solid fa-wifi'],
            ['label' => 'Posto Macchina', 'icon' => 'fa-solid fa-square-parking'],
            ['label' => 'Vista Mare', 'icon' => 'fa-solid fa-house-flood-water'],
            ['label' => 'Terrazza', 'icon' => 'fa-solid fa-sun-plant-wilt'],
            ['label' => 'Giardino', 'icon' => 'fa-brands fa-pagelines'],
            ['label' => 'Spiaggia privata', 'icon' => 'fa-solid fa-umbrella-beach'],
            ['label' => 'Biancheria', 'icon' => 'fa-solid fa-mattress-pillow'],
            ['label' => 'Smart Assistance', 'icon' => 'fa-solid fa-tablet-screen-button'],
            ['label' => 'Camera fumatori', 'icon' => 'fa-solid fa-smoking']
        ];    

        
        forEach($services as $service) {
        $new_service = new Service();

        $new_service->label = $service['label'];
        $new_service->icon = $service['icon'];
        
        $new_service->save();
        };
        
    }
}
