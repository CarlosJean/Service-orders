@extends('layouts.orders_template')

@section('screenName','Crear orden servicio')

@section('screenName','Orden de servicio')
@push('orderNumber')
<input type="text" value="{{$orderNumber}}" readonly id="txt_order_number" class="form-control">
@endpush

@section('orderContent')
@if($isDepartmentSupervisor)
@include('partials.orders.create', ['orderNumber' => $orderNumber])
@endIf
@endsection