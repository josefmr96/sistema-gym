@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($pago->idpago) && $pago->idpago > 0 ? $pago->idpago : 0; ?>';
    <?php $globalId = isset($pago->idpago) ? $pago->idpago : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/cobros">Pagos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/pagos/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="admin/pagos";
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
                    <label>Alumno: *</label>
                    <select id="lstAlumno" name="lstAlumno" class="form-control">
                        <option selected value="0">-</option>                        
                            @for ($i = 0; $i < count($array_alumnos); $i++)
                                @if (isset($pago) and $array_alumnos[$i]->idalumno == $pago->fk_idalumno)
                                    <option selected value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                @else
                                    <option value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                @endif
                            @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha: *</label>
                    <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{$pago->fecha or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Importe: *</label>
                    <input type="number" id="txtImporte" name="txtImporte" class="form-control" value="{{$pago->importe or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Medio de pago: *</label>
                    <select id="lstMedioDePago" name="lstMedioDePago" class="form-control" required>
                        <option selected value="0">-</option>                        
                            @for ($i = 0; $i < count($array_mediodepago); $i++)
                                @if (isset($pago) and $array_mediodepago[$i]->idmediodepago == $pago->fk_idmediodepago)
                                    <option selected value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                                @else
                                    <option value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                                @endif
                            @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                                                    <label>Moneda: </label>
                                                    <select id="lstMonedaPago" name="lstMonedaPago" class="form-control">
                                                        <option selected value="0">-</option>                        
                                                            @for ($i = 0; $i < count($array_monedas); $i++)
                                                                @if (isset($pago) and $array_monedas[$i]->idmoneda == $cobro->fk_idmoneda)
                                                                    <option selected value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                                                @else
                                                                    <option value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                                                @endif
                                                            @endfor
                                                    </select>
            <!--    <div class="form-group col-lg-6">
                    <label>Activo: *</label>
                    <select id="lstActivo" name="lstActivo" class="form-control" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="1" {{isset($menu) && $menu->activo == 1? 'selected' : ''}}>Si</option>
                        <option value="0" {{isset($menu) &&$menu->activo == 0? 'selected' : ''}}>No</option>
                    </select>
                </div> -->
            </div>
			<!--<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-users fa-fw"></i> Áreas de trabajo:
				</div>
			</div>-->
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
            url: "{{ asset('sistema/cobros/eliminar') }}",
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