@extends('layouts.app')


@section('content')


@vite(['resources/js/inventoryValue.js'])


<!-- Inicio contenido -->
<div class="container">
<iframe id="txtArea1" style="display:none"></iframe>

    <br>
    <h1>Valor de inventario</h1>
    <p>Consulta el valor del inventario actual, la cantidad de productos inventariables que tienes y su costo promedio.</p>
    <div class="form-group row">
        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Hasta</label>
        <div class="col-sm-10">
        <!-- <form action="inventory_value"  method="post">
        @csrf -->
          <input type="date" class="form-control form-control-sm" id="colFormLabelSm" placeholder="col-form-label-sm" style="margin-left:-150px; width:120px ;">
          <button class="btn btn-warning" id="getInventory" style="margin-top:-67px;">Generar reporte</button>
          <!-- <input type="submit"  class="btn btn-primary" style="margin-top:-67px;" value="Generar reporte"/>  -->
          <!-- </form> -->
          <div class="text-left">
            <button type="button" class="btn btn-secondary " id="export" style="margin-top:-110px; margin-left:150px ;     ">Exportar a excel</button>        
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <!-- @csrf  -->
        </div>
      </div>
     <br>
      <div class="card-body shadow">
    <table class="table table-striped" id="dataTable">
        <!-- <thead>
          <tr>
            <th scope="col">Articulo</th>
            <th scope="col">Referencia</th>
            <th scope="col">Descripción</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Unidad</th>
            <th scope="col">Estado</th>
            <th scope="col">Costo promedio</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
            
        </tbody> -->
      </table>
    </div>
<br>
<br>
        <div class="bordes" style="border:30px solid   rgb(204, 173, 173);">
       <form action="" style="float:right;">
         <b> <label for="">Valor de inventario</label></b>
        
          <label for="" id="total">RD$0.00</label>
        </form>
    </div>


</div>

@endsection

<!-- Final contenido -->
 