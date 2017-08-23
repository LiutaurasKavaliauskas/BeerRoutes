<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStylesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('styles', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('cat_id')->nullable()->index('fk_styles_categories1_idx');
			$table->string('style_name')->nullable();
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
		Schema::drop('styles');
	}
}
