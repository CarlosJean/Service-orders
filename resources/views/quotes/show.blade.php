@extends('layouts.orders_template')

@section('title', 'Cotización')
@section('screenName', 'Cotización')

@push('orderNumber')
<input type="text" class="form-control text-end" value="{{$quote['summary']->number}}" readonly>
@endpush

@section('orderContent')
    <hr>
    <h2>Resumen</h2>
    <div class="row">
        <div class="col-md-3">
            <label>Creador</label>
            <input type="text" class="form-control" value="{{$quote['summary']->created_by}}" readonly>
        </div>
        <div class="col-md-3">
            <label>Creado en</label>
            <input type="text" class="form-control" value="{{$quote['summary']->date}}" readonly>
        </div>
    </div>

    <hr />
    <h2>Materiales</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Suplidor</th>
                <th>Artículo</th>
                <th>Referencia</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote['detail'] as $detail)
            <tr>
                <td>{{$detail->supplier}}</td>
                <td>{{$detail->item}}</td>
                <td>{{$detail->reference}}</td>
                <td>{{$detail->quantity}}</td>
                <td>${{$detail->price}}</td>
            </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="1">Total</td>
                <td></td>
                <td></td>
                <td>{{$quote['totals']['quantity']}}</td>
                <td>${{$quote['totals']['price']}}</td>
            </tr>
        </tbody>
    </table>

    <div class="container">
        <div class="row justify-content-end">
            <a href="{{URL::previous()}}" class="btn btn-primary col-md-2">Volver atrás</a>
            <a class="btn btn-secondary col-3 ms-2">
                <i class="typcn typcn-printer"></i>
                Imprimir
            </a>
        </div>
    </div>
@endSection