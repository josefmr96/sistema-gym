<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Legajo\Entrenador;

require app_path().'/start/constants.php';
use Session;

class ControladorGymEntrenador extends Controller
{
    public function index($idEntrenador){

        $entidad = new Entrenador();
        $entrenador = $entidad->obtenerPorId($idEntrenador);

        return view('web.entrenador-descripcion', compact('entrenador')) . '?id=' . $entrenador->identrenador;
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadEntrenador = new Entrenador();
        $aEntrenador = $entidadEntrenador->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aEntrenador) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aEntrenador) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<img src="/images/' . $aEntrenador[$i]->foto . '" style="width:100px">';
                $row[] = '<a href="/admin/entrenador/' . $aEntrenador[$i]->idEntrenador . '">' . $aEntrenador[$i]->nombre . '</a>';
                $row[] = $aEntrenador[$i]->padre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aEntrenador), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aEntrenador),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
    


}