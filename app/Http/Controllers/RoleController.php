<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // CODES TO MANAGE ROLES
    public function addRole(Request $req){
        // validation
        $this->validate($req,[
            'role' => 'required'
        ]);
        return Role::create([
            'role' => $req->role
        ]);
    }

    public function getRole(){
        $status = 1;
        return Role::orderBy('id', 'desc')->where('status', $status)->get();
    }

    public function disableRole(Request $req){
        // validation
        $this->validate($req,[
            'role' => 'required'
        ]);
        return Role::where('id', $req->id)->update([
            'status' => 0
        ]);
    }
    // END CODES TO MANAGE ROLES
}
