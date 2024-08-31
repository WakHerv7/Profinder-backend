<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCanditatureTable extends Migration {

	public function up()
	{
		Schema::create('canditature', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->bigInteger('id_user')->unsigned()->nullable();
			$table->bigInteger('id_anonce')->unsigned()->nullable();
			$table->string('message', 500)->nullable();
			$table->datetime('date_candidature')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('canditature');
	}
}