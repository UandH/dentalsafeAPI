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

    public function existDiagnosis($userId) {
        $response = new \stdClass();
        if (isset($userId) && (strpos($userId, ';') !== false)) {
            $user = DB::table('users')->where('deviceId', $userId)->first(['id']);
            $diagnosis = DB::table('diagnoses')->where('user_id', $userId)->first();
            if (!empty($diagnosis)) {
                $data = DB::table('recommendations')->where('id', $diagnosis->id)->first(['tda_id', 'recommendation']);
                $tda = DB::table('tdas')->where('id', $data->tda_id)->first(['tda', 'description', 'quantity']);
                $response->tda = $tda;
                $response->data = $data;
                $response->diagnosis = $diagnosis;
                return $response;
                
            }
        } 
        return false;
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
        $diagnosis;
        $deviceId = DB::table('users')->where('deviceId', $request->deviceId)->first();
        if (!empty($deviceId)) {
            $response->status = 200;
            $response->result = 'Existe el usuario';
            $diagnosis = $this->existDiagnosis($request->deviceId);
            if ($diagnosis !== false) {
                $response->existDiagnosis = true;
                $response->tda = $diagnosis->tda;
                $response->data = $diagnosis->data;
                $response->diagnosis = $diagnosis->diagnosis;
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
