<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
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

    // CODES TO MANAGE USERS
    public function addUser(Request $req){
        // validation
        $this->validate($req,[
            'name' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'phone_no' => 'required',
            'role_id' => 'required'
        ]);
        $password = bcrypt($req->password);
        return  User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $password,
            'phone_no' => $req->phone_no,
            'role_id' => $req->role_id,

        ]);
    }
    public function getUser(){
        return User::orderBy('id', 'desc')->with('role')->get();
    }
    public function editUser(Request $req){
        // validation
        $this->validate($req,[
            'name' => 'required',
            'phone_no' => 'required',
        ]);
        return User::where('id', $req->id)->update([
            'name' => $req->name,
            'phone_no' => $req->phone_no,
            'role_id' => $req->role_id,
            'status' => $req->status
        ]);
    }
    // END CODES TO MANAGE USERS

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
