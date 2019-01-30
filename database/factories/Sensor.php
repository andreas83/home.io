<?php

use Faker\Generator as Faker;

$factory->define(App\Sensor::class, function(Faker $faker){
        return [
                 'name' =>  $faker->name,
                 'location' =>  $faker->randomElement(["Wohnzimmer", "Küche", "Keller", "Garten"]),
                 'description' =>  $faker->sentence,
               ];
});

