@extends('layouts.orders_template')

@section('screenName', 'Cotización')

@push('orderNumber')
<input type="text" name="" id="" class="form-control text-end" value="{{$quoteNumber}}" readonly>
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('orderContent')
<section class="form-inline" id="frm_find_service_order">
  <div class="form-group col-6 pl-0">
    <label for="txt_service_order_number">Número de orden</label>
    <input type="text" name="order_number" id="txt_service_order_number" class="form-control col-8 ml-2" placeholder="Ingrese el número de orden de servicio">
  </div>
  <div class="form-group">
    <button class="btn btn-primary" id="btn_find_service_order">Buscar</button>
  </div>
</section>
<span id="spn_message" class="text-danger col-12 pl-0"></span>

<hr class="opacity-100">
<h2>Detalle de la orden</h2>

<div class="col-12 mb-2">
  <div class="row">
    <div class="col-6">
      <label>Requerido por</label>
      <input type="text" name="" id="txt_requestor" class="form-control" readonly>
    </div>
    <div class="col-6">
      <label>Técnico asignado</label>
      <input type="text" name="" id="txt_technician" class="form-control" readonly>
    </div>
  </div>
</div>

<hr class="opacity-100">
<h2>Materiales</h2>

@if($errors->any())
<div class="col-12 mt-2">
  <div class="alert alert-danger">
    {{$errors->first()}}
  </div>
</div>
@endif

<div class="col-12">
  <div class="row">
    <form class="col-12" id="frm_add_item" method="post">
      <div class="row">
        <div class="form-group col-6">
          <label for="">Suplidor</label>
          <select name="supplier" id="slc_suppliers" class="form-control"></select>
        </div>
        <div class="form-group col-6">
          <label for="">Artículo</label>
          <input type="text" name="item" id="txt_item" class="form-control" placeholder="Ingrese el nombre del artículo" required>
        </div>
        <div class="form-group col-8">
          <label for="">Referencia</label>
          <input type="text" name="reference" id="txt_reference" class="form-control" placeholder="Ingrese una referencia">
        </div>
        <div class="form-group col-2">
          <label for="">Cantidad</label>
          <input type="number" name="quantity" id="txt_quantity" class="form-control">
        </div>
        <div class="form-group col-2">
          <label for="">Precio</label>
          <input type="number" name="price" id="txt_price" class="form-control">
        </div>
        <div class="col-12">
          <div class="d-flex justify-content-end">
            <button class="btn btn-secondary col-2 justify-self-end" id="btn_add_to_list" type="button">Agregar al listado</button>
          </div>
        </div>
      </div>
    </form>

    <div class="col-12">
      <form action="crear" method="post" id="frm_quote">
        @csrf
        <input type="hidden" value="{{$quoteNumber}}" name="quote_number" />
        <input type="hidden" name="service_order_number" />
        <table class="table table-striped mt-2 col-12">
          <thead>
            <tr>
              <td>Suplidor</td>
              <td>Artículo</td>
              <td>Referencia</td>
              <td>Cantidad</td>
              <td>Precio</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="3"><strong>Total</strong></td>
              <td id="td_total_quantity"></td>
              <td id="td_total_price" colspan="2"></td>
            </tr>
          </tbody>
        </table>
        <div class="form-group col-12">
          <div class="row justify-content-end">
            <input type="submit" value="Guardar" class="btn btn-primary col-2" id="btn_save">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@vite([
'resources/css/quotes.css',
'resources/js/app.js',
'resources/js/quotes.js'
])