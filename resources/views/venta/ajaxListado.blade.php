<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_ventas_6">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Fecha_venta</th>
            <th>Total_venta</th>
            <th>Acciones</th>
           
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $ventas as  $ven )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $ven->id }}
                    </span>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->fecha_venta }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->total_venta }}</a>
                </td>
                <td>
                    <button class="btn btn-icon btn-sm btn-warning" onclick="editarVenta('{{$ven->id}}', '{{$ven->fecha_venta}}', '{{$ven->total_venta}}')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger" onclick="eliminarVenta('{{$ven->id}}', '{{$ven->fecha_venta}}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <h4 class="text-danger text-center">Sin registros</h4>
        @endforelse
    </tbody>
</table>
<!--end::Table-->
{{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
<script>
    $('#table_ventas_2').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>

