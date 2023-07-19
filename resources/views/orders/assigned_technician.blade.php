@extends('layouts.app')

@section('screenName','Técnico asignado')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>¡Técnico asignado satisfactoriamente!</h2>
                <hr>
            </div>
            <div class="col-12">
                <p>Se ha asignado el técnico <strong>{{$technician}}</strong> a la orden número <strong>{{$orderNumber}}</strong>.</p>
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