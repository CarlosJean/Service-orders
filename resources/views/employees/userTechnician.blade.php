
@extends('layouts.app')

@section('title', 'Técnicos')

@section('content')

@vite(['resources/js/userTechnician.js', 'resources/css/whiteBackgroundColor.css',])

<!-- Modal -->
<div class="modal fade asignarMenu" id="asignarMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar servicios a tecnico</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <!-- <form action="register-roles-submenu" id="reg" method="post">
        @csrf -->
        <div class="row">        
        <div class="col-12">
        <input type="text" class="form-control" name="rol" id="rol" disabled>
        <input type="hidden" class="form-control" name="Id" id="emp">

        </div>
        </div>
    
        <input type="hidden" class="form-control" name="id">

        <div class="row" style="margin-top:5px">        
        <div class="col-12">
        <select multiple name="services[]" id="slcServices" class="form-select slcServices" style="width: 100%; margin-top:5px" required>
       </select>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit"  class="btn btn-primary" id="guardar" value="Guardar cambios"/> 
      <!-- </form> -->
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


