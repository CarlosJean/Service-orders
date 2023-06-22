@vite([
'resources/js/app.js',
'resources/js/serviceOrders.js',
])

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2><strong>Ordenes de servicio</strong></h2>
                <hr>
            </div>
            <div class="col-12">
                <table id="ordersTable" class="table table-striped table-hover">
                    <thead class="thead-custom1"></thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection