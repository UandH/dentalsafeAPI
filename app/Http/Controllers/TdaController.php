<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Http\Request;

class TdaController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function getTdas()
    {
        $response = new \stdClass();
        
        $tda = DB::table('tdas')->get(['id', 'tda', 'img', 'description']);
            if(!empty($tda)){
                foreach ($tda as $tdaSelected) {
                    $tdaSelected->description = explode(';', $tdaSelected->description);
                }
                $response->status = 200;
                $response->result = $tda;
            } else {
                $response->status = 400;
                $response->result = 'Falta información';
            }
//        return response()->json($response);
        return Response::json($response, $response->status);
    }

}
