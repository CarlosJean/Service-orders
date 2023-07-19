@extends('layouts.app')

@section('title', 'Servicios')

@section('content')

@vite(['resources/js/services.js'])

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Servicio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="register-services"  method="post">
        @csrf
      <div class="row">       
        <div class="col-12">
          <label for="">Nombre</label>
          <div class="form-group">
            <input type="text" class="form-control" name="nombre" required>
          </div>
        </div>

        <div class="col-12">
          <label for="">Descripción</label>
          <div class="form-group">
            <input type="text" class="form-control" name="descripcion" required>
          </div>
        </div>
        
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit"  class="btn btn-primary" value="Guardar"/> 
      </form>
      </div>
    </div>
  </div>
</div>

<div class="container">
<!-- Button trigger modal -->
  <!-- <button type="button" id="openModalServ2" class="btn btn-primary" >+ Nuevo servicio</button> -->
  <table id="servicesTable" class="table table-striped table-bordered nowrap" style="font-size:14px">
  </table>
  </div



@endsection


