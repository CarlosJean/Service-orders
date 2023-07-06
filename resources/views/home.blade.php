@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Ordenes pendientes') }}</div>

                <div class="card-body">
                    @include('dashboards.pending_service_orders')
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Ordenes aprobados') }}</div>

                <div class="card-body">
                    @include('dashboards.approved_service_orders')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection