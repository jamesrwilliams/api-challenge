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

/**
 * Pass any API calls to our API endpoint to the ProductsController
 */
$router->get('/stores/{storeID}/products', 'ProductsController@storeProducts');

/**
 * Catch all HTTP verbs for all routes and 404 them for now. Don't want to give away any 500s
 */
$callback = function () {
    return response()->json([
        'error' => [
            'code' => '404',
            'message' => 'Not found'
        ]
    ], 404);
};

$catchAllRoute = '/{any:.*}';

$router->get($catchAllRoute, $callback);
$router->post($catchAllRoute, $callback);
$router->put($catchAllRoute, $callback);
$router->patch($catchAllRoute, $callback);
$router->delete($catchAllRoute, $callback);
$router->options($catchAllRoute, $callback);

