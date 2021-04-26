<?php

namespace App\Http\Controllers;
use App\Entidades\Legajo\Entrenador;
use Illuminate\Http\Request;

require app_path().'/start/constants.php';
use Session;

class ControladorGymEntrenadores extends Controller
{
    public function index(){

            $entidad = new Entrenador();
            $array_entrenadores = $entidad->obtenerTodos();
    
            return view("web.team", compact('array_entrenadores'));
        }
    }



