<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MedicalAppointmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new \stdClass();
        if (!empty($request->userId) && !empty($request->diagnosisId) ) {
            if ($request->datesToDelete) {
                if (strpos($request->datesToDelete, ',') !== FALSE) {
                    $datesToDeleteGarbage = str_replace('"', '', $request->datesToDelete);
                    $datesToDelete = explode(', ', $datesToDeleteGarbage);
                    foreach ($datesToDelete as $dateUnparsed) {
                        $dateParsed = Carbon::parse($dateUnparsed);
                        $day = $dateParsed->day >= 0 && $dateParsed->day <= 9 ? ('0' . $dateParsed->day) : $dateParsed->day;
                        $month = $dateParsed->month >= 0 && $dateParsed->month <= 9 ? ('0' . $dateParsed->month) : $dateParsed->month;
                        $date = $dateParsed->year . '-' . $month . '-' . $day;
                        DB::table('medical_appointments')->where([
                            ['diagnosis_id', $request->diagnosisId],
                            ['date', 'like', '%'.$date.'%'],
                            ['status', 1]
                        ])->update(['status' => 0]);
                    }
                    $response->status = 200;
                    $response->result = 'Fechas eliminadas';
                } else {
                    $dateToParsedGarbage = str_replace('"', '', $request->datesToDelete);
                    $dateParsed = Carbon::parse($dateToParsedGarbage);
                    $day = $dateParsed->day >= 0 && $dateParsed->day <= 9 ? ('0' . $dateParsed->day) : $dateParsed->day;
                    $month = $dateParsed->month >= 0 && $dateParsed->month <= 9 ? ('0' . $dateParsed->month) : $dateParsed->month;
                    $date = $dateParsed->year . '-' . $month . '-' . $day;
                    $dt = Carbon::createFromDate($dateParsed->Year, $month, $day);
                    DB::table('medical_appointments')->where([
                        ['diagnosis_id', $request->diagnosisId],
                        ['date', 'like', '%'.$dt.'%'],
                        ['status', 1]
                    ])->update(['status' => 0]);
                    $response->status = 200;
                    $response->result = 'Fecha eliminadas';
                }
            }
            if (!empty($request->datesToRegister)) {
            $dates = [];
            $userId = DB::table('users')->where('deviceId', $request->userId)->first(['id']);
            $diagnosis = DB::table('diagnoses')->where([
                ['id', $request->diagnosisId],
                ['user_id', $userId->id],
                ])->first();
            if (!empty($diagnosis)) {
                //TODO:: CHECK QUANTITY MEDICAL AND STATUS
                $quantityPossible = intval(DB::table('diagnoses')->join('recommendations', 'diagnoses.recommendation_id', '=', 'recommendations.id')->join('tdas', 'recommendations.tda_id', '=', 'tdas.id')->first(['tdas.quantity'])->quantity);
                $quantityActual = DB::table('medical_appointments')->where([
                    ['diagnosis_id', $request->diagnosisId],
                    ['status', true]
                ])->count();
                if ($quantityActual > $quantityPossible) {
                    $response->status = 400;
                    $response->result = 'No puede ingresar más citas';
                } else if ($request->datesToRegister) {
                    if (strpos($request->datesToDelete, ',') !== FALSE) {
                        $datesToRegisterGarbage = str_replace('"', '', $request->datesToRegister);
                        $datesToRegister = explode(', ', $datesToRegisterGarbage);
                        foreach ($datesToRegister as $date) {
                            if ($quantityActual < $quantityPossible) {
                                if (count(DB::table('medical_appointments')->where([
                                    ['date', 'like', '%'.$date.'%'],
                                    ['diagnosis_id', $diagnosis->id],
                                    ['status', true]
                                ])->get()) == 0) {
                                    array_push($dates, DB::table('medical_appointments')->insertGetId(['date' => $date, 'diagnosis_id' => $diagnosis->id]));              
                                    $quantityActual++;
                                }
                            }
                        }
                    } else {
                        $dateToRegister = str_replace('"', '', $request->datesToRegister);
                        if ($quantityActual < $quantityPossible) {
                            if (count(DB::table('medical_appointments')->where([
                                ['date', 'like', '%'.$dateToRegister.'%'],
                                ['diagnosis_id', $diagnosis->id],
                                ['status', true]
                            ])->get()) == 0) {
                                array_push($dates, DB::table('medical_appointments')->insertGetId(['date' => $dateToRegister, 'diagnosis_id' => $diagnosis->id]));              
                                $quantityActual++;
                            }
                        }
                    }
                    
                    $response->status = 200;
                    $response->result = 'Ingreso correcto';
                    $response->dates = $dates;
                }
                
            } else {
                $response->status = 400;
                $response->result = "Datos incorrectos";
            }
            }
        } else {
            $response->status = 400;
            $response->result = "Faltan datos";
        }
        return response()->json($response);
    }

    public function showAppointments (){
        $response = DB::table('medical_appointments')->get();
        return response()->json($response);
    }

    public function checkDates(Request $request) {
        $response = new \stdClass();
        $dates = [];
        if ($request->userId && $request->userId != '' && $request->diagnosisId && is_int(intval($request->diagnosisId))) {
            $id = DB::table('users')->where('deviceId', $request->userId)->first(['id'])->id;
            $diagnosisId = DB::table('diagnoses')->where([
                ['user_id', $id],
                ['id', $request->diagnosisId],
            ])->first();
            if ($diagnosisId->id == $request->diagnosisId) {
                $dates = DB::table('medical_appointments')->where([
                    ['diagnosis_id', $request->diagnosisId],
                    ['status', 1]
                ])->get(['date']);
                if (sizeof($dates) > 0) {
                    $response->dates = [];
                    foreach ($dates as $date) {
                        array_push($response->dates, $date);
                    }
                }
                $response->status = 200;
                $response->result = "Fechas encontradas";
            } else {
                $response->status = 400;
                $response->result = "Usuario no encontrado";
            }
        } else {
            $response->status = 400;
            $response->result = "Faltan datos";
        }
        return response()->json($response);
    }
}
