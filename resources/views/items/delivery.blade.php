@extends('layouts.orders_template')

@section('orderContent')
<form class="form-inline">
  <label for="txtPurchaseOrderNumber">Número de orden de compra</label>
  <input type="text" class="form-control mb-2 mr-sm-2" id="txtPurchaseOrderNumber" placeholder="Ingrese un número de orden de compra">
  <button type="submit" class="btn btn-primary mb-2">Buscar orden de compra</button>
</form>

<hr />
<h3></h3>

@endsection