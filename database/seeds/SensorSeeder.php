<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	factory('App\Sensor', 10)->create();
	factory('App\SensorData', 1000)->create();
    }
}
