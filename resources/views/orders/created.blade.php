@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>¡Orden de servicio creado!</h2>
                <hr>
            </div>
            <div class="col-12">
                <p>Orden de servicio creado, bajo el número <strong>{{$orderNumber}}</strong>.</p>
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                    <a class="btn btn-secondary col-md-4" href="{{url('/ordenes-servicio/crear')}}">Generar otra orden</a>
                    <a class="btn btn-primary col-md-4 mx-md-2 mt-2 mt-md-0" href="{{url('/ordenes-servicio')}}">Ver todas las Ordenes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection