<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'style'
    ];
    
    public function items()
    {
        return $this->belongsToMany('App\DashboardItem')
          ->withTimestamps();
    }
}
