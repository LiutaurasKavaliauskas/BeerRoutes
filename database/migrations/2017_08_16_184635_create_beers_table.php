<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBeersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beers', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('brewery_id')->nullable()->index('fk_beers_breweries1_idx');
			$table->string('name')->nullable();
			$table->integer('cat_id')->nullable()->index('fk_beers_categories1_idx');
			$table->integer('style_id')->nullable()->index('fk_beers_styles1_idx');
			$table->float('abv', 10, 0)->nullable();
			$table->float('ibu', 10, 0)->nullable();
			$table->float('srm', 10, 0)->nullable();
			$table->float('upc', 10, 0)->nullable();
			$table->string('filepath')->nullable();
			$table->string('descript')->nullable();
			$table->integer('add_user')->nullable();
			$table->dateTime('last_mod')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beers');
	}

}
