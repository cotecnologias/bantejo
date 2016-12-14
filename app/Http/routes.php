<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|


$app->get('/', function () use ($app) {
    return view('prueba');
});

$app->get('/foo', function () {
    return 'Hello World';
});*/


/**
 * Routes for resource api_auth
 */
 $app->group(['prefix' => 'Auth'], function() use ($app) {
     $app->post('LogIn', 'Api_authsController@LogIn');
     $app->get('LogOut','Api_authsController@LogOut');
     $app->get('show', 'Api_authsController@checkRole');
    });
 
$app->get('api_auth/show', 'Api_authsController@checkRole');
$app->get('api_auth/{id}', 'Api_authsController@get');

$app->put('api_auth/{id}', 'Api_authsController@put');
$app->delete('api_auth/{id}', 'Api_authsController@remove');
