@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            <h2>Materiales solicitados satisfactoriamente!</h2>
            <hr class="opacity-100">
            <p>Los materiales para la orden número <strong>{{$orderNumber}}</strong> han sido solicitados satisfactoriamente.</p>
            <div class="row justify-content-end">
                <a class="btn btn-primary col-4 mx-2" href="{{url('/ordenes-servicio')}}">Salir</a>
            </div>
        </div>
    </div>
</di>
@endsection