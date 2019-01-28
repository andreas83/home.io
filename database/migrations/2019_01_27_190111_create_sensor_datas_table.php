<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create('sensor_datas', function($table)
	{
		$table->increments('id');
		$table->string('key', 100);
		$table->string('value', 100);
		$table->timestamps();
		$table->integer('sensor_id')->unsigned();
		$table->foreign('sensor_id')->references('id')->on('sensors');
	});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
