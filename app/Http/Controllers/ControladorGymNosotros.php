<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require app_path().'/start/constants.php';
use Session;

class ControladorGymNosotros extends Controller
{
    public function index(){
        return view("web.about-us");
    }

}