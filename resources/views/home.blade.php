@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">

        @if($isDepartmentSupervisor || $isMaintenanceSupervisor || $isMaintenanceTechnician)
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
                <div class="card-header">
                    <strong>                        
                        @if($isMaintenanceTechnician) {{ __('Ordenes finalizadas') }} 
                        @else {{ __('Ordenes aprobadas') }} 
                        @endif
                    </strong>
                </div>

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
                <div class="card-header">
                    <strong>{{ __('Gestión de materiales aprobadas') }}</strong>
                </div>

                <div class="card-body">
                    @include('dashboards.approved_items_management')
                </div>
            </div>
        </div>
        @endif

        @if($isSystemAdmin)
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <a href="{{url('registro-empleado')}}" class="tile text-decoration-none" id="userRegistration">
                        <div class="row justify-content-center align-items-center h-100 text-center">
                            <div class="col-12">
                                Registrar empleados
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <a href="{{url('roles')}}" class="tile text-decoration-none" id="roles">
                        <div class="row justify-content-center align-items-center h-100 text-center">
                            <div class="col-12">
                                Roles
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <a href="{{url('departments')}}" class="tile text-decoration-none" id="departments">
                        <div class="row justify-content-center align-items-center h-100 text-center">
                            <div class="col-12">
                                Departamentos
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection