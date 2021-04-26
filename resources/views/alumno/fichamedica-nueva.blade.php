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
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/alumno/nuevo">Alumno</a></li>
    <li class="breadcrumb-item active">Ficha Medica</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/producto/nuevo";
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
    <div id="msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
    <form id="form1" method="POST" enctype="multipart/form-data">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" name="lstIdalumno" value="{{$fichamedica->fk_idalumno}}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>Peso: *</label>
                <input type="number" id="txtPeso" name="txtPeso" class="form-control" value="{{$fichamedica->peso or ''}}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>Altura: *</label>
                <input type="number" id="txtAltura" name="txtAltura" class="form-control" value="{{$fichamedica->altura or ''}}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>Masa Muscular: *</label>
                <input type="number" id="txtMasa" name="txtMasa" class="form-control" value="{{$fichamedica->masa_muscular or ''}}" required>
            </div>
            <div class="form-group col-lg-6">
                <label>Edad Metabolica: *</label>
                <input type="number" id="txtEdadMeta" name="txtEdadMeta" class="form-control" value="{{$fichamedica->edadmetabolica or ''}}" required>
            </div>
            <div class="form-group col-lg-6">
            <label>Fecha Apto: * </label>
                <input type="date" id="txtFechaApto" name="txtFechaApto" class="form-control" value="{{$fichamedica->fecha_apto or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Grupo Sanguineo: *</label>
                <select id="lstGrupoSanguineo" name="lstGrupoSanguineo" class="form-control">
                    <option selected value="0">-</option>
                    @for ($i = 0; isset($array_gruposanguineo) && $i < count($array_gruposanguineo); $i++)
                            @if (isset($gruposanguineo) and $array_gruposanguineo[$i]->idgruposanguineo == $gruposanguineo->fk_idgruposanguineo)
                                <option selected value="{{ $array_gruposanguineo[$i]->idgruposanguineo }}">{{ $array_gruposanguineo[$i]->tipo }}</option>
                            @else
                                <option value="{{ $array_gruposanguineo[$i]->idgruposanguineo }}">{{ $array_gruposanguineo[$i]->tipo }}</option>
                            @endif
                        @endfor

                </select>
            </div>
            <div class="form-group col-lg-6">
            <label>Operaciones: * </label>
                <input type="text" id="txtOperaciones" name="txtOperaciones" class="form-control" value="{{$fichamedica->operaciones or ''}}">
            </div>
            <div class="form-group col-lg-6">
                    <label>Apto fisico: *</label>
                    <input type="file" id="archivo" name="archivo" class="form-control" >
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
                        url: "{{ asset('sistema/menu/eliminar') }}",
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