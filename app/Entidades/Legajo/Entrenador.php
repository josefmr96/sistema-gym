<?php

namespace App\Entidades\Legajo;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Entrenador extends Model
{
    protected $table = 'entrenadores';
    public $timestamps = false;

    protected $fillable = [
        'identrenador', 'nombre', 'apellido', 'sexo', 'correo', 'fecha_nacimiento', 'telefono','peso','altura','especialidad', 'foto'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->identrenador = $request->input('id')!="0" ? $request->input('id') : $this->identrenador;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->sexo = $request->input('txtSexo') != "" ? $request->input('txtSexo') : 0;
        $this->correo = $request->input('txtCorreo');
        $this->fecha_nacimiento = $request->input('txtFechaNac');
        $this->telefono = $request->input('txtTelefono');
        $this->peso = $request->input('txtPeso');
        $this->altura = $request->input('txtAltura');
        $this->especialidad = $request->input('txtEspecialidad');
    }
    

    public function obtenerFiltrado() {  
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'A.apellido',
           2 => 'A.correo'
            );
                $sql = "SELECT DISTINCT
                A.identrenador,
                    A.nombre,
                    A.apellido,
                    A.sexo,
                    A.correo,
                    A.fecha_nacimiento,
                    A.telefono,
                    A.peso,
                    A.altura,
                    A.especialidad, 
                    A.foto
                FROM entrenadores A
            WHERE 1=1
                        ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.correo LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                    identrenador,
                    nombre,
                    apellido,
                    sexo,
                    correo,
                    fecha_nacimiento,
                    telefono,
                    peso,
                    altura,
                    especialidad, 
                    foto
                FROM entrenadores ";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($identrenador) {
        $sql = "SELECT
                identrenador,
                nombre,
                apellido,
                sexo,
                correo,
                fecha_nacimiento,
                telefono,
                peso,
                altura,
                especialidad,
                foto
                FROM entrenadores WHERE identrenador = '$identrenador'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->identrenador = $lstRetorno[0]->identrenador;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->sexo = $lstRetorno[0]->sexo;
            $this->correo = $lstRetorno[0]->correo;
            $this->fecha_nacimiento = $lstRetorno[0]->fecha_nacimiento;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->peso = $lstRetorno[0]->peso;
            $this->altura = $lstRetorno[0]->altura;
            $this->especialidad = $lstRetorno[0]->especialidad;
            $this->foto = $lstRetorno[0]->foto;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE entrenadores SET
            identrenador = $this->identrenador,
            nombre = '$this->nombre',
            apellido = '$this->apellido',
            sexo = '$this->sexo',
            correo = '$this->correo',
            fecha_nacimiento = '$this->fecha_nacimiento',
            telefono = '$this->telefono',
            peso = $this->peso,
            altura = $this->altura,
            especialidad = '$this->especialidad',
            foto = '$this->foto'
            WHERE identrenador = ?";
        $affected = DB::update($sql, [$this->identrenador]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM entrenadores WHERE 
            identrenador=?";
        $affected = DB::delete($sql, [$this->identrenador]);
    }

    public function insertar() {
        $sql = "INSERT INTO entrenadores (
                nombre,
                apellido,
                sexo,
                correo,
                fecha_nacimiento,
                telefono,
                peso,
                altura,
                especialidad,
                foto
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->apellido, 
            $this->sexo, 
            $this->correo,
            $this->fecha_nacimiento,
            $this->telefono,
            $this->peso,
            $this->altura,
            $this->especialidad,
            $this->foto
        ]);
       return $this->identrenador = DB::getPdo()->lastInsertId();
    }

}
