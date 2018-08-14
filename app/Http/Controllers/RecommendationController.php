<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecommendationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRecommendation(Request $request)
    {
        //new Object 4 response
        $response = new \stdClass();

        // Check if the request has the two attributes necessaries for the query, if the atributes aren't specified return a 200 code. 
        if (empty($request) || empty($request->tda) || empty($request->teeth) || empty($request->token_id)) {
            $response->status = 400;
            $response->result = 'Debe ingresar todos los datos';
            return response()->json($response);
        }

        //Query with the atributes to get the recommendation.
        $recommendation = DB::table('recommendations')->where([
            ['teeth_id', $request->teeth],
            ['tda_id', $request->tda]
            ])->get(['id', 'recommendation']);
            
        //Check if we get our recommendation and define our response to return.
        //Explode the recommendations to an Array to be used in App.
        if (empty($recommendation)) {
            $response->status = 400;
            $response->result = 'Datos invalidos';

        } else {
            $response->status = 200;
            $recommendations = explode(';', $recommendation[0]->recommendation);
            $result = new \stdClass();
            $result->id = $recommendation[0]->id ;
            $result->recommendations = $recommendations;
            $response->result = $result;
            $userId = DB::table('users')->where('deviceId', $request->$deviceId)->first();
            $now = Carbon::now()->toDateTimeString();
            DB::table('diagnoses')->insert(['incident_date' => $now, 'recommendation_id' => $recommendation[0]->id, 'user_id' => $userId]);
        }
        return response()->json($response);
    }

    public function showDiagnoses(){
        $diagnoses = DB::table('diagnoses')->get();
        return response()->json($diagnoses);
    }

    public function storeDiagnosis(Request $request) {
        $response = new \stdClass();
        if (!empty($request) && isset($request->tda) && isset($request->teeth) && isset($request->deviceId)) {
            // $tdaId = DB::table('tdas')->where('tda','like' ,'%'.$request->tda.'%')->first(['id']);
            // $teethId = DB::table('teeths')->where('type', 'like', '%'.$request->teeth.'%')->first(['id']);
            $deviceId = DB::table('users')->where('deviceId', $request->deviceId)->first(['id']);
            $recommendationId = DB::table('recommendations')->where([
                ['tda_id', $tdaId],
                ['teeth_id', $teethId],
            ])->first(['id']);
            $diagnosis = DB::table('diagnoses')->insertGetId(['incident_date' => Carbon::now(), 'recommendation_id' => $recommendationId->id, 'user_id' => $deviceId->id]);
            $response->status = 200;
            $response->result = 'Diagnostico guardado';
        } else {
            $response->status = 400;
            $response->result = 'Faltan datos';
        }
        return response()->json($response);
    }
}
