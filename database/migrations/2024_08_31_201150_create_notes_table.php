<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotesTable extends Migration {

	public function up()
	{
		Schema::create('notes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('note', 7000)->nullable();
			$table->string('commentaire', 9000)->nullable();
			$table->datetime('date_note')->nullable();
			$table->bigInteger('id_prestataire')->unsigned()->nullable();
			$table->bigInteger('id_user')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('notes');
	}
}