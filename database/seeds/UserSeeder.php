<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $new_user = new User();

        $new_user->name = 'Giorgia';
        $new_user->surname = 'Mendico';
        $new_user->email = 'giorgia@boolean.it';
        $new_user->date_of_birth = '1988-02-09';
        $new_user->password = bcrypt('password');

        $new_user->save();

        for($i = 0; $i < 5; $i++) {

            $new_user = new User();

            $new_user->name = $faker->firstName();
            $new_user->surname = $faker->lastName();
            $new_user->email = $faker->email();
            $new_user->date_of_birth = $faker->date();
            $new_user->password = bcrypt('pippo');
    
            $new_user->save();
    
        }
    }
}
