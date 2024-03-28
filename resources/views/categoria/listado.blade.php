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
    <div class="modal fade" id="modal_new_categoria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold">FORMULARIO DE CATEGORIAS</h2>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formulario_new_categoria">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Nombres</label>
                                    <input type="text" id="nombres" name="nombres" class="form-control form-control-solid mb-3 mb-lg-0">
                                    <input type="hidden" id="categoria_id" name="categoria_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Descripcion</label>
                                    <input type="text" id="descripcion" name="descripcion" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                            </div>
                           
                        
                        </div>
                        </form>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success w-100" onclick="guardarCategoria()">  Guardar Categoria</button>
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
                <h1>Listado de Categorias</h1>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary" onclick="nuevoCategoria()">
                    <i class="ki-duotone ki-plus fs-2"></i>Nueva Categoria</button>
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
            <div id="table_categoria">

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
                url : "{{ url('categoria/ajaxListado') }}",
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#table_categoria').html(data.listado);
                    }
                }
            });
        }

        function nuevaCategoria(){

            $('#categoria_id').val(0)
            $('#nombres').val("")
            $('#descripcion').val("")
         
            $('#modal_new_categoria').modal('show')
        }

        function guardarCategoria(){
            let datos = $('#formulario_new_categoria').serializeArray()
            $.ajax({
                url : "{{ url('categoria/guardarCategoria') }}",
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
                        $('#modal_new_categoria').modal('hide')
                    }
                }
            });
        }

        function editarCategoria(id,nombres,descripcion){
           
            $('#categoria_id').val(id)
            $('#nombres').val(nombres)
            $('#descripcion').val(descripcion)
         
            $('#modal_new_categoria').modal('show')
        }

        function eliminarCategoria(id, nombres){
            Swal.fire({
                title: "Estas seguro de eliminar categoria "+ nombres+"?",
                text: "No podras revertir eso!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url : "{{ url('categoria/eliminarCategoria') }}",
                        type: 'POST',
                        data: {
                            categoria: id
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

    //     function guardarVenta(){
    //         if($("#formularioRol")[0].checkValidity()){
    //             datos = $("#formularioRol").serializeArray()
    //             $.ajax({
    //                 url: "{{ url('rol/guarda') }}",
    //                 data:datos,
    //                 type: 'POST',
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     if(data.estado === 'success')
    //                         $('#table_roles').html(data.listado);
    //                 }
    //             });
    //         }else{
    // 			$("#formularioRol")[0].reportValidity()
    //         }
    //     }



    //     function buscarFactura(){
    //         ajaxListado()
    //     };

    //     function modalAnular(factura){
    //         $('#factura_id').val(factura)
    //         $('#modalAnular').modal('show')
    //     }

    //     function anularFactura(){
    //         let factura = $('#factura_id').val()
    //         let codMott = $('#codigoMotivoAnulacion').val()
    //         if($("#formularioAnulaciion")[0].checkValidity()){
    //             Swal.fire({
    //                 title: 'Esta seguro de Anular la Factura?',
    //                 text: "No podras revertir eso!",
    //                 icon: 'warning',
    //                 showCancelButton: true,
    //                 confirmButtonColor: '#3085d6',
    //                 cancelButtonColor: '#d33',
    //                 confirmButtonText: 'Si, Anular!'
    //             }).then((result) => {
    //                 if (result.isConfirmed) {

    //                      // Obtén el botón y el icono de carga
    //                      var boton = $("#boton_anular_factura");
    //                      var iconoCarga = boton.find("i");
    //                      // Deshabilita el botón y muestra el icono de carga
    //                      boton.attr("disabled", true);
    //                      iconoCarga.show();

    //                     $.ajax({
    //                         url: "{{ url('factura/anularFacturaNew') }}",
    //                         method: "POST",
    //                         data: {
    //                             factura: factura,
    //                             motivo:   codMott
    //                         },
    //                         dataType:'json',
    //                         success: function (data) {
    //                             if(data.estado){
    //                                 Swal.fire({
    //                                     icon:'success',
    //                                     title: 'Exito!',
    //                                     text:data.descripcion,
    //                                     timer:1500
    //                                 })
    //                                 ajaxListado();
    //                                 $('#modalAnular').modal('hide');
    //                             }else{
    //                                 Swal.fire({
    //                                     icon:'error',
    //                                     title: 'Error!',
    //                                     text:data.descripcion
    //                                 })
    //                             }
    //                         }
    //                     })
    //                 }
    //             })
    //         }else{
    //             $("#formularioAnulaciion")[0].reportValidity();
    //         }
    //     }

    //     function modalRecepcionFacuraContingenciaFueraLinea(){
    //         $('#evento_significativo_contingencia_select').val('')
    //         $('#tablas_facturas_offline').hide('toggle');
    //         $('#modmodalContingenciaFueraLinea').modal('show')
    //     }

    //     function buscarEventosSignificativos(){
    //         if($("#formularioRecepcionFacuraContingenciaFueraLineaEentoSignificativo")[0].checkValidity()){
    //             let datos_formulario = $("#formularioRecepcionFacuraContingenciaFueraLineaEentoSignificativo").serializeArray();
    //             $.ajax({
    //                 url: "{{ url('eventoSignificativo/buscarEventosSignificativos') }}",
    //                 method: "POST",
    //                 data: datos_formulario,
    //                 success: function (data) {
    //                     $('#evento_significativo_contingencia_select').empty();
    //                     if(data.estado === "success"){
    //                         $('#bloque_no_hay_eventos').hide('toggle');

    //                         var newOption = $('<option>').text("SELECCIONE").val(null);
    //                         $('#evento_significativo_contingencia_select').append(newOption);

    //                         $(data.eventos).each(function(index, element) {
    //                             var optionText = element.descripcion;
    //                             var optionValue = element.codigoRecepcionEventoSignificativo;
    //                             var newOption = $('<option>').text(optionText).val(optionValue);
    //                             $('#evento_significativo_contingencia_select').append(newOption);
    //                         });
    //                     }else{
    //                         $('#mensaje_contingencia').text(data.msg)
    //                         $('#bloque_no_hay_eventos').show('toggle');
    //                     }
    //                 }
    //             })
    //         }else{
    //             $("#formularioRecepcionFacuraContingenciaFueraLineaEentoSignificativo")[0].reportValidity();
    //         }
    //     }

    //     function muestraTableFacturaPaquete(){
    //         let valor = $('#evento_significativo_contingencia_select').val();
    //         $.ajax({
    //             url: "{{ url('factura/muestraTableFacturaPaquete') }}",
    //             method: "POST",
    //             dataType: 'json',
    //             success: function (data) {
    //                 if(data.estado === "success"){
    //                     $('#tablas_facturas_offline').html(data.listado);
    //                     $('#tablas_facturas_offline').show('toggle');
    //                 }else{
    //                 }
    //             }
    //         })
    //         console.log(valor);
    //     }

    //     function mandarFacturasPaquete(){
    //         let arraye = $('#formularioEnvioPaquete').serializeArray();
    //         // Agregar un nuevo elemento al array
    //         arraye.push({ name: 'contingencia', value: $('#evento_significativo_contingencia_select').val() });
    //         $.ajax({
    //             url: "{{ url('factura/mandarFacturasPaquete') }}",
    //             method: "POST",
    //             data:arraye,
    //             dataType: 'json',
    //             success: function (data) {
    //                 if(data.estado === "success"){
    //                     ajaxListado();
    //                     $('#modmodalContingenciaFueraLinea').modal('hide')
    //                 }
    //             }
    //         })
    //     }

    //     function anularREcibo(factura){
    //         Swal.fire({
    //             title: 'Esta seguro de Anular el Recibo?',
    //             text: "No podras revertir eso!",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'Si, Anular!'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 $.ajax({
    //                     url: "{{ url('factura/anularRecibo') }}",
    //                     method: "POST",
    //                     data: {
    //                         factura: factura
    //                     },
    //                     dataType:'json',
    //                     success: function (data) {
    //                         if(data.estado === 'success'){
    //                             Swal.fire({
    //                                 icon:'success',
    //                                 title: 'Exito!',
    //                                 text:"Se anulo ewl recibo con exito!",
    //                                 timer:1500
    //                             })
    //                             ajaxListado();
    //                         }
    //                     }
    //                 })
    //             }
    //         })
    //     }

    //     function modalNuevaFacturaTramsferencia(factura){

    //         $.ajax({
    //             url: "{{ url('factura/recuperaFactura') }}",
    //             method: "POST",
    //             data: {
    //                 factura: factura
    //             },
    //             dataType:'json',
    //             success: function (data) {
    //                 if(data.estado === 'success'){
    //                     $('#detalle_factura').html(data.modal)

    //                     $('#modalTramsferenciaFactura').modal('show')
    //                     // Swal.fire({
    //                     //     icon:'success',
    //                     //     title: 'Exito!',
    //                     //     text:"Se anulo ewl recibo con exito!",
    //                     //     timer:1500
    //                     // })
    //                     // ajaxListado();
    //                 }
    //             }
    //         })



    //     }

    //     function enviarTrasferenciaFactura(){

    //         if($("#formularioTramsfereciaFactura")[0].checkValidity()){
    //             let datos = $("#formularioTramsfereciaFactura").serializeArray();
    //             var tzoffset                        = ((new Date()).getTimezoneOffset()*60000);
    //             let fechaEmision                    = ((new Date(Date.now()-tzoffset)).toISOString()).slice(0,-1);
    //             // Agrega un nuevo campo a la serialización
    //             datos.push({ name: "fecha", value: fechaEmision });
    //             $.ajax({
    //                 url: "{{ url('factura/enviarTrasferenciaFactura') }}",
    //                 method: "POST",
    //                 data: datos,
    //                 success: function (data) {
    //                     if(data.estado === 'success'){
    //                         console.log(data)
    //                         Swal.fire({
    //                             icon:'success',
    //                             title: "SE REALIZO CON EXITO",
    //                             text:  "LA MIGRACION FUE UN EXITO",
    //                         })
    //                         location.reload();
    //                     }else{
    //                         console.log(data, data.detalle.mensajesList)
    //                         Swal.fire({
    //                             icon:'error',
    //                             title: data.detalle.codigoDescripcion,
    //                             text:  JSON.stringify(data.detalle.mensajesList),
    //                             // timer:1500
    //                         })
    //                     }
    //                 }
    //             })
    //         }else{
    //             $("#formularioTramsfereciaFactura")[0].reportValidity();
    //         }
    //     }

    //     function verificaNit(){
    //         let tipoDocumento = $('#tramsfrencia_new_tipo_documento').val();
    //         if(tipoDocumento === "5"){
    //             let nit = $('#tramsfrencia_new_nit').val();
    //             $.ajax({
    //                 url: "{{ url('factura/verificaNit') }}",
    //                 method: "POST",
    //                 data:{nit:nit},
    //                 dataType: 'json',
    //                 success: function (data) {
    //                     if(data.estado === "success"){
    //                         if(!data.verificacion){
    //                             // Marcar el checkbox con jQuery
    //                             $('#tramsfrencia_new_execpion').prop('checked', true);
    //                             $('#nitnoexiste').show('toggle');
    //                             $('#nitsiexiste').hide('toggle');
    //                             $('#bloque_exepcion').show('toggle');
    //                         }else{
    //                             $('#tramsfrencia_new_execpion').prop('checked', false);
    //                             $('#nitsiexiste').show('toggle');
    //                             $('#nitnoexiste').hide('toggle');
    //                             $('#bloque_exepcion').hide('toggle');
    //                         }
    //                     }else{

    //                     }

    //                 }
    //             })
    //         }else{
    //             $('#bloque_exepcion').hide('toggle');
    //             $('#tramsfrencia_new_execpion').prop('checked', false);
    //         }
    //     }

    //     function generaTicked(factura_id, vehiculo_id){
    //         // console.log(factura_id, vehiculo_id)
    //         let url = "{{ url('pago/imprimeTicked') }}/"+factura_id+"/"+vehiculo_id;
    //         window.open(url, '_blank');
    //     }
    // </script>
@endsection


