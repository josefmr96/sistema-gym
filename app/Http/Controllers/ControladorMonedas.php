<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Configuracion\Moneda;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';
use Session;

class ControladorMonedas extends Controller{

    public function nuevo(){
            $titulo = "Monedas";

            return view('configuracion.monedas-nuevo', compact('titulo'));
    }
    public function index(){
        $titulo = "Monedas";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.monedas-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
            }
        }
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $entidadMoneda = new Moneda();
            $aMoneda = $entidadMoneda->obtenerFiltrado();
    
            $data = array();
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
            if (count($aMoneda) > 0)
                $cont=0;
                for ($i=$inicio; $i < count($aMoneda) && $cont < $registros_por_pagina; $i++) {
                    $row = array();
                    $row[] = '<a href="/admin/monedas/' . $aMoneda[$i]->idmoneda . '">' . $aMoneda[$i]->nombre . '</a>';
                    $row[] = $aMoneda[$i]->simbolo;
                    $cont++;
                    $data[] = $row;
                }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aMoneda), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aMoneda),//cantidad total de registros en la paginacion
                "data" => $data
            );
            return json_encode($json_data);
        }
        public function editar($id){
            $titulo = "Modificar Moneda";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                    $codigo = "MENUMODIFICACION";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $moneda = new Moneda();
                    $moneda->obtenerPorId($id);
    
            
                    return view('configuracion.monedas-nuevo', compact('moneda', 'titulo'));
                }
            } else {
               return redirect('login');
            }
        }
    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Moneda";
            $entidad = new Moneda();
            $entidad->cargarDesdeRequest($request);
  
            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();
  
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();
  
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
             
                $_POST["id"] = $entidad->idmenu;
                return view('configuracion.monedas-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->idmoneda;
        $moneda = new Moneda();
        $moneda->obtenerPorId($id);
  
        return view('configuracion.monedas-nuevo', compact('msg', 'menu', 'titulo')) . '?id=' . $moneda->idmoneda;
  
    }
    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

                $entidad = new Moneda();
                $entidad->idmoneda = $id;
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "MENUELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
 
}

