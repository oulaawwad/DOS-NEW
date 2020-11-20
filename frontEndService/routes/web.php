<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

	return response()->json(["Information dialog" => 'Welcome to the Frontend server!.']);
});

$router->group(['prefix' => 'search'] , function($router){
	$router->get('{topic}','frontEndController@getAllBooks');
});
$router->group(['prefix' => 'lookup'] , function($router){
	$router->get('{id}','frontEndController@getBook');
});


//  routes/ web file : This includes basic routing, routing parameters, named routes, 
$router->group(['prefix' => 'buy'] , function($router){
	$router->get('{id}','frontEndController@buyBook');
});