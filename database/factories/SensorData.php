<?php

use Faker\Generator as Faker;



$factory->define(App\SensorData::class, function(Faker $faker){

	$sensor=App\Sensor::all()->random();
	if($sensor->type=="int")
	{
		$key = ['Temperatur','Luftfeuchtigkeit'];
		$value=$faker->randomDigit();
	}

	if($sensor->type=="time")
	{
		$key= ["Ein", "Aus"];
		$value=$faker->dateTime("Y-m-d H:i:s");
	}

	if($sensor->type=="char")
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

