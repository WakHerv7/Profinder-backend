<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUserRoleTable extends Migration {

	public function up()
	{
		Schema::create('user_role', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('id_user')->unsigned()->nullable();
			$table->integer('id_role')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('user_role');
	}
}