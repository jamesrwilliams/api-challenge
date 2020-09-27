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

$router->get('/stores/{storeID}/products', 'ProductsController@storeProducts');

/**
 * Catch all route for any other requests.
 */
$router->get('/{any:.*}', function() {
   return response()->json([
       'error' => [
           'code' => '404',
           'message' => 'Not found'
       ]
   ], 404);
});
