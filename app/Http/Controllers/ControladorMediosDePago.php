<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Configuracion\Mediosdepago;

require app_path().'/start/constants.php';
use Session;

class ControladorMediosDePago extends Controller{

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadMenu = new MediosDePago();
        $aMenu = $entidadMenu->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMenu) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/configuracion/mediosdepago/nuevo' . $aMenu[$i]->idmenu . '">' . $aMenu[$i]->nombre . '</a>';
                $row[] = $aMenu[$i]->padre;
                $row[] = $aMenu[$i]->url;
                $row[] = $aMenu[$i]->activo;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMenu), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMenu),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function index(){

        $titulo = "Medios de Pago";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.mediosdepago-nuevo', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    
    public function nuevo(){
        $titulo = "Medios de Pago";
        $entidad = new Mediosdepago();
        $array_mediodepago = $entidad->obtenerTodos();

        return view('configuracion.mediosdepago-nuevo', compact('titulo', 'array_mediodepago'));
    }

    public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Medios de pago";
        $entidad = new Mediosdepago();
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
         
            $_POST["id"] = $entidad->idmediodepago;
            return view('configuracion.mediosdepago-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

    $id = $entidad->idmediodepago;
    $mediopago = new Mediosdepago();
    $mediopago->obtenerPorId($id);

    $entidad = new Mediosdepago();
    $array_mediodepago = $entidad->obtenerTodos();

    return view('configuracion.mediosdepago-listar', compact('msg',  'titulo', 'array_mediodepago')) . '?id=' . $mediopago->idmediodepago;

}

public function editar($id){
    $titulo = "Modificar Menú";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
            $codigo = "MENUMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $menu = new Menu();
            $menu->obtenerPorId($id);

            $entidad = new MediosDePago();
            $array_menu = $entidad->obtenerMenuPadre($id);

            $menu_grupo = new MenuArea();
            $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

            return view('configuracion.mediosdepago-nuevo', compact('menu', 'titulo', 'array_menu', 'array_menu_grupo'));
        }
    } else {
        return redirect('admin/login');
    }
}


}




?>