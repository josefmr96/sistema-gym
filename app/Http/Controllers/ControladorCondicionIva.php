<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Configuracion\CondicionIva;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';
use Session;

class ControladorCondicionIva extends Controller{

    public function nuevo(){
            $titulo = "Condicion Iva Nuevo";

            return view('configuracion.condicioniva-nuevo', compact('titulo'));
      }
        public function index(){
            $titulo = "Condicion Iva";
            if(Usuario::autenticado() == true){
                if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                    $codigo = "MENUCONSULTA";
                    $mensaje = "No tiene permisos para la operaci&oacute;n.";
                    return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view('configuracion.condicioniva-listar', compact('titulo'));
                }
            } else {
                return redirect('admin/login');
                    }
                }

        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $entidadCondicion = new CondicionIva();
            $aCondicioniva = $entidadCondicion->obtenerFiltrado();
    
            $data = array();
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
            if (count($aCondicioniva) > 0)
                $cont=0;
                
                for ($i=$inicio; $i < count($aCondicioniva) && $cont < $registros_por_pagina; $i++) {
                    $row = array();
                    $row[] = '<a href="/admin/condicioniva/' . $aCondicioniva[$i]->idcondicioniva . '">' . $aCondicioniva[$i]->nombre . '</a>';
                    $cont++;
                    $data[] = $row;
                }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aCondicioniva), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aCondicioniva),//cantidad total de registros en la paginacion
                "data" => $data
            );
            return json_encode($json_data);
        }

        public function editar($id){
            $titulo = "Modificar Condicion Iva";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                    $codigo = "MENUMODIFICACION";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $condicioniva = new CondicionIva();
                    $condicioniva->obtenerPorId($id);
    
                    return view('configuracion.condicioniva-nuevo', compact('condicioniva', 'titulo'));
                }
            } else {
                return redirect('admin/login');
            }
        }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Condicion IVA";
            $entidad = new CondicionIva();
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
             
                $_POST["id"] = $entidad->idcondicioniva;
                return view('configuracion.condicioniva-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->idcondicioniva;
        $condicioniva = new CondicionIva();
        $condicioniva->obtenerPorId($id);
  
        return view('configuracion.condicioniva-nuevo', compact('msg', 'menu', 'titulo')) . '?id=' . $condicioniva->idcondicioniva;
  
    }
    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

                $entidad = new CondicionIva();
                $entidad->idcondicioniva = $id;

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
