<?php

use Faker\Generator as Faker;



$factory->define(App\SensorData::class, function(Faker $faker){

	$sensor=App\Sensor::all()->random();
	if($sensor->typ="int")
	{
		$key = ['Temperatur','Luftfeuchtigkeit'];
		$value=$faker->randomDigit();
	}

	if($sensor->typ="time")
	{
		$key=["Ein", "Aus"];
		$value=$faker->dateTime("Y-m-d H:i:s");
	}
	return [
		'sensor_id' => $sensor->id,
                 'key' => $faker->randomElement($key),
                 'value' => $value
               ];
});

