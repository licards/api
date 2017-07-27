<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_field', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id');
            $table->unsignedInteger('field_id');
            $table->text('value');

            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('card_field');
    }
}
