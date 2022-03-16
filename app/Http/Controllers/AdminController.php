<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // CODES TO MANAGE ROLES
    public function addRole(Request $req){
        // validation
        // $this->validate($req,[
        //     'role' => 'required'
        // ]);
        return Role::create([
            'role' => $req->newRole
        ]);
    }

    public function getRole(){
        return Role::orderBy('id', 'desc')->get();
    }
    // END CODES TO MANAGE ROLES
}
