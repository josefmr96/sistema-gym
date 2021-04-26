<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Legajo\Entrenador;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Producto;
use App\Entidades\Alumno\Alumno;

require app_path().'/start/constants.php';
use Session;

class ControladorEntrenadores extends Controller{

    public function nuevo(){
            $titulo = "Nuevo Entrenador";
            
            return view('entrenador.entrenadores-nuevo', compact('titulo'));
    }
    
     public function index(){

        $titulo = "Entrenadores";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('entrenador.entrenadores-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
            }
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
                    $row[] = '<img src="/images/' . $aEntrenador[$i]->foto . '" style="width:200px">';
                    $row[] = '<a href="/admin/entrenador/' . $aEntrenador[$i]->identrenador . '">' . $aEntrenador[$i]->nombre . '</a>';
                    $row[] = $aEntrenador[$i]->apellido;
                    $row[] = $aEntrenador[$i]->correo;
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
        
        public function editar($id){
            $titulo = "Modificar Entrenadores";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                    $codigo = "MENUMODIFICACION";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $entrenador = new Entrenador();
                    $entrenador->obtenerPorId($id);
    
            
                    return view('entrenador.entrenadores-nuevo', compact('entrenador', 'titulo'));
                }
            } else {
                return redirect('admin/login');
            }
        }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Entrenadores";
            $entidad = new Entrenador();
            $entidad->cargarDesdeRequest($request);
            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
                $nombre = date("Ymdhmsi") . ".jpg";
                $archivo = $_FILES["archivo"]["tmp_name"];
                move_uploaded_file($archivo, env('APP_PATH') . "/public/images/$nombre"); //guardaelarchivo
                $entidad->foto = $nombre;
            }

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    $entidadAnt = new Entrenador();
                    $entidadAnt->obtenerPorId($entidad->identrenador);

                    if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"] != ""){
                        $archivoAnterior =$_FILES["archivo"]["name"];
                        if($archivoAnterior !=""){
                            @unlink (env('APP_PATH') . "public/files/$archivoAnterior");
                        }
                    } else {
                        $entidad->imagen = $entidadAnt->imagen;
                    }

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
             
                $_POST["id"] = $entidad->identrenador;
                return view('entrenador.entrenadores-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->identrenador;
        $entrenador = new Entrenador();
        $entrenador->obtenerPorId($id);
  
        return view('entrenador.entrenadores-nuevo', compact('msg', 'menu', 'titulo')) . '?id=' . $entrenador->identrenador;
  
    }
    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

                $entidad = new Entrenador();
                $entidad->cargarDesdeRequest($request);
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