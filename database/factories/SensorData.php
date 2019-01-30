<?php

use Faker\Generator as Faker;



$factory->define(App\SensorData::class, function(Faker $faker){

	$sensor=App\Sensor::all()->random();
        
        $sendorPair=[1,2,3];
        $pair= $faker->randomElement($sendorPair);
        
	if($pair==1)
	{
		$key = ['Temperatur','Luftfeuchtigkeit'];
		$value=$faker->randomDigit();
	}

	if($pair==2)
	{
		$key= ["Ein", "Aus"];
		$value=$faker->dateTime("Y-m-d H:i:s");
	}

	if($pair==3)
	{
		$key= ["1","2","3"];
		$value=$faker->sentence(4);
	}

	return [
		'sensor_id' => $sensor->id,
                 'key' => $faker->randomElement($key),
                 'value' => $value
               ];
});

