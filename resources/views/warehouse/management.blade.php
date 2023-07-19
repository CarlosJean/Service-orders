@extends('layouts.orders_template')

@section('title', 'Gestión de materiales')
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
    
    @if($errors->any())
    <div class="alert alert-danger col-12 mt-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-12">
        <form action="./gestion-materiales" method="post" id="frm_order_items">
            @csrf
            <div class="table-responsive">
                @if(count($orderItems) == 0)
                <table class="table table-striped mt-2 d-none" id="tbl_order_items">
                    @else
                    <table class="table table-striped mt-2" id="tbl_order_items">
                        @endif
                        <thead>
                            <tr>
                                <th scope="col">Artículo</th>
                                <th scope="col">Referencia</th>
                                <th scope="col">Medida</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="orderItems">

                            @foreach($orderItems as $detail)
                            <tr>
                                <input type="hidden" name="items[{{$loop->index}}][id]" value="{{$detail->item->id}}" />
                                <input type="hidden" name="items[{{$loop->index}}][quantity]" value="{{$detail->quantity}}" />
                                <td>{{$detail->item->name}}</td>
                                <td>{{$detail->item->reference}}</td>
                                <td>{{$detail->item->measurement_unit}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td><button class="btn btn-warning btn_remove_item">Remover</button></td>
                            </tr>
                            @endforeach
                        </tbody>
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