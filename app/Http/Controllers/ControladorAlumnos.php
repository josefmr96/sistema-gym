<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Alumno\Alumno;
use App\Entidades\Configuracion\CondicionIva;

require app_path().'/start/constants.php';
use Session;

class ControladorAlumnos extends Controller{

    public function index(){
        $titulo = "Alumnos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('alumno.alumnos-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadAlumno = new Alumno();
        $aAlumno = $entidadAlumno->obtenerFiltrado();
       

        $entidadCondicion = new CondicionIva();
        $aCondicion = $entidadCondicion->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aAlumno) > 0)
            $cont=0;
            

            for ($i=$inicio; $i < count($aAlumno) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/alumno/' . $aAlumno[$i]->idalumno . '">' . $aAlumno[$i]->nombre . '</a>';
                $row[] = $aAlumno[$i]->apellido;
                $row[] = $aAlumno[$i]->correo;
                $row[] = $aAlumno[$i]->edad;
                $row[] = $aAlumno[$i]->telefono;
                $row[] = $aAlumno[$i]->direccion;
                $row[] = $aAlumno[$i]->dni;
                $row[] = $aAlumno[$i]->cuit;
               $cont++;
                $data[] = $row;
                }
            
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aAlumno), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aAlumno),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
        
    }
    public function editar($id){
        $titulo = "Modificar Alumno";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $alumno = new Alumno();
                $alumno->obtenerPorId($id);

                $entidad = new CondicionIva();
                $array_condicionIva = $entidad->obtenerTodos();

                return view('alumno.alumno-nuevo', compact('alumno', 'titulo','array_condicionIva'));
            }
        } else {
            return redirect('admin/login');
        }
    }


 

    public function nuevo(){
            $titulo = "Nuevo Alumno";
            $entidad = new CondicionIva();
            $array_condicionIva = $entidad->obtenerTodos();

            return view('alumno.alumno-nuevo', compact('titulo','array_condicionIva'));
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

                $entidad = new Alumno();
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
    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Alumno";
            $entidad = new Alumno();
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
             
                $_POST["id"] = $entidad->idcategoria;
                return view('alumno.alumno-nuevo', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->idcategoria;
        $alumno = new Alumno();
        $alumno->obtenerPorId($id);

        $entidad = new Alumno();
        $array_alumnos = $entidad->obtenerTodos();
  
        return view('alumno.alumno-nuevo', compact('msg', 'alumno', 'titulo','array_alumnos')) . '?id=' . $alumno->idalumno;
  
    }
 


}