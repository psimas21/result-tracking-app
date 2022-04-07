<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use Illuminate\Http\Request;

class LgaController extends Controller
{
    public function getLga(){
        return Lga::orderBy('lga', 'asc')->get();
    }
}
