<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('anonces', function(Blueprint $table) {
			$table->foreign('id_user')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('anonces', function(Blueprint $table) {
			$table->foreign('id_categorie')->references('id')->on('categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('prestation', function(Blueprint $table) {
			$table->foreign('id_user')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('canditature', function(Blueprint $table) {
			$table->foreign('id_user')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('canditature', function(Blueprint $table) {
			$table->foreign('id_anonce')->references('id')->on('anonces')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('message', function(Blueprint $table) {
			$table->foreign('receiver_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('message', function(Blueprint $table) {
			$table->foreign('sender_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->foreign('id_prestataire')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->foreign('id_user')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('anonces', function(Blueprint $table) {
			$table->dropForeign('anonces_id_user_foreign');
		});
		Schema::table('anonces', function(Blueprint $table) {
			$table->dropForeign('anonces_id_categorie_foreign');
		});
		Schema::table('prestation', function(Blueprint $table) {
			$table->dropForeign('prestation_id_user_foreign');
		});
		Schema::table('canditature', function(Blueprint $table) {
			$table->dropForeign('canditature_id_user_foreign');
		});
		Schema::table('canditature', function(Blueprint $table) {
			$table->dropForeign('canditature_id_anonce_foreign');
		});
		Schema::table('message', function(Blueprint $table) {
			$table->dropForeign('message_receiver_id_foreign');
		});
		Schema::table('message', function(Blueprint $table) {
			$table->dropForeign('message_sender_id_foreign');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->dropForeign('notes_id_prestataire_foreign');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->dropForeign('notes_id_user_foreign');
		});
	}
}