<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto\Producto;

require app_path().'/start/constants.php';
use Session;

class ControladorGymClases extends Controller
{
    public function index(){

  
        $entidad = new Producto();
        $array_productos = $entidad->obtenerTodos();

        return view("web.class-details", compact('array_productos'));
    }

}