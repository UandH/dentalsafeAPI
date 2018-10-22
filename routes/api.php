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
// Route::get('/getUsers', 'UserController@show');
Route::post('/existDiagnosis', 'UserController@existDiagnosis');

//Teeths
// Route::get('/getTeeths', 'TeethController@index');

// //Tdas
// Route::post('/getTda', 'TdaController@getTdas');

//Recommendations
Route::post('/getRecommendation', 'RecommendationController@getRecommendation');
Route::post('/storeDiagnosis', 'RecommendationController@storeDiagnosis');

//Diagnoses
// Route::get('/getDiagnoses', 'RecommendationController@showDiagnoses');
Route::post('/tdaUpdated', 'RecommendationController@updateDiagnoses');

//Medical establishments
Route::post('/getEstablishments', 'MedicalEstablishmentController@getEstablishments');

//Medical appointment
Route::post('/setAppointment', 'MedicalAppointmentController@store');
// Route::get('/getAppointments', 'MedicalAppointmentController@showAppointments');
Route::post('/checkDates', 'MedicalAppointmentController@checkDates');

//Commune
Route::post('/getIdCommune', 'CommuneController@getIdCommune');

