<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\FieldController;
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function(Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('login', "\\App\\Http\\Controllers\\AuthController@login");
        $api->post('register', "\\App\\Http\\Controllers\\AuthController@register");
        $api->post('refresh', ['middleware' => 'jwt.refresh', function() {}]);
    });

    $api->group(['middleware' => 'api.auth'], function(Router $api) {

        // categories
        $api->resource('categories', CategoryController::class);

        // decks
        $api->resource('decks', DeckController::class);

        // fields
        $api->resource('fields', FieldController::class);

        // cards
        $api->resource('cards', CardController::class);
    });

});