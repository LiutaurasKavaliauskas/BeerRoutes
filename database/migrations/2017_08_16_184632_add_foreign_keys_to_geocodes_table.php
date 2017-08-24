<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGeocodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('geocodes', function(Blueprint $table)
		{
			$table->foreign('brewery_id', 'fk_geocodes_breweries')->references('id')->on('breweries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('geocodes', function(Blueprint $table)
		{
			$table->dropForeign('fk_geocodes_breweries');
		});
	}
}
