<?php

namespace App\Entidades\Cobros;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Cobro extends Model
{
    protected $table = 'cobros';
    public $timestamps = false;

    protected $fillable = [
        'idcobro', 'fecha_origen', 'fecha_vto', 'importe', 'concepto', 'fk_idalumno', 'fk_idmedio', 'fk_identrenador', 'fk_idproducto'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idcobro = $request->input('id')!="0" ? $request->input('id') : $this->idcobro;
        $this->fecha_origen = $request->input('txtFechaOrigen');
        $this->fecha_vto = $request->input('txtFechaVto');
        $this->importe = $request->input('txtImporte') != "" ? $request->input('txtImporte') : 0;
        $this->concepto = $request->input('txtConcepto');
        $this->fk_idalumno = $request->input('lstAlumno');
        $this->fk_idmedio = $request->input('lstMedio');
        $this->fk_identrenador = $request->input('lstEntrenador');
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idmoneda = $request->input('lstMoneda');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.fecha_origen',
           1 => 'A.fecha_vto',
           2 => 'A.importe',
           3 => 'A.concepto',
           4 => 'A.fk_idalumno',
           5 => 'A.fk_idmedio',
           6 => 'A.fk_identrenador',
           7 => 'A.fk_idproducto',
           8 => 'A.fk_idmoneda',
           9 => 'B.idalumno',
           10 => 'C.idmediodepago',
           11 => 'D.identrenador',
           12 => 'E.idproducto',
           13 => 'F.idmoneda'
            );
        $sql = "SELECT DISTINCT
                    A.idcobro, 
                    A.fecha_origen,
                    A.fecha_vto,
                    A.importe,
                    A.concepto,
                    A.fk_idalumno,
                    A.fk_idmedio,
                    A.fk_identrenador,
                    A.fk_idproducto,
                    A.fk_idmoneda,
                    B.idalumno,
                    B.nombre AS nombre_alumno,
                    C.idmediodepago,
                    C.nombre AS nombre_mediodepago,
                    D.identrenador,
                    D.nombre AS nombre_entrenador,
                    E.idproducto,
                    E.nombre AS nombre_producto,
                    F.idmoneda,
                    F.nombre AS nombre_moneda
                    FROM cobros A
                    LEFT JOIN alumnos B  ON A.fk_idalumno = B.idalumno
                    LEFT JOIN medios_de_pago C ON A.fk_idmedio = C.idmediodepago
                    LEFT JOIN entrenadores D ON A.fk_identrenador = D.identrenador
                    LEFT JOIN productos E ON A.fk_idproducto = E.idproducto
                    LEFT JOIN public_moneda F ON A.fk_idmoneda = F.idmoneda
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.fecha_origen LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.idalumno LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR D.identrenador LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  idcobro,
                  fecha_origen
                FROM cobros";

        $sql .= " ORDER BY fecha_origen";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcobro) {
        $sql = "SELECT
                idcobro,
                fecha_origen,
                fecha_vto,
                importe,
                concepto,
                fk_idalumno,
                fk_idmedio,
                fk_identrenador,
                fk_idproducto,
                fk_idmoneda
                FROM cobros WHERE idcobro = '$idcobro'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idcobro = $lstRetorno[0]->idcobro;
            $this->fecha_origen = $lstRetorno[0]->fecha_origen;
            $this->fecha_vto = $lstRetorno[0]->fecha_vto;
            $this->importe = $lstRetorno[0]->importe;
            $this->concepto = $lstRetorno[0]->concepto;
            $this->fk_idalumno = $lstRetorno[0]->fk_idalumno;
            $this->fk_idmedio = $lstRetorno[0]->fk_idmedio;
            $this->fk_identrenador = $lstRetorno[0]->fk_identrenador;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idmoneda = $lstRetorno[0]->fk_idmoneda;
            return $this;
        }
        return null;
    }

    public  function eliminar() {
        $sql = "DELETE FROM cobros WHERE 
            idcobro=?";
        $affected = DB::delete($sql, [$this->idcobro]);
    }

    public function insertar() {
        $sql = "INSERT INTO cobros (
                fecha_origen,
                fecha_vto,
                importe,
                concepto,
                fk_idalumno,
                fk_idmedio,
                fk_identrenador,
                fk_idproducto,
                fk_idmoneda
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fecha_origen, 
            $this->fecha_vto, 
            $this->importe, 
            $this->concepto, 
            $this->fk_idalumno,
            $this->fk_idmedio,
            $this->fk_identrenador,
            $this->fk_idproducto,
            $this->fk_idmoneda
        ]);
       return $this->idcobro = DB::getPdo()->lastInsertId();
    }
    
    public function guardar() {
        $sql = "UPDATE cobros SET
            fecha_origen='$this->fecha_origen',
            fecha_vto='$this->fecha_vto',
            importe='$this->importe',
            concepto='$this->concepto',
            fk_idalumno='$this->fk_idalumno',
            fk_idmedio='$this->fk_idmedio',
            fk_identrenador='$this->fk_identrenador',
            fk_idproducto='$this->fk_idproducto',
            fk_idmoneda='$this->fk_idmoneda'
            WHERE idcobro=?";
        $affected = DB::update($sql, [$this->idcobro]);
    }


}


?>