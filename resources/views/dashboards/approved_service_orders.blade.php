<table class="table table-light">
    <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Inicio</th>
            <th>Finalización</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($serviceOrders as $serviceOrder)
        <tr>
            <td>{{$serviceOrder->number}}</td>
            <td>{{$serviceOrder->name}}</td>
            <td>{{$serviceOrder->created_at}}</td>
            <td>{{$serviceOrder->start_date}}</td>
            <td>{{$serviceOrder->end_date}}</td>
            <td>{{$serviceOrder->status}}</td>
        </tr>
        @endforeach
    </tbody>
</table>