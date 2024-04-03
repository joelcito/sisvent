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
    <div class="modal fade" id="modal_new_cliente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE CLIENTE</h2>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formulario_new_cliente">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Nombres</label>
                                    <input type="text" id="nombres" name="nombres" class="form-control form-control-solid mb-3 mb-lg-0">
                                    <input type="hidden" id="cliente_id" name="cliente_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Ap Paterno</label>
                                    <input type="text" id="ap_paterno" name="ap_paterno" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Ap Materno</label>
                                    <input type="text" id="ap_materno" name="ap_materno" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Cedula</label>
                                    <input type="number" id="cedula" name="cedula" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Celular</label>
                                    <input type="number" id="celular" name="celular" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Correo</label>
                                    <input type="text" id="correo" name="correo" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success w-100" onclick="guardarCliente()">  Guardar Cliente</button>
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
    <div class="card">
        <div class="card-header border-0 pt-6 bg-light-primary">
            <div class="card-title ">
                <h1>Listado de Clientes</h1>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" onclick="nuevoCliente()">
                    <i class="ki-duotone ki-plus fs-2"></i>Nuevo Cliente</button>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div id="table_cliente">

            </div>

            <div id="tabla_restro_detalle" style="display: none">
                <h3 class="text-info text-center">DETALLE DE VENTA</h3>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="nombre_cliente_elegido" name="nombre_cliente_elegido">
                        <input type="text" id="cliente_id_cliente_elegido" name="cliente_id_cliente_elegido">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="ap_paterno_cliente_elegido" name="ap_paterno_cliente_elegido">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="ap_meterno_cliente_elegido" name="ap_meterno_cliente_elegido">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="cedula_cliente_elegido" name="cedula_cliente_elegido">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold form-label mb-2">Productos</label>
                        <select data-control="select2" name="producto_id_new_venta" id="producto_id_new_venta" data-placeholder="Seleccione" data-hide-search="true" class="form-select form-select-solid fw-bold" onchange="recibirProducto(this)">
                            <option></option>
                            @foreach ( $productos as $pro)
                            <option value="{{ $pro->id }}">{{ $pro->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Precio</label>
                            <input type="text" id="precio_producto_new_venta" name="precio_producto_new_venta" class="form-control form-control-solid mb-3 mb-lg-0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Stock</label>
                            <input type="text" id="stock_producto_new_venta" name="stock_producto_new_venta" class="form-control form-control-solid mb-3 mb-lg-0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Cantidad</label>
                            <input type="text" id="cantidad_producto_new_venta" name="cantidad_producto_new_venta" class="form-control form-control-solid mb-3 mb-lg-0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7 mt-9">
                            <button class="btn btn-success w-100 btn-sm" onclick="agregarProducuto()"><i class="fa fa-plus"></i> Agregar</button>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="text-info text-center">Productos Agregados</h3>
                <div id="tabla_productos_agregados">

                </div>
            </div>
        </div>
    </div> 
@stop()

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{--  <script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>  --}}
    {{--  <script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>  --}}
    {{--  <script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script>  --}}
    {{--  <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>  --}}

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
                url : "{{ url('cliente/ajaxListado') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#table_cliente').html(data.listado);
                    }
                }
            });
        }

        function nuevoCliente(){

            $('#cliente_id').val(0)
            $('#nombres').val("")
            $('#ap_paterno').val("")
            $('#ap_materno').val("")
            $('#correo').val("")
            $('#celular').val("")
            $('#cedula').val("")

            $('#modal_new_cliente').modal('show')
        }

        function guardarCliente(){
            let datos = $('#formulario_new_cliente').serializeArray()
            $.ajax({
                url : "{{ url('cliente/guardarCliente') }}",
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
                        $('#modal_new_cliente').modal('hide')
                    }
                }
            });
        }

        function editarCliente(id,nombres,ap_paterno,ap_materno,cedula,celular,correo){
            $('#cliente_id').val(id)
            $('#nombres').val(nombres)
            $('#ap_paterno').val(ap_paterno)
            $('#ap_materno').val(ap_materno)
            $('#correo').val(cedula)
            $('#celular').val(celular)
            $('#cedula').val(correo)

            $('#modal_new_cliente').modal('show')
        }

        function eliminarCliente(id, nombres){
            Swal.fire({
                title: "Estas seguro de eliminar al cliente "+ nombres+"?",
                text: "No podras revertir eso!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url : "{{ url('cliente/eliminarCliente') }}",
                        type: 'POST',
                        data: {
                            cliente: id
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

        function elegirCliente(id, nombres, ap_paterno,ap_materno,cedula){
            $('#cliente_id_cliente_elegido').val(id)
            $('#nombre_cliente_elegido').val(nombres)
            $('#ap_paterno_cliente_elegido').val(ap_paterno)
            $('#ap_meterno_cliente_elegido').val(ap_materno)
            $('#cedula_cliente_elegido').val(cedula)

            $('#tabla_restro_detalle').show('toggle')
            $('#table_cliente').hide('toggle')

            ajaxListadoProductosAgregados(id)
            
        }

        function recibirProducto(element){
            $.ajax({
                url : "{{ url('cliente/buscarProducto') }}",
                type: 'POST',
                data: {
                    producto: element.value
                },
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#precio_producto_new_venta').val(data.producto.precio)
                        $('#stock_producto_new_venta').val(data.producto.stock)
                    }
                }
            });
        }

        function agregarProducuto(){
            let cliente_id = $('#cliente_id_cliente_elegido').val()
            let datos = {
                cliente_id : cliente_id,
                producto_id: $('#producto_id_new_venta').val(),
                cantidad   : $('#cantidad_producto_new_venta').val(),
            }
            $.ajax({
                url : "{{ url('cliente/agregarProducuto') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        ajaxListadoProductosAgregados(cliente_id)
                        // $('#precio_producto_new_venta').val(data.producto.precio)
                        // $('#stock_producto_new_venta').val(data.producto.stock)
                    }
                }
            });
        }

        function ajaxListadoProductosAgregados(cliente){
            $.ajax({
                url : "{{ url('cliente/ajaxListadoProductosAgregados') }}",
                type: 'POST',
                data: {
                    cliente:cliente
                },
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#tabla_productos_agregados').html(data.listado)
                    }
                }
            });
        }

        function guardarVenta(){
            let cliente_id = $('#cliente_id_cliente_elegido').val()

            let datos = {
                cliente_id : cliente_id
            }

            $.ajax({
                url : "{{ url('cliente/guardarVenta') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#tabla_productos_agregados').html(data.listado)
                    }
                }
            });
        }

    </script>
@endsection


