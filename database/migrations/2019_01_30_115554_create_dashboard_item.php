<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('sensor_id')->unsigned();
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->integer('dashboard_id')->unsigned();
            $table->foreign('dashboard_id')->references('id')->on('dashboards');
            
            $table->string('sensor_data_key', 100);
            $table->string('sensor_data_val', 100);
            
            $table->string('chart_key', 100);
            
        });
        
     
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_items');

    }
}
