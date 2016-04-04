<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

/*
|--------------------------------------------------------------------------
| API Transformers
|--------------------------------------------------------------------------
*/

app('Dingo\Api\Transformer\Factory')->register('App\User', 'App\Http\Transformers\UserTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Campus', 'App\Http\Transformers\CampusTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Photo', 'App\Http\Transformers\PhotoTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Address', 'App\Http\Transformers\AddressTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Resam', 'App\Http\Transformers\ResamTransformer');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here are the API routes. They are managed by Dingo/API and can be accessed within the application.
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('users', ['as' => 'users.index', 'uses' => 'App\Http\Controllers\UserController@index']);
    $api->get('users/{id}', ['as' => 'users.show', 'uses' => 'App\Http\Controllers\UserController@show']);
    $api->post('users', ['as' => 'users.store', 'uses' => 'App\Http\Controllers\UserController@store']);
    $api->put('users/{id}', ['as' => 'users.update', 'uses' => 'App\Http\Controllers\UserController@update']);
    $api->delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'App\Http\Controllers\UserController@destroy']);

    $api->get('campuses', ['as' => 'campuses.index', 'uses' => 'App\Http\Controllers\CampusController@index']);
    $api->get('campuses/{id}', ['as' => 'campuses.show', 'uses' => 'App\Http\Controllers\CampusController@show']);
    
    $api->get('photos', ['as' => 'photos.index', 'uses' => 'App\Http\Controllers\PhotoController@index']);
    $api->get('photos/{id}', ['as' => 'photos.show', 'uses' => 'App\Http\Controllers\PhotoController@show']);
    
    $api->get('addresses', ['as' => 'addresses.index', 'uses' => 'App\Http\Controllers\AddressController@index']);
    $api->get('addresses/{id}', ['as' => 'addresses.show', 'uses' => 'App\Http\Controllers\AddressController@show']);
    $api->delete('addresses/{id}', ['as' => 'addresses.destroy', 'uses' => 'App\Http\Controllers\AddressController@destroy']);
    
    $api->get('resams', ['as' => 'resams.index', 'uses' => 'App\Http\Controllers\ResamController@index']);
    $api->get('resams/{id}', ['as' => 'resams.show', 'uses' => 'App\Http\Controllers\ResamController@show']);
});
