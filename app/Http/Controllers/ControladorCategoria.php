<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Categoria;

require app_path().'/start/constants.php';
use Session;

class ControladorCategoria extends Controller{
    public function index(){
        $titulo = "Categoria";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.categorias-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function editar($id){
        $titulo = "Modificar Categoria";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $categoria = new Categoria();
                $categoria->obtenerPorId($id);

                $entidad = new Categoria();
                $array_categorias = $entidad->obtenerTodos();
                

                return view('producto.categoria-nuevo', compact('categoria', 'titulo','array_categorias'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadCategoria = new Categoria();
        $aCategoria = $entidadCategoria->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCategoria) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aCategoria) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<img src="/images/' . $aCategoria[$i]->foto . '" style="width:100px">';
                $row[] = '<a href="/admin/categoria/' . $aCategoria[$i]->idcategoria . '">' . $aCategoria[$i]->nombre . '</a>';
                $row[] = $aCategoria[$i]->padre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCategoria), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategoria),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }


    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

                $entidad = new Categoria();
                $entidad->idcategoria = $id;

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
    public function nuevo(){
            $titulo = "Nueva Categoria";
            $entidad = new Categoria();
            $array_categorias = $entidad->obtenerTodos();
            return view('producto.categoria-nuevo', compact('titulo','array_categorias'));
    }
    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Categoria";
            $entidad = new Categoria();
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
                    $entidadAnt = new Categoria();
                    $entidadAnt->obtenerPorId($entidad->idcategoria);

                    if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"] != ""){
                        $archivoAnterior =$_FILES["archivo"]["name"];
                        if($archivoAnterior !=""){
                            @unlink (env('APP_PATH') . "/public/files/$archivoAnterior");
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
             
                $_POST["id"] = $entidad->idcategoria;
                return view('producto.categorias-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
  
        $id = $entidad->idcategoria;
        $categoria = new Categoria();
        $categoria->obtenerPorId($id);

        $entidad = new Categoria();
        $array_categorias = $entidad->obtenerTodos();
  
        return view('producto.categorias-listar', compact('msg', 'categoria', 'titulo','array_categorias')) . '?id=' . $categoria->idcategoria;
  
    }
 


}

?>