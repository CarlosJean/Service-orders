@extends('layouts.orders_template')

@section('orderContent')
<div class="row">
    <div class="col-12">
        <form class="form-inline" method="get" action="./obtener-cotizacion" id="frmGetQuoteByNumber">
            @csrf
            <div class="form-group">
                <label for="" class="sr only" id="txtQuoteNumber">Número de cotización</label>
                <input type="text" name="quote_number" id="" class="form-control">
                <input type="submit" value="Buscar" class="btn btn-primary">
            </div>
            <span id="spnQuoteNotFound" class="text-danger col-12 pl-0 d-none"></span>
        </form>
    </div>
    <div class="col-12">
        <hr class="opacity-100">
        <h3>Artículos</h3>
        <table class="table table-striped" id="tblQuotes">
            <thead>
                <tr>
                    <th></th>
                    <th>Suplidor</th>
                    <th class="d-none">Id artículo</th>
                    <th>Artículo</th>
                    <th>Referencia</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
        </table>
        <form action="" method="post" id="frmPurchaseOrder">
            @csrf
            <input type="hidden" name="quote_number">
            <input type="submit" value="Guardar" class="btn btn-primary" id="btnSave">
        </form>
    </div>
</div>
@endsection

@vite([
'resources/js/app.js',
'resources/js/purchaseOrders.js',
])