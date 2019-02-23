<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location', 'description',
    ];

}
