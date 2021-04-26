<?php

namespace App\Entidades\Pagos;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Pago extends Model
{
    protected $table = 'pagos';
    public $timestamps = false;

    protected $fillable = [
        'idpago', 'fecha', 'importe', 'fk_idalumno', 'fk_idcobro', 'fk_idmediodepago', 'fk_idestado'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idpago = $request->input('id')!="0" ? $request->input('id') : $this->idpago;
        $this->fecha = $request->input('txtFecha');
        $this->importe = $request->input('txtImporte') != "" ? $request->input('txtImporte') : 0;
        $this->fk_idalumno = $request->input('lstAlumno');
        $this->fk_idcobro = $request->input('lstCobro')!="0" ? $request->input('lstCobro') : $this->fk_idcobro;
        $this->fk_idmediodepago = $request->input('lstMedioDePago');
        $this->fk_idestado = $request->input('lstEstado');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.fecha',
           1 => 'A.importe',
           2 => 'A.fk_idalumno',
           3 => 'A.fk_idcobro',
           4 => 'A.fk_idmediodepago',
           5 => 'B.idalumno',
           6 => 'C.idcobro',
           7 => 'D.idmediodepago',
           8 => 'A.fk_idestado',
           9 => 'E.idpagoestado'
            );
        $sql = "SELECT DISTINCT
                    A.idpago, 
                    A.fecha,
                    A.importe,
                    A.fk_idalumno,
                    A.fk_idcobro,
                    A.fk_idmediodepago,
                    A.fk_idestado,
                    B.idalumno,
                    B.nombre AS nombre_alumno,
                    C.idcobro,
                    D.idmediodepago,
                    D.nombre AS nombre_mediodepago,
                    E.idpagoestado,
                    E.nombre AS nombre_pagoestado
                    FROM pagos A
                    LEFT JOIN alumnos B  ON A.fk_idalumno = B.idalumno
                    LEFT JOIN cobros C ON A.fk_idcobro = C.idcobro
                    LEFT JOIN medios_de_pago D ON A.fk_idmediodepago = D.idmediodepago
                    LEFT JOIN pago_estados E ON A.fk_idestado = E.idpagoestado
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.idalumno LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.idcobro LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  idpago,
                  fecha
                FROM pagos";

        $sql .= " ORDER BY fecha_origen";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idpago) {
        $sql = "SELECT
                    idpago, 
                    fecha,
                    importe,
                    fk_idalumno,
                    fk_idcobro,
                    fk_idmediodepago,
                    fk_idestado
                FROM pagos WHERE idpago = '$idpago'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idpago = $lstRetorno[0]->idpago;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->importe = $lstRetorno[0]->importe;
            $this->fk_idalumno = $lstRetorno[0]->fk_idalumno;
            $this->fk_idcobro = $lstRetorno[0]->fk_idcobro;
            $this->fk_idmediodepago = $lstEntrenador[0]->fk_idmediodepago;
            $this->fk_idestado = $lstEstado[0]->fk_idestado;
            return $this;
        }
        return null;
    }

    public  function eliminar() {
        $sql = "DELETE FROM pagos WHERE 
            idcobro=?";
        $affected = DB::delete($sql, [$this->idcobro]);
    }

    public function insertar() {
        $sql = "INSERT INTO pagos (
                fecha,
                importe,
                fk_idalumno,
                fk_idcobro,
                fk_idmediodepago,
                fk_idestado
            ) VALUES (?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fecha, 
            $this->importe, 
            $this->fk_idalumno,
            $this->fk_idcobro,
            $this->fk_idmediodepago,
            $this->fk_idestado
        ]);
       return $this->idpago = DB::getPdo()->lastInsertId();
    }
    

    public function guardar() {
        $sql = "UPDATE pagos SET
            fecha='$this->fecha',
            importe='$this->importe',
            fk_idalumno=$this->fk_idalumno,
            fk_idcobro='$this->fk_idcobro',
            fk_idmediodepago='$this->fk_idmediodepago',
            fk_idestado='$this->fk_idestado'
            WHERE idpago=?";
        $affected = DB::update($sql, [$this->idpago]);
    }

}


?>