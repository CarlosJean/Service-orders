
@extends('layouts.app')


@section('content')


@vite(['resources/js/items.js'])


<div class="container">
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
 + Nuevo departamento
</button>
<br>
<br> -->
<table id="dataTable"  class="table table-striped table-bordered nowrap" style="font-size:11px;">
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
    <div class="modal-content" style="width: 700px;  margin-left: -100px; margin-top: -20px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear nuevo articulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
      <form action="register-items"  method="post">
        @csrf
          <div class="row">
          <div class="col-6">
            <label for="">Nombre</label>
            <div class="form-group">
            <input type="text" class="form-control" name="nombre">
            
            </div>
          </div>

          <div class="col-6">
            <label for="">Unidad de Medida</label>
            <div class="form-group">
            <select class="form-control" name="medida">
                 <option>Seleccione la medida</option>
                 <option>Barril</option>
                 <option>Bolsa</option>
                 <option>Bote</option>
                 <option>Bultos</option>
                 <option>Botella</option>
                 <option>Caja/Cajón</option>
                 <option>Cajetilla</option>
                 <option>Centimetro</option>
                 <option>Cilindro</option>
                 <option>Conjunto</option>
                 <option>Contenedor</option>
                 <option>Docena</option>
                 <option>Fardo</option>
                 <option>Galones</option>
                 <option>Grado</option>
                 <option>Gramo</option>
                 <option>Granel</option>
                 <option>Huacal</option>
                 <option>Kilogramo</option>
                 <option>Killovatio Hora</option>
                 <option>Libra</option>
                 <option>Litro</option>
                 <option>Lote</option>
                 <option>Metro</option>
                 <option>Metro cuadrado</option>
                 <option>Metro cubico</option>
                 <option>Millones de unidades termicas</option>
                 <option>Paquete</option>
                 <option>Par</option>
                 <option>Pie</option>
                 <option>Pieza</option>
                 <option>Rollo</option>
                 <option>Sobre</option>
                 <option>Tanquear</option>
                 <option>Tonelada</option>
                 <option>Tubo</option>
                 <option>Yarda</option>
                 <option>Yarda Cuadrada</option>
                 <option>Unidad</option>
                 <option>Elemento</option>
                 <option>Millar</option>
                 <option>Saco</option>
                 <option>Lata</option>
                 <option>Bidón</option>
                 <option>Ración</option>
                 












                </select>
            </div>
          </div>

         
          <!-- <div class="col-6">
            <label for="">Almacen</label>
            <div class="form-group">
            <select class="form-control" name="Alamacen">
                 <option>Principal</option>
                </select>
            </div>
          </div> -->

          <div class="col-6">
            <label for="">Costo inicial</label>
            <div class="form-group">
              <input type="text" class="form-control" name="precio">
            </div>
          </div>

          <div class="col-6">
            <label for="">Cantidad</label>
            <div class="form-group">
            <input type="text" class="form-control" name="cantidad">
            
            </div>
          </div>

      

          <div class="col-12">
            <label for="">Referencia</label>
            <div class="form-group">
              <input type="text" class="form-control" name="referencia">
            </div>
          </div>
          <div class="form-group col-md-12">
      <label for="inputState">Descripción</label>
      <input type="text" class="form-control" id="inputZip" name="descripcion">
      
    </div>
    <!-- <div class="form-group col-md-6">
      <label for="inputZip">Status</label>
      <select id="inputState" class="form-control">
        <option>Activo</option>
        <option>Inactivo</option>
      </select>
    </div> -->
  </div>
                 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit"  class="btn btn-primary" value="Guardar"/> 
      </div>
      </form>
    </div>
  </div>
</div>
</div>





@endsection


