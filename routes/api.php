<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/', function () {
//     return view('welcome');
// });

//Teeths
Route::get('/getTeeths', 'TeethController@index');

//Tdas
Route::post('/getTda', 'TdaController@getTdas');

//Recommendations
Route::post('/getRecommendation', 'RecommendationController@getRecommendation');