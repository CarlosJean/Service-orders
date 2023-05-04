@extends('layouts.orders_template')

@section('screenName', 'Orden de servicios')
@push('orderNumber')
<input type="text" name="" id="" value="0" class="form-control text-end" readonly>
@endpush

@section('orderContent')
    <h1>Prueba</h1>
@endsection