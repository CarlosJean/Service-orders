@extends('layouts.loginTemplate')

@section('content')
<div class="az-signin-wrapper">
    <div class="az-card-signin shadow">
        <div class="row align-items-center">
            <div class="col-12 az-signin-header">
                <div class="row justify-content-center">
                    <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing Logo" srcset="" width="250px">
                </div>
            </div>
            <div class="col-12 mt-5">
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="col-md-12 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-12 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- <button class="btn btn-az-primary btn-block">Iniciar Sesión</button> -->
                    <button type="submit" class="btn btn-az-primary btn-block">
                        {{ __('Iniciar sesión') }}
                    </button>
                </form>
            </div>
            <div class="col-12 mt-5">
                <div class="az-signin-footer">
                    <p><a href="">Olvidaste la contraseña?</a></p>
                    <p>No tienes una cuenta? <a href="page-signup.html">Crea una cuenta</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection