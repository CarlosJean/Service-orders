@extends('layouts.app')

@section('content')
<di class="container">
    <div class="row justify-content-center">
        <div class="card col-6 p-3">
            <h2>¡Cotización creada!</h2>
            <hr class="opacity-100">
            <p>Cotización creada bajo el número <strong>{{$quoteNumber}}</strong>.</p>
        </div>
    </div>
</di>
@endsection