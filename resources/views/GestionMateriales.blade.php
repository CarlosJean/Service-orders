
@extends('layouts.app')


@section('content')


@vite(['resources/js/orders.js'])


<div class="container">
      <a class="btn btn-primary float-right" href="/service-orders/public/GestionMaterialesBTN" >+ Nueva solicitud de materiales</a>
    <br>   
    <br> 
      <table id="example" class="table table-striped table-bordered nowrap" style="font-size:13px">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Departamento</th>
                <th>Servicio</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
       
    </table>
@endsection


