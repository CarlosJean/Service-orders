@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row justify-content-center w-100">
        <div class="card shadow col-6 p-3">
            <div class="row">
                <div class="col-12">
                    @if($employee_id > 0)
                    <h3 class="my-0">¡Empleado actualizado satisfactoriamente!</h3>
                    @else
                    <h3 class="my-0">¡Empleado creado satisfactoriamente!</h3>
                    @endif
                    <hr class="opacity-100">
                </div>
                <div class="col-12">
                    @if($employee_id > 0)
                    <p>Los datos del empleado <strong>{{$employee_name ?? ''}}</strong> han sido actualizados satisfactoriamente.</p>
                    @else
                    <p>El empleado <strong>{{$employee_name ?? ''}}</strong> ha sido registrado exitosamente.</p>
                    @endif
                </div>
                <div class="col-12">
                    <div class="row justify-content-end">
                        <a href="{{url('registro-empleado')}}" class="col-3 btn btn-secondary">Registrar otro empleado</a>
                        <a href="{{url('registro-empleado')}}" class="mx-3 col-3 btn btn-primary">Listado de empleados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection