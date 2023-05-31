@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            <h2>¡Orden de compra creada!</h2>
            <hr class="opacity-100">
            <p>Orden de compra creada, bajo el número <strong>{{$purchaseOrderNumber}}</strong>.</p>
            <div class="row justify-content-end">
                <a class="btn btn-secondary col-4" href="{{url('/ordenes-servicio/crear')}}">Generar otra orden</a>
                <a class="btn btn-primary col-4 mx-2" href="{{url('/ordenes-servicio')}}">Ver todas las Ordenes</a>
            </div>
        </div>
    </div>
</di>
@endsection