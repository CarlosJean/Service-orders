
@extends('layouts.app')


@section('content')


@vite(['resources/js/suppliers.js'])


<div class="container" style="width:90%">
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
 + Nuevo departamento
</button>
<br>
<br> -->
<table id="dataTable" class="table table-striped table-bordered nowrap" style="font-size:9.5px; width:50px">
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear nuevo suplidor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="register-suppliers"  method="post">
        @csrf
          <div class="row">
          <div class="col-6">
            <label for="">Tipo de identificación</label>
            <div class="form-group">
            <select class="form-control" name="tipoidentificacion">
                 <option>Seleccione una opción</option>
                 <option>RNC</option>
                 <option>Cedula</option>
                </select>
            </div>
          </div>

          <div class="col-6">
            <label for="">RNC o Cedula</label>
            <div class="form-group">
              <input type="text" class="form-control" name="rnc">
            </div>
          </div>

          <div class="col-12">
            <label for="">Nombre</label>
            <div class="form-group">
              <input type="text" class="form-control" name="nombre">
            </div>
          </div>

          <div class="col-12">
            <label for="">Dirección</label>
            <div class="form-group">
              <input type="text" class="form-control" name="direccion">
            </div>
          </div>

          <div class="col-12">
            <label for="">Ciudad</label>
            <div class="form-group">
            <select class="form-control" name="municipio">
            <option>Seleccione la ciudad</option>
            <option>Agua Santa del Yuna, Duarte</option>
                 <option>Consuelo, San Pedro de Macorís</option>
                 <option>San Pedro De Macorís, San Pedro de Macorís</option>
                <option>Boca Chica, Santo Domingo</option>
                 <option>Hato Viejo, Santo Domingo</option>
                </select>
            </div>
          </div>

          <div class="col-12">
            <label for="">Correo Electronico</label>
            <div class="form-group">
              <input type="text" class="form-control" name="correo">
            </div>
          </div>

          <div class="col-12">
            <label for="">Celular</label>
            <div class="form-group">
              <input type="text" class="form-control" name="celular">
            </div>
          </div> 




        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" name="submit">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection


