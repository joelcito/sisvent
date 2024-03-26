<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_sucursales_3">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion/th>
            <th>Direccion</th>
            <th></th>
           
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $sucursales as  $suc )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $suc->id }}
                    </span>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $suc->nombres}}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $suc->descripcion }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $suc->direccion }}</a>
                </td>
                
                <td>
                    <button class="btn btn-icon btn-sm btn-warning" onclick="editarSucursal('{{$suc->id}}', '{{$suc->nombre}}', '{{$suc->descripcion}}', '{{$suc->direccion}}')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger" onclick="eliminarSucursal('{{$suc->id}}', '{{$suc->nombre}}')"><i class="fa fa-trash"></i></button>
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
    $('#table_sucursales_3').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>
