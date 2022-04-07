<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index(){

        $result = DB::table('results')
            ->join('parties', 'results.party_id', '=', 'parties.id')
            ->join('lgas', 'results.lga_id', '=', 'lgas.id')
            ->join('wards', 'results.ward_id', '=', 'wards.id')
            ->join('polling_units', 'results.polling_unit_id', '=', 'polling_units.id')
            ->select('results.total_votes_casted', 'parties.party_name', 'lgas.lga', 'wards.ward', 'polling_units.polling_unit')
            ->get();
            return $result;
    }
    public function addResult(Request $req){
        // validation
        $this->validate($req,[
            'total_votes_casted' => 'required',
            'polling_unit_id' => 'required',
            'ward_id' => 'required',
            'party_id' => 'required',
            'lga_id' => 'required',
            'state_id' => 'required',
            'user_id' => 'required'
        ]);
        return Result::create([
            'total_votes_casted' => $req->total_votes_casted,
            'polling_unit_id' => $req->polling_unit_id,
            'ward_id' => $req->ward_id,
            'party_id' => $req->party_id,
            'lga_id' => $req->lga_id,
            'state_id' => $req->state_id,
            'user_id' => $req->user_id
        ]);
    }
}
