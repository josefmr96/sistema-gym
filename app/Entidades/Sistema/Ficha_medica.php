<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class FichaMedica extends Model
{
    protected $table = 'fichamedica_alumno';
    public $timestamps = false;

    protected $fillable = [
        'idfichamedica',
        'peso',
        'altura',
        'masa_muscular',
        'operaciones',
        'archivo_apto',
        'edadmetabolica',
        'fk_idhistorico',
        'fk_idgruposanguineo'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idfichamedica = $request->input('id')!="0" ? $request->input('id') : $this->idfichamedica;
        $this->peso = $request->input('txtPeso');
        $this->altura = $request->input('txtAltura');
        $this->masa_muscular = $request->input('txtMasaMuscular') != "" ? $request->input('txtMasamuscular') : 0;
        $this->operaciones = $request->input('txtOperaciones');
        $this->archivo_apto = $request->input('txtArchivoApto');
        $this->edadmetabolica = $request->input('txtEdadMetabolica');
        $this->fk_idhistorico = $request->input('lstHistorico');
        $this->fk_idgruposanguineo = $request->input('txtGrupoSanguineo');
    }


    public function obtenerTodos() {
        $sql = "SELECT 
                  idfichamedica,
                  peso,
                  altura,
                  masa_muscular,
                  operaciones,
                  archivo_apto,
                  edadmetabolica,
                  fk_idhistorico,
                  fk_idgruposanguineo
                FROM fichamedica_alumno";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idfichamedica) {
        $sql = "SELECT
                idfichamedica,
                peso,
                altura,
                masa_muscular,
                operaciones,
                archivo_apto,
                edadmetabolica,
                fk_idhistorico,
                fk_idgruposanguineo
                FROM fichamedica_alumno 
                WHERE idfichamedica = '$idfichamedica'";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idfichamedica = $lstRetorno[0]->idfichamedica;
            $this->peso = $lstRetorno[0]->peso;
            $this->altura = $lstRetorno[0]->altura;
            $this->masa_muscular = $lstRetorno[0]->masa_muscular;
            $this->operaciones = $lstRetorno[0]->operaciones;
            $this->archivo_apto = $lstRetorno[0]->archivo_apto;
            $this->edadmetabolica = $lstRetorno[0]->edadmetabolica;
            $this->fk_idhistorico = $lstRetorno[0]->fk_idhistorico;
            $this->fk_idgruposanguineo = $lstRetorno[0]->fk_idgruposanguineo;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE fichamedica_alumno SET
            peso='$this->peso',
            altura='$this->altura',
            masa_muscular=$this->masa_muscular,
            operaciones='$this->operaciones',
            archivo_apto='$this->archivo_apto',
            edadmetabolica='$this->edadmetabolica',
            fk_idhistorico='$this->fk_idhistorico',
            fk_idgruposanguineo='$this->fk_idgruposanguineo'
            WHERE idfichamedica=?";
        $affected = DB::update($sql, [$this->idfichamedica]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM fichamedica_alumno WHERE 
            idfichamedica=?";
        $affected = DB::delete($sql, [$this->idfichamedica]);
    }

    public function insertar() {
        $sql = "INSERT INTO fichamedica_alumno (
                peso,
                altura,
                masa_muscular,
                operaciones,
                archivo_apto,
                edadmetabolica,
                fk_idhistorico,
                fk_idgruposanguineo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->peso, 
            $this->altura, 
            $this->masa_muscular, 
            $this->operaciones, 
            $this->archivo_apto,
            $this->edadmetabolica,
            $this->fk_idhistorico,
            $this->fk_idgruposanguineo
        ]);
       return $this->idfichamedica = DB::getPdo()->lastInsertId();
    }

}
