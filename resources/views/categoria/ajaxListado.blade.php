<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_categorias_4">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th></th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $categorias as  $cat )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $cat->id }}
                    </span>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cat->nombres }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cat->descripcion }}</a>
                </td>
                <td>
                    <button class="btn btn-icon btn-sm btn-warning" onclick="editarCategoria('{{$cat->id}}', '{{$cat->nombre}}', '{{$cat->descripcion}}')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger" onclick="eliminarCategoria('{{$cat->id}}', '{{$cat->nombre}}')"><i class="fa fa-trash"></i></button>
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
    $('#table_categorias_4').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>
