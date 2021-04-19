<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->longText('body');
            $table->tinyText('title');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @param Blueprint $table
     * @return void
     */
    public function down(Blueprint $table)
    {
        $table->foreign('author_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

        Schema::dropIfExists('topics');
    }
}
