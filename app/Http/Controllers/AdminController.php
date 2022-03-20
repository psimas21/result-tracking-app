<?php

namespace App\Http\Controllers;

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
        return User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $password,
            'phone_no' => $req->phone_no,
            'role_id' => $req->role_id,

        ]);
    }
    public function getUser(){
        // return User::orderBy('id', 'desc')->with('role')->get();
        return User::join('roles', 'users.role_id', '=', 'roles.id')->get();
    }
    // END CODES TO MANAGE USERS
}
