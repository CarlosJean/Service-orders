@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
            <h2>¡Diagnóstico a orden de servicio brindado!</h2>
                <hr>
            </div>
            <div class="col-12">
            <p>Se ha brindado un diagnóstico a la orden <strong>{{$orderNumber}}</strong> satisfactoriamente.</p>
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                <a class="btn btn-primary col-md-4" href="{{url('/ordenes-servicio')}}">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection