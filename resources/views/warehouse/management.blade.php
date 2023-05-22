@extends('layouts.orders_template')

@section('screenName', 'Gestión de materiales')
@push('orderNumber')
<input type="text" readonly="readonly" class="form-control text-right" value="{{$order->number}}">
@endpush

@section('orderContent')

<div class="row">
    @include('partials.orders.detail')
</div>

<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#materialsManagement">
    Agregar artículos
</button>

<form action="./gestion-materiales" method="post" id="frm_order_items">
    @csrf
    <table class="table table-striped mt-2 d-none" id="tbl_order_items">
        <thead>
            <tr>
                <td>Artículo</td>
                <td>Referencia</td>
                <td>Medida</td>
                <td>Cantidad</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="orderItems"></tbody>
    </table>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-3">
                <input type="submit" value="Guardar" class="btn btn-primary w-100">
            </div>
        </div>
    </div>
</form>

<!-- Material Management Modal -->
@include('partials.materials_management.add_materials')
@endsection

@vite(['resources/js/app.js', 'resources/js/materialsManagement.js'])