<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cobros\Cobro;
use App\Entidades\Legajo\Entrenador;
use App\Entidades\Configuracion\MediosDePago;
use App\Entidades\Alumno\Alumno;
use App\Entidades\Producto\Producto;
use App\Entidades\Configuracion\Moneda;
use App\Entidades\Pagos\Pago;



require app_path().'/start/constants.php';
use Session;

class ControladorPagos extends Controller{

    public function index(){
        $titulo = "Pagos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pagos.pagos-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadPagos = new Pago();
        $aPagos = $entidadPagos->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aPagos) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aPagos) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/pagos/' . $aPagos[$i]->idpago . '">' . $aPagos[$i]->fecha . '</a>';
                $row[] = $aPagos[$i]->nombre_mediodepago;
                $row[] = $aPagos[$i]->importe;
                $row[] = $aPagos[$i]->nombre_alumno;
                $row[] = $aPagos[$i]->nombre_pagoestado;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPagos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPagos),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar cobro";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $cobro = new Cobro();
                $cobro->obtenerPorId($id);

                $cobro = new Cobro();
                $array_menu = $cobro->obtenerMenuPadre($id);

                $menu_grupo = new MenuArea();
                $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

                return view('sistema.menu-nuevo', compact('menu', 'titulo', 'array_menu', 'array_menu_grupo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function nuevo(){
            $titulo = "Nuevo pago";
            $entidad = new Pago();

            $entrenador = new Entrenador();
            $array_entrenadores = $entrenador->obtenerTodos();

            $mediodepago = new MediosDePago();
            $array_mediodepago = $mediodepago->obtenerTodos();

            $alumno = new Alumno();
            $array_alumnos = $alumno->obtenerTodos();

            $producto = new Producto();
            $array_productos = $producto->obtenerTodos();

            $moneda = new Moneda();
            $array_monedas = $moneda->obtenerTodos();

            
            return view('pagos.pagos-nuevo', compact('titulo','array_mediodepago', 'array_entrenadores', 'array_alumnos', 'array_productos', 'array_monedas'));
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Nuevo pago";
            $entidad = new Pago();
            $entidad->cargarDesdeRequest($request);
    
            //validaciones
            if ($entidad->importe == "") {
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
             
                $_POST["id"] = $entidad->idpago;
                return view('pagos.pagos-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
    
        $id = $entidad->idpago;
        $pago = new Pago();
        $pago->obtenerPorId($id);

        $mediodepago = new Mediosdepago();
        $array_mediodepago = $mediodepago->obtenerTodos();

        $entrenador = new Entrenador();
        $array_entrenadores = $entrenador->obtenerTodos();

        $alumno = new Alumno();
        $array_alumnos = $alumno->obtenerTodos();

        $producto = new Producto();
        $array_productos = $producto->obtenerTodos();

        $moneda = new Moneda();
        $array_monedas = $moneda->obtenerTodos();


        return view('pagos.pagos-nuevo', compact('msg', 'titulo', 'array_mediodepago', 'array_entrenadores', 'array_alumnos', 'array_productos', 'array_monedas')) . '?id=' . $pago->idpago;
    
    }

}

