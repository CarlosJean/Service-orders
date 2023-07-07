@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">

        @if($isDepartmentSupervisor || $isMaintenanceSupervisor)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>{{ __('Ordenes pendientes') }}</strong></div>

                <div class="card-body">
                    @include('dashboards.pending_service_orders')
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>{{ __('Ordenes aprobados') }}</strong></div>

                <div class="card-body">
                    @include('dashboards.approved_service_orders')
                </div>
            </div>
        </div>
        @endif

        @if($isMaintenanceSupervisor || $isWarehouseEmployee)
        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-header"><strong>{{ __('Gestión de materiales pendientes') }}</strong></div>

                <div class="card-body">
                    @include('dashboards.pending_items_management')
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-header"><strong>{{ __('Gestión de materiales aprobadas') }}</strong></div>

                <div class="card-body">
                    @include('dashboards.approved_items_management')
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection