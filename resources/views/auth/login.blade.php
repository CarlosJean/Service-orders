@extends('layouts.loginTemplate')

@section('content')
<div class="container h-100">
    <div class="row align-items-center h-100 justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="row justify-content-center py-3">
                    <div class="col-6">
                        <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing Logo" srcset="" class="w-100 h-xs-100">
                    </div>
                    <div class="col-12">
                        <form action="{{route('login')}}" method="POST" class="px-3 my-3">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="fs-lg-5">{{ __('Correo electrónico') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Contraseña') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback fs-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-az-primary btn-block">
                                {{ __('Iniciar sesión') }}
                            </button>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-start mx-1">
                            <div class="col-md-6">
                                <a href="{{route('password.request')}}" class="link">¿Olvidaste la contraseña?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="az-signin-wrapper">
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
                    <button type="submit" class="btn btn-az-primary btn-block">
                        {{ __('Iniciar sesión') }}
                    </button>
                </form>
            </div>
            <div class="col-12 mt-5">
                <div class="az-signin-footer">
                    <p><a href="{{route('password.request')}}">¿Olvidaste la contraseña?</a></p>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection