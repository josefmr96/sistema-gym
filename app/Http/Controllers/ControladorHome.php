<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorHome extends Controller
{
    public function index(Request $request){
        $titulo = 'Inicio';
        if(Usuario::autenticado() == true){
            return view('sistema.index', compact('titulo'));
        } else {
            return redirect('admin/login');
        }
        
    }
}