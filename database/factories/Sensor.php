<?php

use Faker\Generator as Faker;

$factory->define(App\Sensor::class, function(Faker $faker){
        return [
                 'name' =>  $faker->name,
                 'location' =>  $faker->randomElement(["Wohnzimmer", "Küche", "Keller", "Garten"]),
		 'type' =>  $faker->randomElement(["int", "char", "time"]),
                 'description' =>  $faker->sentence,
		 'user_id' =>  App\User::all()->random()->id
               ];
});

