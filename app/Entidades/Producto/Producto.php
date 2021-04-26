<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombre', 'fk_idcategoria', 'carga_horaria', 'fecha_inicio', 'fecha_fin', 'dias_semana', 'hora_inicio', 'hora_fin' 
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id')!="0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->fk_idcategoria = $request->input('lstCategoria');
        $this->carga_horaria = $request->input('txtCargaHoraria');
        $this->fecha_inicio = $request->input('txtFechaInicio') != "" ? $request->input('txtFechaInicio') : 0;
        $this->fecha_fin = $request->input('txtFechaFin');
        $this->dias_semana = $request->input('txtDiasSemana');
        $this->hora_inicio = $request->input('txtHoraInicio');
        $this->hora_fin = $request->input('txtHoraFin');
        
    }


    public function obtenerTodos() {
        $sql = "SELECT 
                     A.idproducto,
                    A.nombre,
                    A.fk_idcategoria,
                    A.carga_horaria,
                    A.fecha_inicio,
                    A.fecha_fin,
                    A.dias_semana,
                    A.hora_inicio,
                    A.hora_fin,
                    B.nombre as categoria
                    FROM productos A
                    LEFT JOIN categorias B ON A.fk_idcategoria = B.idcategoria
                WHERE 1=1 ORDER BY nombre
                ";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idproducto) {
        $sql = "SELECT
                idproducto,
                nombre,
                fk_idcategoria,
                carga_horaria,
                fecha_inicio,
                fecha_fin,
                dias_semana,
                hora_inicio,
                hora_fin
                FROM productos WHERE idproducto = '$idproducto'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
            $this->carga_horaria = $lstRetorno[0]->carga_horaria;
            $this->fecha_inicio = $lstRetorno[0]->fecha_inicio;
            $this->fecha_fin = $lstRetorno[0]->fecha_fin;
            $this->dias_semana = $lstRetorno[0]->dias_semana;
            $this->hora_inicio = $lstRetorno[0]->hora_inicio;
            $this->hora_fin = $lstRetorno[0]->hora_fin;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE productos SET
            nombre='$this->nombre',
            fk_idcategoria='$this->fk_idcategoria',
            carga_horaria='$this->carga_horaria',
            fecha_inicio='$this->fecha_inicio',
            fecha_fin='$this->fecha_fin',
            dias_semana='$this->dias_semana',
            hora_inicio='$this->hora_inicio',
            hora_fin='$this->hora_fin'
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM productos WHERE 
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }


    public function insertar() {
        $sql = "INSERT INTO productos (
                nombre,
                fk_idcategoria,
                carga_horaria,
                fecha_inicio,
                fecha_fin,
                dias_semana,
                hora_inicio,
                hora_fin
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre,
            $this->fk_idcategoria, 
            $this->carga_horaria, 
            $this->fecha_inicio, 
            $this->fecha_fin,
            $this->dias_semana,
            $this->hora_inicio,
            $this->hora_fin
        ]);
       return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'B.nombre',
           2 => 'A.carga_horaria',
           3 => 'A.fecha_inicio',
           4 => 'A.fecha_fin',
           5 => 'A.dias_semana',
           6 => 'A.hora_inicio',
           7 => 'A.hora_fin'
            );
        $sql = "SELECT DISTINCT
                    A.idproducto,
                    A.nombre,
                    A.fk_idcategoria,
                    A.carga_horaria,
                    A.fecha_inicio,
                    A.fecha_fin,
                    A.dias_semana,
                    A.hora_inicio,
                    A.hora_fin,
                    B.nombre as categoria
                    FROM productos A
                    LEFT JOIN categorias B ON A.fk_idcategoria = B.idcategoria
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND  A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
