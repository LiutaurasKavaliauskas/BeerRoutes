<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBreweriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('breweries', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->string('name')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('code')->nullable();
			$table->string('country')->nullable();
			$table->string('phone')->nullable();
			$table->string('website')->nullable();
			$table->string('filepath')->nullable();
			$table->text('descript')->nullable();
			$table->integer('add_user')->nullable();
			$table->string('last_mod')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('breweries');
	}
}
