<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBeersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('beers', function(Blueprint $table)
		{
			$table->foreign('brewery_id', 'fk_beers_breweries1')->references('id')->on('breweries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('cat_id', 'fk_beers_categories1')->references('id')->on('categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('style_id', 'fk_beers_styles1')->references('id')->on('styles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('beers', function(Blueprint $table)
		{
			$table->dropForeign('fk_beers_breweries1');
			$table->dropForeign('fk_beers_categories1');
			$table->dropForeign('fk_beers_styles1');
		});
	}

}
