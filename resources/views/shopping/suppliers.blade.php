
@extends('layouts.app')

@section('title', 'Suplidores')
@section('content')


@vite(['resources/js/suppliers.js','resources/css/whiteBackgroundColor.css',])


<div class="container" style="width:90%">
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
 + Nuevo departamento
</button>
<br>
<br> -->
<table id="dataTable" class="table table-striped table-bordered nowrap" style="font-size:11px;">
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
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
            <select class="form-control" name="tipoidentificacion" id="tipoidentificacion" required>
                 <option>Seleccione una opción</option>
                 <option>RNC</option>
                 <option>Cedula</option>
                </select>
            </div>
          </div>

          <div class="col-6">
            <label for="" id="ident">RNC o Cedula</label>
            <div class="form-group">
              <input type="text" class="form-control" name="rnc" id="inIdent"  required readonly="readonly" >
            </div>
          </div>

          <div class="col-12">
            <label for="">Nombre</label>
            <div class="form-group">
              <input type="text" class="form-control" name="nombre" required>
            </div>
          </div>

          <div class="col-12">
            <label for="">Dirección</label>
            <div class="form-group">
              <input type="text" class="form-control" name="direccion" required>
            </div>
          </div>

          <div class="col-12">
            <label for="">Ciudad</label>
            <div class="form-group">
            <select class="form-control" name="municipio" required>
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
              <input type="email" class="form-control" name="correo" required>
            </div>
          </div>

          <div class="col-12">
            <label for="">Celular (formato: xxx-xxx-xxxx)</label>
            <div class="form-group">
              <input type="text" class="form-control" maxlength="12" name="celular" required minlength="12" pattern="^\d{3}-\d{3}-\d{4}$">
            </div>
          </div> 




        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" name="submit">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection


