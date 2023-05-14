@vite([
'resources/js/app.js',
'resources/js/serviceOrders.js',
])

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2><strong>Órdenes de servicio</strong></h2>
        </div>
        <div class="col-12">
            <a href="{{url('ordenes-servicio/crear')}}" class="btn btn-primary">
                <i class="typcn icon typcn-plus"></i>
                Nueva orden de servicio
            </a>
            <table id="ordersTable" class="table table-striped table-bordered nowrap dataTable no-footer w-100"></table>
        </div>
    </div>
</div>
@endsection