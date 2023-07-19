@extends('layouts.app')

@section('title', 'Orden de servicio desaprobado')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>¡Orden desaprobada satisfactoriamente!</h2>
                <hr>
            </div>
            <div class="col-12">
                <p>La orden número <strong>{{$orderNumber}}</strong> ha sido desaprobada satisfactoriamente.</p>
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                    <a class="btn btn-primary col-md-4" href="{{url('/ordenes-servicio')}}">Ver todas las ordenes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection