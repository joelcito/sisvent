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

    <div class="card">
        <div class="card-header border-0 pt-6 bg-light-primary">
            <div class="card-title ">
                <h1>Listado de Ventas</h1>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ url('cliente/listado') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Nueva Venta</a>
                  </div>
            </div>
        </div>
        <div class="card-body py-4">
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
