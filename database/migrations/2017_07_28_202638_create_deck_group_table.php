<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeckGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck_group', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('deck_id');
            $table->unsignedInteger('group_id');

            $table->foreign('deck_id')->references('id')->on('decks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deck_group');
    }
}
