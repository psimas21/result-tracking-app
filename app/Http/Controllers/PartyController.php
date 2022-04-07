<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    // CODES TO MANAGE PARTIES
    public function addParty(Request $req){
        // validation
        $this->validate($req,[
            'party_name' => 'required'
        ]);
        return Party::create([
            'party_name' => $req->party_name
        ]);
    }

    public function getParty(){
        $status = 1;
        return Party::orderBy('id', 'desc')->where('status', $status)->get();
    }

    public function disableParty(Request $req){
        // validation
        $this->validate($req,[
            'party_name' => 'required'
        ]);
        return Party::where('id', $req->id)->update([
            'status' => 0
        ]);
    }
    // END CODES TO MANAGE PARTIES
}
