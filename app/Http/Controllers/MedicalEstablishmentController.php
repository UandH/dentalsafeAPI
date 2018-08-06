<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MedicalEstablishmentController extends Controller
{

    /**
     * Get near medical establishments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEstablishments(Request $request)
    {
        $response = new \stdClass();
        if (!empty($request->commune) && !empty($request->schedule)) {
            //TODO: Validate every attribute
            if($request->schedule == 1 || $request->schedule == 0) {
                $communeId = DB::table('communes')->where('name', 'like', '%' . $request->commune . '%')->first(['id']);
                $establishments = DB::table('medical_establishments')->where([
                    ['commune_id', $communeId->id],
                    ['schedule', $request->schedule],
                ])->limit(10)->get();
                if (!empty($establishments)) {
                    $response->status = 200;
                    $response->result = $establishments;
                } else {
                    $response->status = 400;
                    $response->result = 'No existen centros';
                }
            } else {
                $response->status = 400;
                $response->result = 'Datos invalidos';
            }
        } else {
            $response->status = 400;
            $response->result = 'Faltan datos';
        }
        return response()->json($response);
    }




}
