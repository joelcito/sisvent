<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_roles_12">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Sucursal</th>
            <th>Categoria</th>
            <th>Nombres</th>
            <th>Descripcion</th>
            <th>Codigo</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $productos as  $proc )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $proc->id }}
                    </span>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->sucursal->nombres }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->categoria->nombres }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->nombre }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->descripcion }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->codigo }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->precio }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $proc->stock }}</a>
                </td>
                <td>
                    {{-- <button class="btn btn-icon btn-sm btn-warning" onclick="editarRol('{{$proc->id}}', '{{$proc->nombres}}', '{{$proc->descripcion}}')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger" onclick="eliminarRol('{{$proc->id}}', '{{$proc->nombres}}')"><i class="fa fa-trash"></i></button> --}}
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
    $('#table_roles_12').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>
<!--begin::Table-->

