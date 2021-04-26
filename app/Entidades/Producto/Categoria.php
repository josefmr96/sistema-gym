<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = [
        'idcategoria',
         'nombre',
         'fk_idcategoriapadre',
         'descripcion',
         'foto'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idcategoria = $request->input('id')!="0" ? $request->input('id') : $this->idcategoria;
        $this->nombre = $request->input('txtNombre');
        $this->fk_idcategoriapadre = $request->input('lstCondicionIva')!="0" ? $request->input('lstCondicionIva') : $this->fk_idcategoriapadre;
        $this->descripcion = $request->input('txtDescripcion');
    }
    public function obtenerCategoriaPadre() {
        $sql = "SELECT DISTINCT
                  A.idcategoria,
                  A.nombre
                FROM categorias A
                WHERE A.fk_idcategoriapadre = 0";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'B.nombre'
            );
        $sql = "SELECT DISTINCT
                    A.idcategoria,
                    A.nombre,
                    B.nombre as padre,
                    A.descripcion,
                    A.foto
                    FROM categorias A
                    LEFT JOIN categorias B ON A.fk_idcategoriapadre = B.idcategoria
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


    public function obtenerTodos() {
        $sql = "SELECT 
                idcategoria,
                nombre,
                fk_idcategoriapadre,
                descripcion,
                foto
                FROM categorias";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcategoria) {
        $sql = "SELECT
                idcategoria,
                nombre,
                fk_idcategoriapadre,
                descripcion,
                foto
                FROM categorias WHERE idcategoria = '$idcategoria'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->fk_idcategoriapadre = $lstRetorno[0]->fk_idcategoriapadre;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->foto = $lstRetorno[0]->foto;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE categorias SET
            nombre='$this->nombre',
            fk_idcategoriapadre='$this->fk_idcategoriapadre' '0',
            descripcion='$this->descripcion',
            foto='$this->foto'
            WHERE idcategoria=?";
        $affected = DB::update($sql, [$this->idcategoria]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM categorias WHERE 
            idcategoria=?";
        $affected = DB::delete($sql, [$this->idcategoria]);
    }

    public function insertar() {
        $sql = "INSERT INTO categorias (
                nombre,
                fk_idcategoriapadre,
                descripcion,
                foto
            ) VALUES (?,?,?,?);";
       $result = DB::insert($sql, [
            $this->nombre,
            $this->fk_idcategoriapadre,
            $this->descripcion,
            $this->foto
        ]);
       return $this->idcategoria = DB::getPdo()->lastInsertId();
    }

}
