<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CommuneController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getIdCommune(Request $request) {   
        $response = new \stdClass();
        $validate = false;
        //Generate token for future requests
        if ($request->header('auth') && $request->deviceId) {
            $identified = DB::table('users')->where([
                ['deviceId', $request->deviceId],
                ['deviceCountry', $request->header('auth')],
            ])->first();
            if(!empty($identified)) {
                $validate = true;
            } else {
                $deviceId = DB::table('users')->where('deviceId', $request->deviceId)->first();
                $auth = DB::table('users')->where('deviceCountry', $request->header('auth'))->first();
                if(empty($deviceId) && empty($auth)) {
                    DB::table('users')->insert(['name' => 'asd', 'deviceId' => $deviceId, 'deviceCountry' => $auth, 'lastActivity' => Carbon::now()->setTimezone('America/Santiago')]);
                    $validate = true;
                } else {
                    $response->status = 404;
                    $response->result = "Acceso no autorizado";
                    return response()->json($response);
                }
            }
            
            
            if (!empty($request->commune) && $validate) {
                $commune = DB::table('communes')->where('name', 'like', '%' . $request->commune . '%')->first(['id']);
                return response()->json($commune);
            }
        } else {
            $response->status = 404;
            $response->result = "Acceso no autorizado";
            return response()->json($response);
        }
    }
 
}
