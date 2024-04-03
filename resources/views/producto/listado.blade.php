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
    <div class="modal fade" id="modal_new_producto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE PRODUCTO</h2>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formulario_new_producto">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">Sucursal</label>
                                    <select data-control="select2" name="sucursal_id" id="sucursal_id" data-placeholder="Seleccione" data-dropdown-parent="#modal_new_producto" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                        <option></option>
                                        @foreach ( $sucursales as $su)
                                        <option value="{{ $su->id }}">{{ $su->nombres }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">Categoria</label>
                                    <select data-control="select2" name="categoria_id" id="categoria_id" data-placeholder="Seleccione" data-dropdown-parent="#modal_new_producto" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                        <option></option>
                                        @foreach ( $categorias as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->nombres }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Nombre</label>
                                    <input type="text" id="nombres" name="nombres" class="form-control form-control-solid mb-3 mb-lg-0">
                                    <input type="text" id="producto_id" name="producto_id">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Descripcion</label>
                                    <input type="text" id="descripcion" name="descripcion" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Codigo</label>
                                    <input type="text" id="codigo" name="codigo" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Precio</label>
                                    <input type="text" id="precio" name="precio" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Stock</label>
                                    <input type="text" id="stock" name="stock" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success w-100" onclick="guardarProducto()">  Guardar Rol</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>



    <div class="card">
        <div class="card-header border-0 pt-6 bg-light-primary">
            <div class="card-title ">
                <h1>Listado de Productos</h1>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" onclick="nuevoProducto()">
                    <i class="ki-duotone ki-plus fs-2"></i>Nuevo Producto</button>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div id="table_producto">

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
                url : "{{ url('producto/ajaxListado') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#table_producto').html(data.listado);
                    }
                }
            });
        }

        function nuevoProducto(){

            $('#producto_id').val(0)
            // $('#nombres').val("")
            // $('#descripcion').val("")
            
            $('#modal_new_producto').modal('show')
        }

        function guardarProducto(){
            let datos = $('#formulario_new_producto').serializeArray()
            $.ajax({
                url     : "{{ url('producto/guardarProducto') }}",
                type    : 'POST',
                data    : datos,
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
                        $('#modal_new_producto').modal('hide')
                    }
                }
            });
        }

        // function editarRol(id,nombres,descripcion){
        //     $('#rol_id').val(id)
        //     $('#nombres').val(nombres)
        //     $('#descripcion').val(descripcion)
        
        //     $('#modal_new_rol').modal('show')
        // }

        // function eliminarRol(id,nombres){
        //     Swal.fire({
        //         title: "Estas seguro de eliminar el rol "+ nombres+"?",
        //         text: "No podras revertir eso!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Si, eliminar!"
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             $.ajax({
        //                 url : "{{ url('rol/eliminarRol') }}",
        //                 type: 'POST',
        //                 data: {
        //                     rol: id
        //                 },
        //                 dataType: 'json',
        //                 success: function(data) {
        //                     if(data.estado === 'success'){
        //                         Swal.fire({
        //                             icon:'success',
        //                             title: 'Exito!',
        //                             text:"Se elimino con exito!",
        //                             timer:1500
        //                         })
        //                         ajaxListado();
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // } 

    </script>
@endsection
