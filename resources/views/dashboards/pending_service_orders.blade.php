<table class="table table-light">
    <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($serviceOrders as $serviceOrder)
        <tr>
            <td>{{$serviceOrder->number}}</td>
            <td>{{$serviceOrder->technician}}</td>
            <td>{{$serviceOrder->created_at}}</td>
            <td>{{$serviceOrder->status}}</td>
        </tr>
        @endforeach
    </tbody>
</table>