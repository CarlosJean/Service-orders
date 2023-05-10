
@extends('layouts.app')


@section('content')


@vite(['resources/js/orders.js'])


<div class="container">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
 + Nuevo departamento
</button>
<br>
<br>
<table id="example" class="table table-striped table-bordered nowrap" style="font-size:14px">
      <thead>
          <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Acción</th>
          </tr>
      </thead>

  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear nuevo departamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="Tbusuarios.php" method="post">
        <div class="row">
        
          <div class="col-12">
            <label for="">Nombre</label>
            <div class="form-group">
              <input type="text" class="form-control" name="nombre">
            </div>
          </div>


          <div class="col-12">
            <label for="">Descripción</label>
            <div class="form-group">
              <input type="text" class="form-control" name="nombre">
            </div>
          </div>
          
        </div>
      </div>



@endsection


