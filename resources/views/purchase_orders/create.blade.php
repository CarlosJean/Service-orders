@extends('layouts.orders_template')

@section('screenName', 'Orden de compra')

@push('orderNumber')
<input type="text" name="" id="" class="form-control text-end" value="{{$purchaseOrderNumber}}" readonly>
@endpush

@section('orderContent')
<div class="row">
    <hr class="mt-3">
    <div class="col-12">
        <form class="form-inline" method="get" action="./obtener-cotizacion" id="frmGetQuoteByNumber">
            @csrf
            <div class="row align-items-end">
                <div class="form-group col-md-6">
                    <label for="" class="sr only col-md-3" id="txtQuoteNumber">Número de cotización</label>
                    <input type="text" name="quote_number" id="" class="form-control col-4">
                </div>
                <div class="col-5">
                    <input type="submit" value="Buscar" class="btn btn-primary col-md-4">
                </div>
                <span id="spnQuoteNotFound" class="text-danger col-12 pl-0 d-none"></span>
            </div>
        </form>
    </div>
    <div class="col-12 d-none" id="dvItems">
        <hr class="opacity-100">
        <h3>Artículos</h3>
        <div class="table-responsive">
            <table class="table table-striped w-100" id="tblQuotes"></table>
        </div>
        <form action="" method="post" id="frmPurchaseOrder">
            @csrf
            <input type="hidden" name="quote_number">
            <input type="hidden" name="purchase_order_number" value="{{$purchaseOrderNumber}}">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-md-2 p-md-0 mt-2 mt-md-0">
                        <input type="submit" value="Guardar" class="btn btn-primary w-100" id="btnSave">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@vite([
'resources/js/app.js',
'resources/js/purchaseOrders.js',
])