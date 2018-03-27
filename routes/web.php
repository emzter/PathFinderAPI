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

$router->post('auth/login',  ['uses' => 'AuthController@login']);
$router->post('auth/register',  ['uses' => 'AuthController@register']);

$router->get('jobs',  ['uses' => 'JobController@getAll']);
$router->get('jobs/{id}',  ['uses' => 'JobController@getOne']);
$router->get('jobs/{id}/category',  ['uses' => 'JobController@getCategory']);
$router->post('jobs',  ['uses' => 'JobController@post']);
$router->put('jobs/{id}',  ['uses' => 'JobController@update']);
$router->delete('jobs/{id}',  ['uses' => 'JobController@delete']);

$router->get('categories',  ['uses' => 'CategoryController@getAll']);
// $router->get('categories/{id}',  ['uses' => 'CategoryController@getOne']);
$router->get('categories/{id}/jobs',  ['uses' => 'CategoryController@getJobByCategory']);

$router->get('messages',  ['uses' => 'MessageController@getAll']);
$router->get('messages/{id}',  ['uses' => 'MessageController@getOne']);
$router->get('messages/inbox/{id}',  ['uses' => 'MessageController@getByReceiver']);
$router->get('messages/sent/{id}',  ['uses' => 'MessageController@getBySender']);
$router->post('messages',  ['uses' => 'MessageController@post']);
$router->delete('messages/{id}',  ['uses' => 'MessageController@delete']);
$router->put('messages/{id}',  ['uses' => 'MessageController@update']);

$router->get('users',  ['uses' => 'UserController@getAll']);
$router->get('users/{id}',  ['uses' => 'UserController@getOne']);
$router->get('users/{id}/details',  ['uses' => 'UserController@getDetail']);
$router->delete('users/{id}',  ['uses' => 'UserController@delete']);
$router->put('users/{id}',  ['uses' => 'UserController@update']);
// $router->put('users/{id}/details',  ['uses' => 'UserController@putDetails']);