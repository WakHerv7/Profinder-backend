<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateAnoncesTable extends Migration {

	public function up()
	{
		Schema::create('anonces', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('titre')->nullable();
			$table->string('description')->nullable();
			$table->decimal('budget', 50, 2)->nullable()->default('0.0');
			$table->datetime('date_limite')->nullable();
			$table->string('ville')->nullable();
			$table->bigInteger('id_user')->unsigned()->nullable();
			$table->bigInteger('id_categorie')->unsigned()->nullable();
			$table->boolean('active')->default(true);
            $table->integer('updated_by')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('anonces');
	}
}