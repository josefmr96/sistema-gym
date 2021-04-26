@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($alumno->idalumno) && $alumno->idalumno > 0 ? $alumno->idalumno : 0; ?>';
    <?php $globalId = isset($alumno->idalumno) ? $alumno->idalumno : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/alumno/alumnos">Alumno</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/alumno/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Ficha Medica" href="/admin/alumno/fichamedica/<?php echo isset($alumno->idalumno) && $alumno->idalumno > 0 ? $alumno->idalumno : 0; ?>" class="fa fa-plus-circle" aria-hidden="true"><span>Ficha Medica</span></a></li>
    <li class="btn-item"><a title="Dieta Semanal" href="/admin/alumno/dieta/<?php echo isset($alumno->idalumno) && $alumno->idalumno > 0 ? $alumno->idalumno : 0; ?>" class="fa fa-plus-circle" aria-hidden="true"><span>Dieta Semanal</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/alumno/nuevo";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
        if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
        }
        ?>
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $alumno->nombre or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Apellido: *</label>
                    <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{ $alumno->apellido or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de nacimiento: *</label>
                    <input type="date" id="txtFecha_nac" name="txtFecha_nac" class="form-control" value="{{ $alumno->fecha_nac or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Sexo: *</label>
                    <input type="text" id="txtSexo" name="txtSexo" class="form-control" value="{{ $alumno->sexo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Edad: *</label>
                    <input type="text" id="txtEdad" name="txtEdad" class="form-control" value="{{ $alumno->edad or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Telefono:</label>
                    <input type="number" id="txtTelefono" name="txtTelefono" class="form-control" value="{{ $alumno->telefono or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Correo: *</label>
                    <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{ $alumno->correo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Condicion IVA: *</label>
                    <select id="lstCondicionIva" name="lstCondicionIva" class="form-control" >
                        <option selected value="0">-</option>

                        @for ($i = 0; isset($array_condicionIva) && $i < count($array_condicionIva); $i++)
                            @if (isset($alumno) and $array_condicionIva[$i]->idcondicioniva == $alumno->fk_idcondicioniva)
                            
                                <option selected value="{{ $array_condicionIva[$i]->idcondicioniva }}">{{ $array_condicionIva[$i]->nombre }}</option>
                            @else
                                <option value="{{ $array_condicionIva[$i]->idcondicioniva }}">{{ $array_condicionIva[$i]->nombre }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Direccion: *</label>
                    <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="{{ $alumno->direccion or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>DNI: *</label>
                    <input type="text" id="txtDni" name="txtDni" class="form-control" value="{{ $alumno->dni or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>CUIT: *</label>
                    <input type="text" id="txtCuit" name="txtCuit" class="form-control" value="{{ $alumno->cuit or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Contacto de emergencia: *</label>
                    <input type="text" id="txtContacto_emergencia" name="txtContacto_emergencia" class="form-control" value="{{ $alumno->contacto_emergencia or ''}}" required>
                </div>
            </div>
            </div>
        </form>
        </div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">¿Deseas eliminar el registro actual?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
            </div>
        </div>
    </div>
</div>
<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    
    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('/admin/alumno/eliminar') }}",
            data: {
                id: globalId
            },
            async: true,
            dataType: "json",
            success: function(data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>
@endsection