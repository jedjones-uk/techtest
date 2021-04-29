<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Product Management
 */
Route::group(['as' => 'product.'], function () {
    //Standard Crud Actions
    require __DIR__ . '/models/products.php';
});

/*
 * Product Category Management
 */
Route::group(['as' => 'productCategory.'], function () {
    //Standard Crud Actions
    require __DIR__ . '/models/productCategory.php';
});
