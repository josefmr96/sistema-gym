<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorLegajo extends Controller
{
    public function index(){
        return view("legajo");
    }
}
