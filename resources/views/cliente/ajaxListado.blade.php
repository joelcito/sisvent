<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_clientes_1">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Nombres</th>
            <th>Ap_Paterno</th>
            <th>Ap_Materno</th>
            <th>Correo</th>
            <th>Celular</th>
            <th>Cedula</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $clientes as  $cli )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $cli->id }}
                    </span>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->nombres }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->ap_paterno }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->ap_materno }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->correo }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->celular }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $cli->cedula }}</a>
                </td>
                <td>
                    <button class="btn btn-icon btn-sm btn-warning" onclick="editarCliente('{{$cli->id}}', '{{$cli->nombres}}', '{{$cli->ap_paterno}}', '{{$cli->ap_materno}}', '{{$cli->correo}}', '{{$cli->celular}}', '{{$cli->cedula}}')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger" onclick="eliminarCliente('{{$cli->id}}', '{{$cli->nombres}}')"><i class="fa fa-trash"></i></button>
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
    $('#table_clientes_1').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>
<!--begin::Table-->

