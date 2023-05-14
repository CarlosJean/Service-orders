@vite([
'resources/js/app.js',
'resources/js/serviceOrders.js',
])

@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2><strong>Órdenes de servicio</strong></h2>
            <a href="{{url('ordenes-servicio/crear')}}" class="btn btn-primary">
                <i class="typcn icon typcn-plus"></i>
                Nueva orden de servicio
            </a>
            <table id="ordersTable" class="table table-striped table-bordered nowrap dataTable no-footer"></table>
        </div>
    </div>
</div>
@endsection