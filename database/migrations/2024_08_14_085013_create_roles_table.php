<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRolesTable extends Migration {

	public function up()
	{
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name')->nullable();
			$table->boolean('active')->default(true);
            $table->integer('updated_by')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('roles');
	}
}