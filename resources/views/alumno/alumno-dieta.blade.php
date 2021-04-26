@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($dieta->iddieta) && $dieta->iddieta > 0 ? $dieta->iddieta : 0; ?>';
    <?php $globalId = isset($dieta->iddieta) ? $dieta->iddieta : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/alumno/dieta">Men&uacute;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/alumno/dieta" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/alumno/dieta";
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
        </div>
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Desayuno: *</label>
                    <input type="text" id="txtDesayuno" name="txtDesayuno" class="form-control" value="{{$dieta->desayuno or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Almuerzo:</label>
                    <input type="text" id="txtAlmuerzo" name="txtAlmuerzo" class="form-control" value="{{$dieta->almuerzo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Merienda:</label>
                    <input type="text" id="txtMerienda" name="txtMerienda" class="form-control" value="{{$dieta->merienda or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Cena:</label>
                    <input type="text" id="txtCena" name="txtCena" class="form-control" value="{{$dieta->cena or ''}}" required>
                </div>
            </div>
            <div class="form-group col-lg-6">
                    <label>Dias Semanales: *</label>
                    <select id="lstDias" name="lstDias" class="form-control">
                        <option selected value="0">-</option>
                        @for ($i = 0; isset($array_diasSemanales) && $i < count($array_diasSemanales); $i++)
                            @if (isset($dieta) and $array_diasSemanales[$i]->iddieta == $dieta->fk_iddia)
                                <option selected value="{{ $array_diasSemanales[$i]->iddieta }}">{{ $array_diasSemanales[$i]->dia }}</option>
                            @else
                                <option value="{{ $array_diasSemanales[$i]->iddieta }}">{{ $array_diasSemanales[$i]->dia }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6" >
                    <label>Alumno: *</label>
                    <select id="lstAlumnos" name="lstAlumnos" class="form-control">
                        <option selected value="0">-</option>
                        @for ($i = 0; isset($array_diasSemanales) && $i < count($array_diasSemanales); $i++)
                            @if (isset($dieta) and $array_diasSemanales[$i]->iddieta == $dieta->fk_idalumno)
                                <option selected value="{{ $array_diasSemanales[$i]->iddieta }}">{{ $array_diasSemanales[$i]->alumno }}</option>
                            @else
                                <option value="{{ $array_diasSemanales[$i]->iddieta }}">{{ $array_diasSemanales[$i]->alumno }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
        </form>
        
        <!--Modal-->

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
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
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