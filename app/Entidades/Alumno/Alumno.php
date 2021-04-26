<?php

namespace App\Entidades\Alumno;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Alumno extends Model
{
    protected $table = 'alumnos';
    public $timestamps = false;

    protected $fillable = [
        'idalumno',
        'nombre',
        'apellido',
        'fecha_nac',
        'sexo',
        'correo',
        'edad',
        'telefono',
        'direccion',
        'dni',
        'cuit',
        'contacto_emergencia',
        'fk_idcondicioniva'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idalumno = $request->input('id')!="0" ? $request->input('id') : $this->idalumno;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->fecha_nac = $request->input('txtFecha_nac');
        $this->sexo = $request->input('txtSexo');
        $this->correo = $request->input('txtCorreo');
        $this->edad = $request->input('txtEdad');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->dni = $request->input('txtDni');
        $this->cuit = $request->input('txtCuit');
        $this->contacto_emergencia = $request->input('txtContacto_emergencia');
        $this->fk_idcondicioniva = $request->input('lstCondicionIva');
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                 A.idalumno,
                 A.nombre,
                 A.apellido,
                 A.fecha_nac,
                 A.sexo,
                 A.correo,
                 A.edad,
                 A.telefono,
                 A.direccion,
                 A.dni,
                 A.cuit,
                 A.contacto_emergencia,
                 A.fk_idcondicioniva
                FROM alumnos A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'fk_idcondicioniva',
           2 => 'A.apellido',
           3 => 'A.fecha_nac',
           4 => 'A.sexo',
           5 => 'A.correo',
           6 => 'A.edad',
           7 => 'A.telefono',
           8 => 'A.direccion',
           9 => 'A.dni',
           10 => 'A.cuit',
           11 => 'A.contacto_emergencia'
            );
        $sql = "SELECT DISTINCT
        A.idalumno,
        A.nombre,
        A.apellido,
        A.fecha_nac,
        A.sexo,
        A.correo,
        A.edad,
        A.telefono,
        A.direccion,
        A.dni,
        A.cuit,
        A.contacto_emergencia,
        B.nombre as condicion
        FROM alumnos A        
         LEFT JOIN condicion_iva B ON idcondicioniva = fk_idcondicioniva
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

    public function obtenerPorId($idalumno) {
        $sql = "SELECT
                idalumno,
                nombre,
                apellido,
                fecha_nac,
                sexo,
                correo,
                edad,
                telefono,
                direccion,
                dni,
                cuit,
                contacto_emergencia,
                fk_idcondicioniva
                FROM alumnos WHERE idalumno = '$idalumno'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idalumno = $lstRetorno[0]->idalumno;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->fecha_nac = $lstRetorno[0]->fecha_nac;
            $this->sexo = $lstRetorno[0]->sexo;
            $this->correo = $lstRetorno[0]->correo;
            $this->edad = $lstRetorno[0]->edad;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->dni = $lstRetorno[0]->dni;
            $this->cuit = $lstRetorno[0]->cuit;
            $this->contacto_emergencia = $lstRetorno[0]->contacto_emergencia;
            $this->fk_idcondicioniva = $lstRetorno[0]->fk_idcondicioniva;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE alumnos SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            fecha_nac='$this->fecha_nac',
            sexo='$this->sexo',
            correo='$this->correo',
            edad='$this->edad',
            telefono='$this->telefono',
            direccion='$this->direccion',
            dni='$this->dni',
            cuit='$this->cuit',
            contacto_emergencia='$this->contacto_emergencia',
            fk_idcondicioniva='$this->fk_idcondicioniva'
            WHERE idalumno=?";
        $affected = DB::update($sql, [$this->idalumno]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM alumnos WHERE 
            idalumno=?";
        $affected = DB::delete($sql, [$this->idalumno]);
    }

    public function insertar() {
        $sql = "INSERT INTO alumnos (
                nombre,
                apellido,
                fecha_nac,
                sexo,
                correo,
                edad,
                telefono,
                direccion,
                dni,
                cuit,
                contacto_emergencia,
                fk_idcondicioniva
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->apellido, 
            $this->fecha_nac, 
            $this->sexo, 
            $this->correo,
            $this->edad,
            $this->telefono,
            $this->direccion,
            $this->dni,
            $this->cuit,
            $this->contacto_emergencia,
            $this->fk_idcondicioniva
        ]);
       return $this->idalumno = DB::getPdo()->lastInsertId();
    }

}
