
@extends('layouts.app')


@section('content')



<div class="container">
      <a class="btn btn-primary float-right" href="/service-orders/public/ordersSup" >+ Nueva orden de servicio </a>
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
        
    </table>
</div>
@endsection


