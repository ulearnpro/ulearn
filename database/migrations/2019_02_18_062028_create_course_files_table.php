<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_files', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('file_name', 250);
			$table->string('file_title', 200);
			$table->string('file_type', 250);
			$table->string('file_extension', 50);
			$table->string('file_size', 50);
			$table->string('duration', 50)->nullable();
			$table->text('file_tag');
			$table->integer('uploader_id');
			$table->integer('processed')->default(1)->comment('0-not processed,1-processed');
			$table->integer('created_at');
			$table->integer('updated_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_files');
	}

}
