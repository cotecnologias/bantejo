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
 /**
 * Routes for resource api_auth
 */
 $app->group(['prefix' => 'Auth'], function() use ($app) {
     $app->post('LogIn', 'Api_authsController@LogIn');
     $app->get('LogOut','Api_authsController@LogOut');
    });
    /**
 * Routes for resource User
 */
 $app->group(['prefix' => 'Usuarios','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'UserController@all');
     $app->post('add','UserController@add');
     $app->get('show/{id}', 'UserController@show');
     $app->put('update/{id}', 'UserController@update');
     $app->delete('delete/{id}', 'UserController@delete');
     $app->get('report/{id}', 'UserController@report');
    });
/**
 * Routes for resource Permission
 */
 $app->group(['prefix' => 'Permisos','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'PermissionsController@all');
     $app->post('add','PermissionsController@add');
     $app->get('show/{id}', 'PermissionsController@show');
     $app->put('update/{id}', 'PermissionsController@update');
     $app->delete('delete/{id}', 'PermissionsController@delete');
     $app->get('report/{id}', 'PermissionsController@report');
    });
/**
 * Routes for resource Page
 */
 $app->group(['prefix' => 'Paginas','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'PagesController@all');
     $app->post('add','PagesController@add');
     $app->get('show/{id}', 'PagesController@show');
     $app->put('update/{id}', 'PagesController@update');
     $app->delete('delete/{id}', 'PagesController@delete');
     $app->get('report/{id}', 'PagesController@report');
    });

/**
 * Routes for resource occupation
 */
 $app->group(['prefix' => 'Puestos','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'OccupationsController@all');
     $app->post('add','OccupationsController@add');
     $app->get('show/{id}', 'OccupationsController@show');
     $app->put('update/{id}', 'OccupationsController@update');
     $app->delete('delete/{id}', 'OccupationsController@delete');
     $app->get('report/{id}', 'OccupationsController@report');
    });

/**
 * Routes for resource employee
 */
  $app->group(['prefix' => 'Empleados','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'EmployeesController@all');
     $app->post('add','EmployeesController@add');
     $app->get('show/{id}', 'EmployeesController@show');
     $app->put('update/{id}', 'EmployeesController@update');
     $app->delete('delete/{id}', 'EmployeesController@delete');
     $app->get('report/{id}', 'EmployeesController@report');
    });

 $app->group(['prefix' => 'Bank','middleware'=>'Api'], function() use ($app) {
     $app->get('all', 'BankController@all');
     $app->post('add','BankController@add');
     $app->get('show/{id}', 'BankController@show');
     $app->put('update/{id}', 'BankController@update');
     $app->delete('delete/{id}', 'BankController@delete');
    });