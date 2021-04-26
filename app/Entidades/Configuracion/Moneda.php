<?php

namespace App\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Moneda extends Model
{
    protected $table = 'public_moneda';
    public $timestamps = false;

    protected $fillable = [
        'idmoneda', 'nombre', 'simbolo'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idmoneda = $request->input('id')!="0" ? $request->input('id') : $this->idmoneda;
        $this->nombre = $request->input('txtNombre');
        $this->simbolo = $request->input('txtSimbolo');
    }

  public function obtenerFiltrado() { 
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'A.simbolo'
            );
        $sql = "SELECT DISTINCT
                    A.idmoneda,
                    A.nombre,
                    A.simbolo
                    FROM public_moneda A
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" OR  A.idmoneda LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR  B.simbolo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR  B.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idmoneda,
                  A.nombre,
                  A.simbolo
                FROM public_moneda A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idmoneda) {
        $sql = "SELECT
                idmoneda,
                nombre,
                simbolo
                FROM public_moneda WHERE idmoneda = '$idmoneda'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idmoneda = $lstRetorno[0]->idmoneda;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->simbolo = $lstRetorno[0]->simbolo;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public_moneda SET
            idmoneda = '$this->idmoneda',
            nombre = $this->nombre,
            simbolo = $this->simbolo
            WHERE idmoneda=?";
        $affected = DB::update($sql, [$this->idmoneda]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public_moneda WHERE 
            idmoneda = ?";
        $affected = DB::delete($sql, [$this->idmoneda]);
    }

    public function insertar() {
        $sql = "INSERT INTO public_moneda (
                nombre,
                simbolo
            ) VALUES (?,?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->simbolo
        ]);
       return $this->idmoneda = DB::getPdo()->lastInsertId();
    }
   
}
