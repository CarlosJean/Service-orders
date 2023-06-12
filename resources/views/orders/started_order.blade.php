@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            <h2>¡Orden de servicio iniciada!</h2>
            <hr class="opacity-100">
            <p>La orden de servicio número <strong>{{$orderNumber}}</strong> ha sido iniciada satisfactoriamente.</p>
            <div class="row justify-content-end">                
                <a class="btn btn-primary col-4 mx-2" href="{{url('/ordenes-servicio')}}">Ver todas las ordenes</a>
            </div>
        </div>
    </div>
</di>
@endsection