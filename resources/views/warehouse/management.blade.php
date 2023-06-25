@extends('layouts.orders_template')

@section('screenName', 'Gestión de materiales')
@push('orderNumber')
<input type="text" readonly="readonly" class="form-control text-right" value="{{$order->number}}">
@endpush

@section('orderContent')

<div class="row">
    @include('partials.orders.detail')
</div>

<button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#materialsManagement">
    Agregar artículos
</button>

<div class="row">
    <div class="col-12">
        <form action="./gestion-materiales" method="post" id="frm_order_items">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped mt-2 d-none" id="tbl_order_items">
                    <thead>
                        <tr>
                            <th scope="col">Artículo</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">Medida</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="orderItems"></tbody>
                </table>
            </div>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-md-3 mt-3">
                        <input type="submit" value="Guardar" class="btn btn-primary w-100">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Material Management Modal -->
@include('partials.materials_management.add_materials')
@endsection

@vite(['resources/js/app.js', 'resources/js/materialsManagement.js'])