<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_agrega_productos">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ( $detalles as  $det )
            <tr>
                <td class="align-items-center">
                    <span class="text-info">
                        {{ $det->id }}
                    </span>
                 </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $det->producto->nombre }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $det->producto->precio }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $det->cantidad }}</a>
                </td>
                <td>
                    <a class="text-gray-800 text-hover-primary mb-1">{{ $det->fecha }}</a>
                </td>
                <td>
                    
                </td>
            </tr>
        @empty
            <h4 class="text-danger text-center">Sin registros</h4>
        @endforelse
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success w-100 btn-sm" onclick="guardarVenta()">Generar Venta</button>
    </div>
</div>
<script>
    $('#table_agrega_productos').DataTable({
        // lengthMenu: [ -1 ],
        // ordering: true,
        // initComplete: function() {
        //     this.api().order([0, "desc"]).draw();
        // }
    });
</script>
<!--begin::Table-->

