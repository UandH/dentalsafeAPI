<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new \stdClass();
        if (!empty($request->token_id)) {
            $resultId = DB::table('users')->insertGetId(['token_id' => $request->token_id]);
            $response->status = 200;
            $response->result = $resultId;
        } else {
            $response->status = 400;
            $response->result = "Faltan datos";
        }
        return response()->json($response);
    }

    
}
