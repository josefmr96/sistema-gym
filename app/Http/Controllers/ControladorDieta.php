<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Alumno\Dieta;
use App\Entidades\Alumno\Alumno;

require app_path().'/start/constants.php';
use Session;

class ControladorDieta extends Controller{

    public function index(){

        $titulo = "Dietas de alumnos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('alumno.alumno-dieta', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
   


    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Dieta Semanal";
            $entidad = new Dieta();
            $entidad->cargarDesdeRequest($request);
  
            //validaciones
            if ($entidad->desayuno == "") {
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
             
                $_POST["id"] = $entidad->iddieta;
                return view('alumno.alumno-dieta', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->iddieta;
        $dieta = new Dieta();
        $dieta->obtenerPorId($id);

        $entidad = new Dieta();
        $array_diasSemanales = $entidad->obtenerTodos();
  
        return view('alumno.alumno-dieta', compact('msg', 'dieta', 'titulo','array_diasSemanales')) . '?id=' . $dieta->iddieta;
  
    }

    public function editar($id){
        $titulo = "Dieta Semanal";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $dieta = new Dieta();
                $dieta->obtenerPorId($id);

                $entidad = new Dieta();
                $array_diasSemanales = $entidad->obtenerTodos();

                return view('alumno.alumno-dieta', compact( 'titulo', 'dieta','array_diasSemanales'));
            }
        } else {
            return redirect('admin/login');
        }
    }
 

}