<?php

namespace App\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class CondicionIva extends Model
{
    protected $table = 'condicion_iva';
    public $timestamps = false;

    protected $fillable = [
        'idcondicioniva', 'nombre'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idcondicioniva = $request->input('id')!="0" ? $request->input('id') : $this->idcondicioniva;
        $this->nombre = $request->input('txtNombre');
    }
   
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.nombre'
        );

            $sql = " SELECT DISTINCT
                    A.idcondicioniva,
                    A.nombre
                    FROM condicion_iva A
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                 A.idcondicioniva,
                 A.nombre
                FROM condicion_iva A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcondicioniva) {
        $sql = "SELECT
                idcondicioniva,
                nombre
                FROM condicion_iva WHERE idcondicioniva = '$idcondicioniva'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idcondicioniva = $lstRetorno[0]->idcondicioniva;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE condicion_iva SET
            idcondicioniva='$this->idcondicioniva',
            nombre='$this->nombre'
            WHERE idcondicioniva=?";
        $affected = DB::update($sql, [$this->idcondicioniva]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM condicion_iva WHERE 
            idcondicioniva=?";
        $affected = DB::delete($sql, [$this->idcondicioniva]);
    }

    public function insertar() {
        $sql = "INSERT INTO condicion_iva (
                nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
        ]);
       return $this->idcondicioniva = DB::getPdo()->lastInsertId();
    }
   
}
