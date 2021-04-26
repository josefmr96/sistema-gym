<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto\Categoria;

require app_path().'/start/constants.php';
use Session;

class ControladorGymServicios extends Controller
{
    public function index(){
        
        $entidad = new Categoria();
        $array_categorias = $entidad->obtenerTodos();


        return view("web.services", compact('array_categorias'));
   
    }

}