@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')

     <!--end::Modal - New Card-->
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="modal_new_venta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE VENTAS</h2>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formulario_new_venta">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Fecha venta </label>
                                    <input type="dateTime" id="fecha_venta" name="fecha_venta" class="form-control form-control-solid mb-3 mb-lg-0">
                                    <input type="hidden" id="venta_id" name="venta_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Total venta</label>
                                    <input type="decimal" id="total_venta" name="total_venta" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                     
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success w-100" onclick="guardarVenta()">  Guardar Venta</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
{{--
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="modmodalContingenciaFueraLinea" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE CONTINGENCIA</h2>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formularioRecepcionFacuraContingenciaFueraLineaEentoSignificativo">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">FECHA</label>
                                    <input type="date" class="form-control" id="fecha_contingencia" name="fecha_contingencia" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="fv-row mb-7">
                                    <button class="btn btn-success w-100 mt-4 btn-sm" onclick="buscarEventosSignificativos()" type="button"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">EVENTO SIGNIFICATIVO</label>
                                    <select name="evento_significativo_contingencia_select" id="evento_significativo_contingencia_select" class="form-control" onchange="muestraTableFacturaPaquete()">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div id="tablas_facturas_offline" style="display: none">

                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

     <!--begin::Modal TRAMSERENCIA FACTURA- Add task-->
     <div class="modal fade" id="modalTramsferenciaFactura" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE ANULACION Y TRAMSFERIR FACTURA</h2>
                </div>
                <div class="modal-body scroll-y">

                    <div id="detalle_factura">

                    </div>

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
    --}}
    <div class="card">
        <div class="card-header border-0 pt-6 bg-light-primary">
            <div class="card-title ">
                <h1>Listado de Ventas</h1>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" onclick="nuevaVenta()">
                    <i class="ki-duotone ki-plus fs-2"></i>Nueva Venta</button>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            {{-- <form id="formulario_busqueda_ventas">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Placa</label>
                        <input type="text" class="form-control" id="buscar_placa" name="buscar_placa">
                    </div>
                    <div class="col-md-1">
                        <label for="">Ap Paterno</label>
                        <input type="text" class="form-control" id="buscar_ap_paterno" name="buscar_ap_paterno">
                    </div>
                    <div class="col-md-1">
                        <label for="">Ap Materno</label>
                        <input type="text" class="form-control" id="buscar_ap_materno" name="buscar_ap_materno">
                    </div>
                    <div class="col-md-1">
                        <label for="">Nombres</label>
                        <input type="text" class="form-control" id="buscar_nombre" name="buscar_nombre">
                    </div>
                    <div class="col-md-2">
                        <label for="">Nit</label>
                        <input type="number" class="form-control" id="buscar_nit" name="buscar_nit">
                    </div>
                    <div class="col-md-2">
                        <label for="">Fecha Inicio</label>
                        <input type="date" class="form-control" id="buscar_fecha_ini" name="buscar_fecha_ini">
                    </div>
                    <div class="col-md-2">
                        <label for="">Fecha Fin</label>
                        <input type="date" class="form-control" id="buscar_fecha_fin" name="buscar_fecha_fin">
                    </div>
                    <div class="col-md-1">
                        <label for="">Tipo</label>
                        <select name="tipo_emision" id="buscar_tipo_emision" name="buscar_tipo_emision" class="form-control">
                            <option value="">SELECCIONE</option>
                            <option value="Si">FACTURA</option>
                            <option value="No">RECIBO</option>
                        </select>
                    </div>
                </div>
            </form> --}}
            {{-- <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success w-100 btn-sm mt-7" onclick="buscarFactura()"><i class="fa fa-search"></i>Buscar</button>
                </div>
            </div> --}}
            <div id="table_venta">

            </div>
        </div>
    </div> 
@stop()

@section('js')
    
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    
    <script type="text/javascript">

        $.ajaxSetup({
            // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $( document ).ready(function() {
            ajaxListado();
        });


        function ajaxListado(){
            // let datos = $('#formulario_busqueda_ventas').serializeArray();
            let datos = {};
            $.ajax({
                url : "{{ url('venta/ajaxListado') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#table_venta').html(data.listado);
                    }
                }
            });
        }

        function nuevaVenta(){

            $('#venta_id').val(0)
            $('#fecha_venta').val("")
            $('#total_venta').val("")
           

            $('#modal_new_venta').modal('show')
        }

        function guardarVenta(){
            let datos = $('#formulario_new_venta').serializeArray()
            $.ajax({
                url : "{{ url('venta/guardarVenta') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        Swal.fire({
                            icon:'success',
                            title: 'Exito!',
                            text:"Se registro con exito!",
                            timer:1500
                        })
                        ajaxListado();
                        $('#modal_new_venta').modal('hide')
                    }
                }
            });
        }

        function editarVenta(id,fecha_venta,total_venta){
            $('#venta_id').val(id)
            $('#fecha_venta').val(fecha_venta)
            $('#total_venta').val(total_venta)
           
            $('#modal_new_venta').modal('show')
        }

        function eliminarVenta(id, fecha_venta){
            Swal.fire({
                title: "Estas seguro de eliminar al cliente "+ fecha_venta+"?",
                text: "No podras revertir eso!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url : "{{ url('venta/eliminarVenta') }}",
                        type: 'POST',
                        data: {
                            venta: id
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data.estado === 'success'){
                                Swal.fire({
                                    icon:'success',
                                    title: 'Exito!',
                                    text:"Se elimino con exito!",
                                    timer:1500
                                })
                                ajaxListado();
                            }
                        }
                    });
                }
            });
        }
    </script>   
@endsection