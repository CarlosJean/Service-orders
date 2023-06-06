@extends('layouts.orders_template')


@section('orderContent')
<form class="form-inline">
  <label for="txtServiceOrder">Número de orden de servicio</label>
  <input type="text" class="form-control mb-2 mr-sm-2" id="txtServiceOrder" placeholder="Ingrese un número de orden de servicio">
  <button type="submit" class="btn btn-primary mb-2">Buscar orden de servicio</button>
</form>

<hr />
<h3>Materiales</h3>

<table id="tblItems" class="table table-striped"></table>

<form action="./despachar" method="post" id="frmDispatchItems">
  @csrf
  <input type="hidden" name="items">
</form>
<button class="btn btn-primary" id="btnDispatch">Despachar</button:button>

  @endsection


  @vite([
  'resources/js/app.js',
  'resources/js/itemsDispatch.js',
  ])