<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function getWard(Request $request){
        $lga_id = $request->lga_id;
        return Ward::orderBy('ward', 'asc')->where('lga_id', $lga_id)->get();
    }
}
