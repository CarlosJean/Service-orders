  @extends('layouts.loginTemplate')

  @section('content')
  <div class="az-signin-wrapper">
      <div class="az-card-signin shadow">
          <h1 class="az-logo"><span></span></h1>
          <div class="az-signin-header">
              <img src="../img/drlmanufactur2-removebg-preview.png" alt="" width="250px" style="margin-left: 20px;">
              <br>
              <br>
              <br>

              <form action="{{url('/authenticate')}}" method="POST">
                  @csrf
                  <div class="form-group">
                      <label>Correo</label>
                      <input type="text" class="form-control" placeholder="Ingrese su correo electrónico" name="email"/>
                  </div>
                  <div class="form-group">
                      <label>Contraseña</label>
                      <input type="password" class="form-control" placeholder="Ingrese su contraseña" name="password"/>
                  </div>
                  <button class="btn btn-az-primary btn-block">Iniciar Sesión</button>
              </form>
          </div>
          <div class="az-signin-footer">
              <p><a href="">Olvidaste la contraseña?</a></p>
              <p>No tienes una cuenta? <a href="page-signup.html">Crea una cuenta</a></p>
          </div>
      </div>
  </div>
  @endsection