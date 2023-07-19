@extends('layouts.app')

@section('screenName','Aprobación de solicitud de materiales')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row">
            <h2>Aprobación de solicitud de materiales</h2>

            @include('partials.orders.detail')

            <hr class="mt-2">
            <h3>Materiales</h3>

            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>Referencia</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $detail)
                        <tr>
                            <td>{{$detail->item->name}}</td>
                            <td>{{$detail->item->reference}}</td>
                            <td>{{$detail->quantity}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="container">
                <div class="row justify-content-end p-0">
                    <form action="aprobacion-materiales" method="post" class="col-md-3 mr-1">
                        @csrf
                        <input type="hidden" name="order_items_approved" value="false">
                        <input type="hidden" name="service_order_number" value="{{$order->number}}">
                        <button class="btn btn-warning w-100" type="submit">Desaprobar</button>
                    </form>
                    <form action="aprobacion-materiales" method="post" class="col-md-3 ml-1 mt-1 mt-md-0">
                        @csrf
                        <input type="hidden" name="order_items_approved" value="true">
                        <input type="hidden" name="service_order_number" value="{{$order->number}}">
                        <button class="btn btn-primary w-100" type="submit">Aprobar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection