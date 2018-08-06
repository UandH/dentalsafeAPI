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

//Users
Route::post('/registerUser', 'UserController@store');
Route::get('/getUsers', 'UserController@show');
//Teeths
Route::get('/getTeeths', 'TeethController@index');

//Tdas
Route::post('/getTda', 'TdaController@getTdas');

//Recommendations
Route::post('/getRecommendation', 'RecommendationController@getRecommendation');

//Diagnoses
Route::get('/getDiagnoses', 'RecommendationController@showDiagnoses');

//Medical establishments
Route::post('/getEstablishments', 'MedicalEstablishmentController@getEstablishments');

//Medical appointment
Route::post('/setAppointment', 'MedicalAppointmentController@store');
Route::get('/getAppointments', 'MedicalAppointmentController@showAppointments');

//Commune
Route::post('/getIdCommune', 'CommuneController@getIdCommune');