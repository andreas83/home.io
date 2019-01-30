<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create('sensors', function($table)
	{
		$table->increments('id');
//                $table->integer('user_id')->unsigned()->default(1);
//                $table->foreign('user_id')->references('id')->on('users');

		$table->char('name', 100);
		$table->char('location', 100)->default("");
		$table->text('description');
		$table->timestamps();

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
