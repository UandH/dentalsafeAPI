<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;

class RecommendationController extends Controller
{
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
        if (empty($request->tda) || empty($request->teeth) || empty($request->deviceId)) {
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
        }
//        return response()->json($response);
        return Response::json($response, $response->status);
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
                ['tda_id', intval($request->tda)],
                ['teeth_id', intval($request->teeth)],
            ])->first(['id']);
            $tda = DB::table('tdas')->where('id', intval($request->tda))->first(['description']);
            $diagnosis = DB::table('diagnoses')->insertGetId(['incident_date' => Carbon::now()->setTimezone('America/Santiago'), 'recommendation_id' => $recommendationId->id, 'user_id' => $deviceId->id]);
            $response->status = 200;
            $response->result = 'Diagnostico guardado';
            $response->description = explode(';', $tda->description);
        } else {
            $response->status = 400;
            $response->result = 'Faltan datos';
        }
//        return response()->json($response);
        return Response::json($response, $response->status);
    }

    public function updateDiagnoses(Request $request) {
        $response = new \stdClass();

        if (isset($request->diagnosisId) && isset($request->tdaId)) {
            $diagnosis = DB::table('diagnoses')->where('id', intval($request->diagnosisId))->first();
            $recommendation = DB::table('recommendations')->where('id', intval($diagnosis->recommendation_id))->first();
            $newRecommendation = DB::table('recommendations')->where([
                ['teeth_id', intval($recommendation->teeth_id)],
                ['tda_id', intval($request->tdaId)],
            ])->first(['id', 'recommendation', 'tda_id']);
            DB::table('diagnoses')->where('id', intval($request->diagnosisId))->update([
                'recommendation_id' => $newRecommendation->id,
                'confirmed' => 1,
            ]);
            $newDiagnosis = DB::table('diagnoses')->where('id', intval($request->diagnosisId))->first();
            $response->status = 200;
            $response->result = 'OK';
            $response->data = new \stdClass();
            $response->data->diagnosis = $newDiagnosis;
            $recommendation = explode(';', $newRecommendation->recommendation);
            $response->data->recommendation = $recommendation;
            $response->data->tda = DB::table('tdas')->where('id', $newRecommendation->tda_id)->first(['tda', 'description', 'quantity']);
        } elseif (isset($request->diagnosisId)) {
            DB::table('diagnoses')->where('id', intval($request->diagnosisId))->update(['confirmed' => 1]);
            $response->status = 200;
            $response->result = 'OK';
        } else {
            $response->status = 400;
            $response->result = 'Faltan datos';
        }

//        return response()->json($response);
        return Response::json($response, $response->status);
    }

}
