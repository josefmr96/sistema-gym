<?php

namespace App\Entidades\Alumno;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class GrupoSanguineo extends Model
{
    protected $table = 'fichamedica_gruposanguineo';
    public $timestamps = false;

    protected $fillable = [
        'idgruposanguineo',
        'tipo'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idgruposanguineo = $request->input('id')!="0" ? $request->input('id') : $this->idgruposanguineo;
        $this->tipo = $request->input('txtTipo');
    }
    public function index(){
            $titulo = "Grupo Sanguineo";
            if(Usuario::autenticado() == true){
                if(!Patente::autorizarOperacion("SANGUINEOCONSULTA")) {
                    $codigo = "SANGUINEOCONSULTA";
                    $mensaje = "No tiene permisos para la operaci&oacute;n.";
                    return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view('alumno.fichamedica-nueva', compact('titulo'));
                }
            } else {
                return redirect('login');
            }
        }

    public function obtenerFiltrado() {  
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.Tipo'
            );
            $sql = "SELECT DISTINCT
                    A.idgruposanguineo,
                    A.tipo
                    FROM fichamedica_gruposanguineo A
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND A.tipo LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idgruposanguineo,
                  A.tipo
                FROM fichamedica_gruposanguineo A ORDER BY A.tipo";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idgruposanguineo) {
        $sql = "SELECT
                idgruposanguineo,
                tipo
                FROM condicion_iva WHERE idgruposanguineo = '$idgruposanguineo'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idgruposanguineo = $lstRetorno[0]->idgruposanguineo;
            $this->tipo = $lstRetorno[0]->tipo;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE fichamedica_gruposanguineo SET
            idgruposanguineo='$this->idgruposanguineo',
            tipo='$this->tipo'
            WHERE idgruposanguineo=?";
        $affected = DB::update($sql, [$this->idgruposanguineo]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM fichamedica_gruposanguineo WHERE 
            idgruposanguineo=?";
        $affected = DB::delete($sql, [$this->idgruposanguineo]);
    }

    public function insertar() {
        $sql = "INSERT INTO fichamedica_gruposanguineo (
                tipo
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->tipo
        ]);
       return $this->idgruposanguineo = DB::getPdo()->lastInsertId();
    }
   
}
