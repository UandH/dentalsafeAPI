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
