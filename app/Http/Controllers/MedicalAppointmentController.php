<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        if (!empty($request->token_id) || !empty($request->date)) {
            $diagnosis = DB::table('diagnoses')->where('user_id', $request->token_id)->first();
            if (!empty($diagnosis)) {
                DB::table('medical_appointments')->insert(['date' => $request->date, 'diagnosis_id' => $diagnosis->id]);
                $response->status = 200;
                $response->result = "Ingreso correcto";
            } else {
                $response->status = 400;
                $response->result = "Datos incorrectos";
            }
        } else {
            $response->status = 400;
            $response->result = "Faltan datos";
        }
        return response()->json($response);
    }

    public function showAppointments(){
        $response = DB::table('medical_appointments')->get();
        return response()->json($response);
    }

}
