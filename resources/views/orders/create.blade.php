@extends('layouts.orders_template')

@section('screenName','Orden de servicio')
@push('orderNumber')
<input type="text" value="{{$orderNumber}}" readonly id="txt_order_number" class="form-control">
@endpush


@section('orderContent')
@if($departmentId != 2 && $roleId == 2)
@include('partials.orders.create', ['orderNumber' => $orderNumber])
@endIf
@endsection