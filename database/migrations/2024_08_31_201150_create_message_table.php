<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageTable extends Migration {

	public function up()
	{
		Schema::create('message', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('contenu', 9000)->nullable();
			$table->datetime('date_envoi');
			$table->bigInteger('receiver_id')->unsigned()->nullable();
			$table->bigInteger('sender_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('message');
	}
}