<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\ExampleController;

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

$router->get('/', 'ExampleController@getWelcome');
$router->get('/Teste', 'ExampleController@getTeste');

$router->get('/produtos', 'ProdutoController@getProdutos');
$router->post('/produtos', 'ProdutoController@postProdutos');


