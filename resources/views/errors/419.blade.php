@extends('layouts.loginTemplate')

@section('title', 'Página no encontrada')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card p-5">
                <div class="col-3">
                    <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing Logo" srcset="" class="w-100 h-xs-100">
                </div>
                <div class="text-center mt-3">
                    <h1>Su sesión ha expirado</h1>
                    <p>Lo sentimos, su sesión ha expirado, favor autenticarse nuevamente.</p>
                    <a href="{{route('login')}}" class="btn btn-primary">Acceder</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection