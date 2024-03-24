<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_ventas_2">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Total_venta</th>
           
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
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->fecha }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->descripcion }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->cantidad }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $ven->total_venta }}</a>
                </td>
                
                <td>
                </tr>
                <button class="btn btn-icon btn-sm btn-warning" onclick="editarVenta('{{$ven->id}}', '{{$ven->fecha}}', '{{$ven->descripcion}}', '{{$ven->cantidad}}', '{{$ven->total_venta}}')"><i class="fa fa-edit"></i></button>
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
