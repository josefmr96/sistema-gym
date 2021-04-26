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



require app_path().'/start/constants.php';
use Session;

class ControladorCobros extends Controller{

    public function index(){
        $titulo = "Cobros";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('cobros.cobros-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla(){
        
        $request = $_REQUEST;

        $entidadCobros = new Cobro();
        $aCobros = $entidadCobros->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCobros) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aCobros) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/cobros/' . $aCobros[$i]->idcobro . '">' . $aCobros[$i]->fecha_origen . '</a>';
                $row[] = $aCobros[$i]->importe;
                $row[] = $aCobros[$i]->concepto;
                $row[] = $aCobros[$i]->nombre_entrenador;
                $row[] = $aCobros[$i]->nombre_alumno;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCobros), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCobros),//cantidad total de registros en la paginacion
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
      

                return view('cobros.cobros-nuevo', compact('titulo', 'cobro', 'array_mediodepago', 'array_entrenadores', 'array_alumnos', 'array_productos', 'array_monedas'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function nuevo(){
            $titulo = "Nuevo cobro";
            $entidad = new Cobro();

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

            
            return view('cobros.cobros-nuevo', compact('titulo','array_mediodepago', 'array_entrenadores', 'array_alumnos', 'array_productos', 'array_monedas'));
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cobros";
            $entidad = new Cobro();
            $entidad->cargarDesdeRequest($request);
    
            //validaciones
            if ($entidad->fecha_origen == "" ) {
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
             
                $_POST["id"] = $entidad->idcobro;
                return view('cobros.cobros-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
    
        $id = $entidad->idcobro;
        $cobro = new Cobro();
        $cobro->obtenerPorId($id);

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


        return view('cobros.cobros-nuevo', compact('msg', 'cobro', 'titulo', 'array_mediodepago', 'array_entrenadores', 'array_alumnos', 'array_productos', 'array_monedas')) . '?id=' . $cobro->idcobro;
    
    }

}

