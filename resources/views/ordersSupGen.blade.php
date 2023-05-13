
@extends('layouts.app')


@section('content')


@vite(['resources/js/orders.js'])


<div class="container">
      <a class="btn btn-primary float-right" href="/service-orders/public/ordersSupGenRen" >+ Nueva orden de servicio </a>
      <br>
    <br>
      <table id="example" class="table table-striped table-bordered nowrap" style="font-size:13px">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Servicio</th>
                <th>Hora inicio</th>
                <th>Hora finalización</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <!-- <tbody>
        <td>No.</td>
                <td>Nombre</td>
                <td>Fecha</td>
                <td>Servicio</td>
                <td>Hora inicio</td>
                <td>Hora finalización</td>
                <td>Estado</td>
                <td>Acción</td>
          </tbody>         
    </table> -->
</div>
@endsection


