<?php

namespace App\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class MediosDePago extends Model
{
    protected $table = 'medios_de_pago';
    public $timestamps = false;

    protected $fillable = [
        'idmediodepago', 'nombre'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idmediodepago = $request->input('id')!="0" ? $request->input('id') : $this->idmediodepago;
        $this->nombre = $request->input('txtNombre');
    }

 
   public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
            );

        $sql = "SELECT DISTINCT
                    A.idmediodepago,
                    A.nombre,

                    FROM medios_de_pago A
                    LEFT JOIN medios_de_pago B ON A.id_padre = B.idmediodepago
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.url LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  idmediodepago,
                  nombre
                FROM medios_de_pago";

        $sql .= " ORDER BY idmediodepago";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idmediodepago) {
        $sql = "SELECT
                idmediodepago,
                nombre
                FROM medios_de_pago WHERE idmediodepago = '$idmediodepago'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idmediodepago = $lstRetorno[0]->idmediodepago;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public  function eliminar() {
        $sql = "DELETE FROM medios_de_pago WHERE 
            idmediodepago=?";
        $affected = DB::delete($sql, [$this->idmediodepago]);
    }

    public function insertar() {
        $sql = "INSERT INTO medios_de_pago (
                nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
        ]);
       return $this->idmediodepago = DB::getPdo()->lastInsertId();
    }
    

public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Medios de pago";
        $entidad = new MediosDePago();
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
            return view('sistema.menu-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

    $id = $entidad->idmediodepago;
    $mediosdepago = new MediosDePago();
    $mediosdepago->obtenerPorId($id);

    return view('configuracion.mediosdepago-nuevo', compact('msg', 'cobros', 'titulo', 'array_mediodepago')) . '?id=' . $mediosdepago->idmediodepago;

}

}


?>