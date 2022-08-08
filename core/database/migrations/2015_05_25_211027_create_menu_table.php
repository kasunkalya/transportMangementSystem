<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu', function($table)
		{
			$table->increments('id');
			$table->string('label');
			$table->string('link');
			$table->string('icon');
			$table->integer('parent');
			$table->text('permissions')->nullable();
			$table->integer('menu_sort');
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu');
	}

}
