<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('isbn', 13)->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->unsignedSmallInteger('pub_year')->nullable();
            $table->string('image_url_small')->nullable();
            $table->string('image_url_medium')->nullable();
            $table->string('image_url_large')->nullable();
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->index('name');
        });

        Schema::create('book_authors', function (Blueprint $table) {
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('author_id');
            $table->timestamps();
            $table->primary(array('book_id', 'author_id'));

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_authors', function($table)
        {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['author_id']);
        });

        Schema::dropIfExists('book_authors');
        Schema::dropIfExists('books');
        Schema::dropIfExists('authors');
    }
}
