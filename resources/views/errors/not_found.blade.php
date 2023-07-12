@extends('layouts.loginTemplate')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card p-5">
                <div class="col-3">
                    <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing Logo" srcset="" class="w-100 h-xs-100">
                </div>
                <div class="text-center mt-3">
                    <h1>Página no encontrada</h1>
                    <p>La página que busca no fue encontrada.</p>
                    <a href="{{isset($redirect) ? $redirect : URL::previous()}}" class="btn btn-primary">Ir atrás</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection