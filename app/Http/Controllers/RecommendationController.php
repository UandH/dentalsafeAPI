<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        if (empty($request) || empty($request->tda) || empty($request->teeth)) {
            $response->status = 400;
            $response->result = 'Debe ingresar todos los datos';
            return response()->json($response);
        }

        //Query with the atributes to get the recommendation.
        $recommendation = DB::table('recommendations')->where([
            ['teeth_id', $request->teeth],
            ['tda_id', $request->tda]
            ])->get(['recommendation']);
            
        //Check if we get our recommendation and define our response to return.
        //Explode the recommendations to an Array to be used in App.
        if (empty($recommendation)) {
            $response->status = 400;
            $response->result = 'Datos invalidos';
        } else {
            $response->status = 200;
            $recommendations = explode(';', $recommendation[0]->recommendation);
            $response->result = $recommendations;
        }
        
        return response()->json($response);
    }

}
