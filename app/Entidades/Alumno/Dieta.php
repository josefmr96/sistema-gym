<?php

namespace App\Entidades\Alumno;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;


class Dieta extends Model
{
    protected $table = 'dietasemanal';
    public $timestamps = false;

    protected $fillable = [
        'iddieta', 'desayuno', 'almuerzo', 'merienda', 'cena', 'fk_iddia', 'fk_idalumno'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->iddieta = $request->input('id')!="0" ? $request->input('id') : $this->iddieta;
        $this->desayuno = $request->input('txtDesayuno');
        $this->almuerzo = $request->input('txtAlmuerzo');
        $this->merienda = $request->input('txtMerienda') != "" ? $request->input('txtMerienda') : 0;
        $this->cena = $request->input('txtCena');
        $this->fk_iddia = $request->input('lstDias');
        $this->fk_idalumno = $request->input('lstAlumnos');
    }
    public function obtenerTodos() {
        $sql = "SELECT 
        A.iddieta,
        A.desayuno,
        A.almuerzo,
        A.merienda,
        A.cena,
        B.nombre AS dia,
        C.nombre AS alumno
      FROM dietasemanal A
       LEFT JOIN dias B ON iddia = fk_iddia
       LEFT JOIN alumnos C ON idalumno = fk_idalumno
       
WHERE 1=1";

        $sql .= " ORDER BY A.desayuno";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

       
    public function obtenerPorId($iddieta) {
        $sql = "SELECT
                iddieta,
                desayuno,
                almuerzo,
                merienda,
                cena,
                fk_iddia,
                fk_idalumno
                
                FROM dietasemanal WHERE iddieta = '$iddieta'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->iddieta = $lstRetorno[0]->iddieta;
            $this->desayuno = $lstRetorno[0]->desayuno;
            $this->almuerzo = $lstRetorno[0]->almuerzo;
            $this->merienda = $lstRetorno[0]->merienda;
            $this->cena = $lstRetorno[0]->cena;
            $this->fk_iddia = $lstRetorno[0]->fk_iddia;
            $this->fk_idalumno = $lstRetorno[0]->fk_idalumno;
            
            return $this;
        }
        return null;
    }
    public function guardar() {
        $sql = "UPDATE dietasemanal SET
            desayuno='$this->desayuno',
            almuerzo='$this->almuerzo',
            merienda='$this->merienda',
            cena='$this->cena',
            fk_iddia='$this->fk_iddia'
            WHERE iddieta=?";
        $affected = DB::update($sql, [$this->iddieta]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM dietasemanal WHERE 
            iddieta=?";
        $affected = DB::delete($sql, [$this->iddieta]);
    }

    public function insertar() {
        $sql = "INSERT INTO dietasemanal (
                desayuno,
                almuerzo,
                merienda,
                cena,
                fk_iddia,
                fk_idalumno
                
            ) VALUES (?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->desayuno, 
            $this->almuerzo, 
            $this->merienda, 
            $this->cena, 
            $this->fk_iddia,
            $this->fk_idalumno
           
        ]);
       return $this->iddieta = DB::getPdo()->lastInsertId();
    }

}
