<?php

use Illuminate\Http\Request;


//Users
Route::post('/registerUser', 'UserController@store');
Route::post('/updateUser', 'UserController@updateUser');
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

