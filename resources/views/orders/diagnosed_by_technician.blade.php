@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            <h2>¡Diagnóstico a orden de servicio brindado!</h2>
            <hr class="opacity-100">
            <p>Se ha brindado un diagnóstico a la orden <strong>{{$orderNumber}}</strong> satisfactoriamente.</p>
            <div class="row justify-content-end">                
                <a class="btn btn-primary col-4 mx-2" href="{{url('/ordenes-servicio')}}">Volver</a>
            </div>
        </div>
    </div>
</di>
@endsection