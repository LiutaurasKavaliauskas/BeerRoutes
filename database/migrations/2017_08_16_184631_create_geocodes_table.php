<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeocodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geocodes', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('brewery_id')->nullable()->index('fk_geocodes_breweries_idx');
			$table->float('latitude', 10, 0)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->string('accuracy')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geocodes');
	}

}
