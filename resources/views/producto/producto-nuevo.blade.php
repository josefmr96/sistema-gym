@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/productos">Producto</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/home";
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
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>Nombre:</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $producto->nombre or '' }}">
            </div>
            <div class="form-group col-lg-6">
                <label>Categoria:</label>
                <select id="lstCategoria" name="lstCategoria" class="form-control">
                    <option selected value="0">-</option>
                    @for ($i = 0; $i < count($array_categorias); $i++) @if (isset($categoria) and $array_categorias[$i]->idcategoria == $categoria->idcategoria)
                        <option selected value="{{ $array_categorias[$i]->idcategoria }}">{{ $array_categorias[$i]->nombre }}</option>
                        @else
                        <option value="{{ $array_categorias[$i]->idcategoria }}">{{ $array_categorias[$i]->nombre }}</option>
                        @endif
                        @endfor
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Carga horaria:</label>
                <input type="number" id="txtCargaHoraria" name="txtCargaHoraria" class="form-control" value="{{ $producto->carga_horaria or '' }}">
            </div>
            <div class="form-group col-lg-6">
                <label>Fecha de Inicio: </label>
                <input type="date" id="txtFechaInicio" name="txtFechaInicio" class="form-control" value="{{ $producto->fecha_inicio or '' }}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Fecha de Fin:</label>
                <input type="date" id="txtFechaFin" name="txtFechaFin" class="form-control" value="{{ $producto->fecha_fin or '' }}">
            </div>
            <div class="form-group col-lg-6">
                <label>Dias de la semana:</label>
                <input type="text" id="txtDiasSemana" name="txtDiasSemana" class="form-control" value="{{ $producto->dias_semana or '' }}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Horario de Inicio:</label>
                <input type="time" id="txtHoraInicio" name="txtHoraInicio" class="form-control" value="{{ $producto->hora_inicio or '' }}">
            </div>
            <div class="form-group col-lg-6">
                <label>Horario de Fin:</label>
                <input type="time" id="txtHoraFin" name="txtHoraFin" class="form-control" value="{{ $producto->hora_fin or '' }}">
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
            url: "{{ asset('/admin/producto/eliminar') }}",
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