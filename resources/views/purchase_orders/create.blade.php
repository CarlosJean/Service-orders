@extends('layouts.orders_template')

@section('screenName', 'Orden de compra')

@push('orderNumber')
<input type="text" name="" id="" class="form-control text-end" value="{{$purchaseOrderNumber}}" readonly>
@endpush

@section('orderContent')
<div class="row">
    <div class="col-12">
        <form class="form-inline" method="get" action="./obtener-cotizacion" id="frmGetQuoteByNumber">
            @csrf
            <div class="row justify-content-between w-100">
                <label for="" class="sr only col-3" id="txtQuoteNumber">Número de cotización</label>
                <input type="text" name="quote_number" id="" class="form-control col-4">
                <input type="submit" value="Buscar" class="btn btn-primary col-4">
            </div>
            <span id="spnQuoteNotFound" class="text-danger col-12 pl-0 d-none"></span>
        </form>
    </div>
    <div class="col-12">
        <hr class="opacity-100">
        <h3>Artículos</h3>
        <table class="table table-striped" id="tblQuotes"></table>
        <form action="" method="post" id="frmPurchaseOrder">
            @csrf
            <input type="hidden" name="quote_number">
            <input type="hidden" name="purchase_order_number" value="{{$purchaseOrderNumber}}">
            <input type="submit" value="Guardar" class="btn btn-primary" id="btnSave">
        </form>
    </div>
</div>
@endsection

@vite([
'resources/js/app.js',
'resources/js/purchaseOrders.js',
])