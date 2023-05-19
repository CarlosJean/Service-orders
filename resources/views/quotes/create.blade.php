@extends('layouts.orders_template')

@section('screenName', 'Cotización')

@push('orderNumber')
<input type="text" name="" id="" class="form-control" readonly>
@endpush

@section('orderContent')
<div class="container">
  <div class="row">
    <div class="form-group col-6">
      <label for="">Artículo</label>
      <input type="text" name="" id="" class="form-control">
    </div>
    <div class="form-group col-2">
      <label for="">Cantidad</label>
      <input type="number" name="" id="" class="form-control">
    </div>
    <div class="form-group col-4">
      <label for="">Precio</label>
      <input type="text" name="" id="" class="form-control">
    </div>
    <div class="form-group col-6">
      <label for="">Medida</label>
      <input type="number" name="" id="" class="form-control">
    </div>
    <div class="form-group col-6">
      <label for="">Información extra</label>
      <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
    </div>
  </div>
  <div class="form-group container col-12">
    <div class="row justify-content-end">
      <button class="btn btn-primary col-3" id="btn_add_material" type="button">Agregar al listado</button>
    </div>
  </div>
  <h3>Listado de materiales</h3>
  <hr class="opacity-100">
  <div class="col-12 p-0">
    <form action="" method="post">
      <table class="table d-none" id="tbl_materials">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Artículo</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Medida</th>
            <th scope="col">Precio</th>
            <th scope="col">Información extra</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="materials"></tbody>
      </table>
      <div class="row justify-content-center">
        <button class="btn btn-secondary col-4">Volver</button>
        <input type="submit" value="Guardar" class="btn btn-primary col-4 ml-2">
      </div>
    </form>
  </div>
</div>


@endsection

@vite([
'resources/js/app.js',
'resources/js/quotes.js'
])