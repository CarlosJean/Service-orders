@extends('layouts.orders_template')

@extends('layouts.orders_footer')

@section('screenName', 'Orden de servicios')
@push('orderNumber')
<input type="text" name="" id="" value="0" class="form-control text-end" readonly>
@endpush

@section('orderContent')
<div class="container">

    <div class="row">
        <div class="col-2">
        <label for="">Servicio</label>
        </div>
        <div class="col-4">
      <select id="inputState"  style="width: 240px; height: 40px;">
        <option selected>Seleccione el servicio</option>
      </select>
        </div>
        <div class="col-2">           
        <label for="" >Departamento</label>
        </div>
        <div class="col-4">    
<select class="js-example-basic-single" id="Buscar"  style="width: 240px; height: 40px;">
<option>Seleccione el Depto</option>
</select>
        </div>
    </div>
<br>

    <!-- <div class="row">
        <div class="col-2">
        <label for="" >Fecha</label>
        </div>
        <div class="col-4">
 <input type="date"  id="exampleFormControlInput1" style="width: 240px; height: 40px;">
        </div>
     
        <div class="col-2">
        <label for="" >Hora inicio</label>
        </div>
        <div class="col-4">
<input type="time" style="width: 240px; height: 40px;" >
        </div>
    </div> -->
    <br>
    <br>
<table class="table table-striped " id="tablita">
<thead>
 <tr>
   
   <th scope="col">Articulo</th>
   <th scope="col">Referencia</th>
   <th scope="col">Descripción</th>
   <th scope="col">Medida</th>
   <th scope="col">Cantidad</th>
</tr>
</thead>


</table>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product">
 + Agregar articulo
</button>
<br>
<br>
    <br>
<div class="row">
<div class="col-12">
 <label for="exampleFormControlTextarea1">Comentario</label>
 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
</div>
<br>
<br>
<br>
<br><br>
<div class="row">
<div class="col-6">
<hr noshade="noshade" width="60%" > 
<h6 >Requerido por</h6>
</div>
<br>
<div class="col-6">
<hr noshade="noshade" width="60%" > 
<h6>Aprobado Por</h6>
</div>
</div>
<br>
<br>
</div>

@endsection



