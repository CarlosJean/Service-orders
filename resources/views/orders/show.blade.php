@extends('layouts.orders_template')

@section('screenName','Órden de servicio')
@push('orderNumber')
<input type="text" value="{{$order->number}}" readonly id="txt_order_number" class="form-control">
@endpush

@section('orderContent')
@if($userRole == 'maintenanceSupervisor')
@include('partials.orders.assign_technician')
@elseIf($userRole == 'technician')
@include('partials.orders.technician_order')
@endif
@endsection