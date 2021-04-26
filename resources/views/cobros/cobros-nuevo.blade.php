@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($cobro->idcobro) && $cobro->idcobro > 0 ? $cobro->idcobro : 0; ?>';
    <?php $globalId = isset($cobro->idcobro) ? $cobro->idcobro : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/cobros">Cobros</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cobros/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/cobros";
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
                    <label>Producto: *</label>
                    <select id="lstProducto" name="lstProducto" class="form-control">
                        <option selected value="0">-</option>                        
                            @for ($i = 0; $i < count($array_productos); $i++)
                                @if (isset($cobro) and $array_productos[$i]->idproducto == $cobro->fk_idproducto)
                                    <option selected value="{{ $array_productos[$i]->idproducto }}">{{ $array_productos[$i]->nombre }}</option>
                                @else
                                    <option value="{{ $array_productos[$i]->idproducto }}">{{ $array_productos[$i]->nombre }}</option>
                                @endif
                            @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Alumno: *</label>
                    <select id="lstAlumno" name="lstAlumno" class="form-control">
                        <option selected value="0">-</option>                        
                            @for ($i = 0; $i < count($array_alumnos); $i++)
                                @if (isset($cobro) and $array_alumnos[$i]->idalumno == $cobro->fk_idalumno)
                                    <option selected value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                @else
                                    <option value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                @endif
                            @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Importe: *</label>
                    <input type="number" id="txtImporte" name="txtImporte" class="form-control" value="{{$cobro->importe or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Moneda: *</label>
                    <select id="lstMoneda" name="lstMoneda" class="form-control">
                        <option selected value="0">-</option>                        
                            @for ($i = 0; $i < count($array_monedas); $i++)
                                @if (isset($cobro) and $array_monedas[$i]->idmoneda == $cobro->fk_idmoneda)
                                    <option selected value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                @else
                                    <option value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                @endif
                            @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Concepto: *</label>
                    <input type="text" id="txtConcepto" name="txtConcepto" class="form-control" value="{{$cobro->concepto or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Entrenador: *</label>
                    <select id="lstEntrenador" name="lstEntrenador" class="form-control">
                        <option selected value="0">-</option>                        
                        @for ($i = 0; $i < count($array_entrenadores); $i++)
                            @if (isset($cobro) and $array_entrenadores[$i]->identrenador == $cobro->fk_identrenador)
                                <option selected value="{{ $array_entrenadores[$i]->identrenador }}">{{ $array_entrenadores[$i]->nombre }}</option>
                            @else
                                <option value="{{ $array_entrenadores[$i]->identrenador }}">{{ $array_entrenadores[$i]->nombre }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Medio de pago: *</label>
                    <select id="lstMedio" name="lstMedio" class="form-control">
                        <option selected value="0">-</option>                        
                        @for ($i = 0; $i < count($array_mediodepago); $i++)
                            @if (isset($cobro) and $array_mediodepago[$i]->idmediodepago == $cobro->fk_idmedio)
                                <option selected value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                            @else
                                <option value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha origen: *</label>
                    <input type="date" id="txtFechaOrigen" name="txtFechaOrigen" class="form-control" value="{{$cobro->fecha_origen or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha vencimiento: *</label>
                    <input type="date" id="txtFechaVto" name="txtFechaVto" class="form-control" value="{{$cobro->fecha_vto or ''}}" required>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Pagos acreditados
                            <div class="pull-right">  
                                <button type="button" class="btn btn-secondary fa fa-plus-circle" data-toggle="modal" data-target="#pagoModal"> </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="grilla" class="display border table table-border">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Medio de pago</th>
                                        <th>Importe</th>
                                        <th>Alumno</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div>
                <script>
                    var dataTable = $('#grilla').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "bFilter": false,
                        "bInfo": true,
                        "bSearchable": false,
                        "order": [[ 2, "asc" ]],
                        "ajax": "{{ route('pagos.cargarGrilla') }}"
                    });

                    
                </script>





                
        </div>
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


<!-- Modal -->
<div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Nuevo pago</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form id="form2" method="POST">
                                            <div class="row">
                                                <div class="form-group col-lg-6">
                                                    <label>Fecha: </label>
                                                    <input type="date" id="txtFechaPago" name="txtFechaPago" class="form-control" value="{{$pago->fecha or ''}}" required>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Alumno: *</label>
                                                    <select id="lstAlumnoPago" name="lstAlumnoPago" class="form-control">
                                                        <option selected value="0">-</option>                        
                                                            @for ($i = 0; $i < count($array_alumnos); $i++)
                                                                @if (isset($cobro) and $array_alumnos[$i]->idalumno == $cobro->fk_idalumno)
                                                                    <option selected value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                                                @else
                                                                    <option value="{{ $array_alumnos[$i]->idalumno }}">{{ $array_alumnos[$i]->nombre }}</option>
                                                                @endif
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Moneda: </label>
                                                    <select id="lstMonedaPago" name="lstMonedaPago" class="form-control">
                                                        <option selected value="0">-</option>                        
                                                            @for ($i = 0; $i < count($array_monedas); $i++)
                                                                @if (isset($cobro) and $array_monedas[$i]->idmoneda == $cobro->fk_idmoneda)
                                                                    <option selected value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                                                @else
                                                                    <option value="{{ $array_monedas[$i]->idmoneda }}">{{ $array_monedas[$i]->nombre }}</option>
                                                                @endif
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Importe abonado: </label>
                                                    <input type="number" id="txtImportePago" name="txtImportePago" class="form-control" value="{{$pago->importe or ''}}" required>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Medio de pago: *</label>
                                                    <select id="lstMedioPago" name="lstMedioPago" class="form-control">
                                                        <option selected value="0">-</option>                        
                                                        @for ($i = 0; $i < count($array_mediodepago); $i++)
                                                            @if (isset($cobro) and $array_mediodepago[$i]->idmediodepago == $cobro->fk_idmedio)
                                                                <option selected value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                                                            @else
                                                                <option value="{{ $array_mediodepago[$i]->idmediodepago }}">{{ $array_mediodepago[$i]->nombre }}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Comprobante: </label>
                                                    <input type="file" id="comprobante" name="comprobante" class="form-control">
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Observaciones: </label>
                                                    <input type="textarea" id="txtObservaciones" name="txtObservaciones" class="form-control">
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" onclick="fAgregarPago();">Agregar</button>
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

    $("#form2").validate();

    function fAgregarPago(){
        
        var grilla = $('#grilla').DataTable();
        grilla.row.add([
            $("#txtFechaPago").val() + "<input type='hidden' name='txtFechaPago[]' value='"+ $("#txtFechaPago").val() +"'>",
            $("#lstMedioPago option:selected").text() + "<input type='hidden' name='lstMedioPago[]' value='"+$("#lstMedioPago").val()+"'>",
            $("#txtImportePago option:selected").val() + "<input type='hidden' name='txtImportePago[]' value='"+ $("#txtImportePago option:selected").val() +"'>",
            $("#lstAlumnoPago option:selected").text() + "<input type='hidden' name='lstAlumnoPago[]' value='"+ $("#lstAlumnoPago option:selected").val() +"'>",              
            ""
        ]).draw();
        $('#pagoModal').modal('toggle');
        limpiarFormulario();
        
    }

        function limpiarFormulario(){
            $("#txtFechaPago").val("");
            $("#lstMonedaPago").val(0);
            $("#txtImportePago").val("");
            $("#lstMedioPago").val(0);
            $("#comprobante").val("");
            $("#txtObservaciones").val("");
        }


</script>
@endsection