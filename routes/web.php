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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('key', function () use ($router) {
    return str_random(32);
});

$router->post('auth/login',  ['uses' => 'AuthController@login']);
$router->post('auth/register',  ['uses' => 'AuthController@register']);

$router->get('messages',  ['uses' => 'MessageController@getAll']);
$router->get('messages/{id}',  ['uses' => 'MessageController@getOne']);
$router->get('messages/inbox/{id}',  ['uses' => 'MessageController@getByReceiver']);
$router->get('messages/sent/{id}',  ['uses' => 'MessageController@getBySender']);
$router->post('messages',  ['uses' => 'MessageController@post']);
$router->delete('messages/{id}',  ['uses' => 'MessageController@delete']);
$router->put('messages/{id}',  ['uses' => 'MessageController@put']);

$router->get('users',  ['uses' => 'UserController@getAll']);
$router->get('users/{id}',  ['uses' => 'UserController@getOne']);
$router->get('users/{id}/details',  ['uses' => 'UserController@getDetail']);
$router->delete('users/{id}',  ['uses' => 'UserController@delete']);
$router->put('users/{id}',  ['uses' => 'UserController@put']);