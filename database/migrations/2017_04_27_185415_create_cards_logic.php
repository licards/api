<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsLogic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('fields', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id')->unsigned();
            $table->string('name');
            $table->boolean('clue')->default(false);
            $table->timestamps();

            $table->foreign('deck_id')->references('id')->on('decks')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('cards', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id')->unsigned();
            $table->timestamps();

            $table->foreign('deck_id')->references('id')->on('decks')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('card_field', function(Blueprint $table) {
            $table->integer('card_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->text('value');

            $table->foreign('card_id')->references('id')->on('cards')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('field_id')->references('id')->on('fields')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['card_id', 'field_id']);
        });

        Schema::create('deck_tag', function(Blueprint $table) {
            $table->integer('deck_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('deck_id')->references('id')->on('decks')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['deck_id', 'tag_id']);
        });

        Schema::create('category_deck', function(Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('deck_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deck_id')->references('id')->on('decks')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['category_id', 'deck_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_deck');
        Schema::dropIfExists('deck_tag');
        Schema::dropIfExists('card_field');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('decks');
    }
}
