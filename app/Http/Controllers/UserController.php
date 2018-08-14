<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function show() {
        $response = DB::table('users')->get();
        return response()->json($response);
    }

    public function existDiagnosis(Request $request) {
        $response = new \stdClass();
        if (isset($request->user) && (strpos($request->user, ';') !== false)) {
            $user = DB::table('users')->where('deviceId', $request->user)->first(['id']);
            $diagnosis = DB::table('diagnoses')->where('user_id', $user->id)->first();
            if (!empty($diagnosis)) {
                $data = DB::table('recommendations')->where('id', $diagnosis->id)->first(['tda_id', 'recommendation']);
                $tda = DB::table('tdas')->where('id', $data->tda_id)->first(['tda', 'description', 'quantity']);
                $response->status = 200;
                $response->result = 'OK';
                $response->tda = $tda;
                $response->data = $data;
                $response->diagnosis = $diagnosis;
                
            } else {
                $response->status = 400;
                $response->result = 'No hay registros';
            }
        } else {
            $response->status = 400;
            $response->result = 'Acceso incorrecto';
        }
        return response()->json($response);
    }


    public function checkDiagnosis($userId) {
        $user = DB::table('users')->where('deviceId',$userId)->first(['id']);
        $diagnosis = DB::table('diagnoses')->where('user_id', $user->id)->first(); 
        if (empty($diagnosis)) {  
            return true;
        } else { 
            return false;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new \stdClass();
        $deviceId = DB::table('users')->where('deviceId', $request->deviceId)->first();
        if (!empty($deviceId)) {
            $response->status = 200;
            $response->result = 'Existe el usuario';
            if ($this->checkDiagnosis($request->deviceId)) {
                $response->existDiagnosis = true;
            } else {
                $response->existDiagnosis = false;
            }
        } else {
            if (!empty($request->deviceId)) {
                $resultId = DB::table('users')->insertGetId(['deviceId' => $request->deviceId, 'deviceCountry' => $request->deviceCountry, 'lastActivity' => Carbon::now()]);
                $response->status = 200;
                $response->result = $resultId;
                $response->existDiagnosis = false;
            } else {
                $response->status = 400;
                $response->result = "Faltan datos";
            }
        }
        return response()->json($response);
    }

    
}
