<?php

namespace App\Http\Controllers;

use App\Models\PollingUnit;
use Illuminate\Http\Request;

class PuController extends Controller
{
    public function getPU(Request $request){
        $ward_id = $request->ward_id;
        $lga_id = $request->lga_id;
        return PollingUnit::orderBy('polling_unit', 'asc')->where('ward_id', $ward_id)->where('lga_id', $lga_id)->get();
    }
}
