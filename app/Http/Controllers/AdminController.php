<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // CODES TO MANAGE USERS
    public function addUser(Request $req){
        // validation
        $this->validate($req,[
            'name' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'phone_no' => 'required',
            'role_id' => 'required',
            'lga_id' => 'required',
        ]);
        $password = bcrypt($req->password);
        return  User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $password,
            'phone_no' => $req->phone_no,
            'role_id' => $req->role_id,
            'lga_id' => $req->lga_id,

        ]);
    }
    public function getUser(){

        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('lgas', 'users.lga_id', '=', 'lgas.id')
            ->select('users.*', 'roles.role', 'lgas.lga')
            ->get();

            return $users;
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


}
