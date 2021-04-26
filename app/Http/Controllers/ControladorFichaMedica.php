<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Alumno\FichaMedica;
use App\Entidades\Alumno\GrupoSanguineo;

require app_path() . '/start/constants.php';

use Session;

class ControladorFichaMedica extends Controller
{


    public function nuevo()
    {
        $titulo = "Ficha Medica";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("FICHAMEDICACONSULTA")) {
                $codigo = "FICHAMEDICACONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new GrupoSanguineo();
                $array_gruposanguineo = $entidad->obtenerTodos();
                return view('alumno.fichamedica-nueva', compact('titulo', 'array_gruposanguineo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function editar($id){
        $titulo = "Modificar ficha medica";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("FICHAMODIFICACION")) {
                $codigo = "FICHAMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $fichamedica = new FichaMedica();
                $fichamedica->obtenerPorId($id);

                $entidad = new GrupoSanguineo();
                $array_gruposanguineo = $entidad->obtenerTodos();

                return view('alumno.fichamedica-nueva', compact('fichamedica', 'titulo', 'array_gruposanguineo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Ficha Medica";
            $entidad = new FichaMedica();
            $entidad->cargarDesdeRequest($request);
            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
                $nombre = date("Ymdhmsi") . ".jpg";
                $archivo = $_FILES["archivo"]["tmp_name"];
                move_uploaded_file($archivo, env('APP_PATH') . "/public/images/$nombre"); //guardaelarchivo
                $entidad->foto = $nombre;
            }

            //validaciones
            echo "<pre>";
            print_r($entidad);
            echo "</pre>";
            if ($entidad->altura == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {

                    $entidadAnt = new FichaMedica();
                    $entidadAnt->obtenerPorId($entidad->idfichamedica);

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

                $_POST["id"] = $entidad->idfichamedica;
                return view('alumno.nuevo', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idfichamedica;
        $fichamedica = new FichaMedica();
        $fichamedica->obtenerPorId($id);

        $entidad = new GrupoSanguineo();
                $array_gruposanguineo = $entidad->obtenerTodos();


        return view('alumno.fichamedica-nueva', compact('msg', 'titulo', 'array_gruposanguineo')) . '?id=' . $fichamedica->idfichamedica;
    }
}
