<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeethController extends Controller
{
    /**
     * Display a listing of the teeths.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teeths = DB::table('teeths')->get();
        return response()->json($teeths);
    }

    
}
