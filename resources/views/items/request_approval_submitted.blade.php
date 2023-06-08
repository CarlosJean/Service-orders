@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            @if($approved)
            <h2>¡Materiales de orden de servicio aprobados satisfactoriamente!</h2>
            <p>Se aprobó la solicitud de materiales de la orden número <strong>{{$serviceOrderNumber}}</strong>.</p>
            @else
            <h2>¡Materiales de orden de servicio desaprobados satisfactoriamente!</h2>
            <hr class="opacity-100">
            <p>Se desaprobó la solicitud de materiales de la orden número <strong>{{$serviceOrderNumber}}</strong>.</p>
            @endif
        </div>
    </div>
</di>
@endsection