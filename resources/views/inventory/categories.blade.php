
@extends('layouts.app')


@section('content')


@vite(['resources/js/categories.js'])


<div class="container">
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
 + Nuevo departamento
</button>
<br>
<br> -->
<table id="dataTable" class="table table-striped table-bordered nowrap" style="font-size:14px">
      <!-- <thead>
          <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Acción</th>
          </tr>
      </thead> -->

  </table>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Categoria</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="register-categories"  method="post">
        @csrf
      <div class="row">        
        <div class="col-12">
          <label for="">Nombre</label>
          <div class="form-group">
            <input type="text" class="form-control" name="nombre" required>
          </div>
        </div>
        <input type="hidden" class="form-control" name="id">

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


@endsection


