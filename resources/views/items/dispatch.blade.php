@extends('layouts.orders_template')

@section('screenName','Despacho de materiales')
@section('title', 'Despacho de materiales')

@section('orderContent')
<hr>

@if(count($errors) > 0)
<div class="alert alert-danger" role="alert">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<form class="row align-items-end">
  <div class="form-group col-md-4 mr-md-0">
    <label for="txtServiceOrder" class="mr-3">Número de orden de servicio</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="txtServiceOrder" placeholder="Ingrese un número de orden de servicio" value="{{$serviceOrderNumber}}">
  </div>
  <div class="form-group col-md-2">
    <button type="submit" class="btn btn-primary mb-2 w-100" id="btnFindOrderItems">Buscar orden de servicio</button>
  </div>
  <span id="errorMessage" class="text-danger d-none"></span>
</form>

<section id="items" class="d-none">
  <hr />
  <h3>Materiales</h3>

  <div class="table-responsive">
    <table id="tblItems" class="table table-striped"></table>
  </div>

  <form action="{{route('dispatchItems')}}" method="post" id="frmDispatchItems">
    @csrf
    <input type="hidden" name="service_order_id">
  </form>

  <div class="row p-1 justify-content-end">
    <div class="col-md-3">
      <button class="btn btn-primary w-100" id="btnDispatch">Despachar</button:button>
    </div>
  </div>
</section>
@endsection

@vite([
'resources/js/app.js',
'resources/js/itemsDispatch.js',
])