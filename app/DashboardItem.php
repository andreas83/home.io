<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sensor_id', 'dashboard_id', 'chart_key', 'sensor_data_val', 'sensor_data_key'
    ];
}
