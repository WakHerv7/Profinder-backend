<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrestationTable extends Migration {

	public function up()
	{
		Schema::create('prestation', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('titre')->nullable();
			$table->string('description')->nullable();
			$table->decimal('tarifs')->nullable();
			$table->bigInteger('id_user')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('prestation');
	}
}