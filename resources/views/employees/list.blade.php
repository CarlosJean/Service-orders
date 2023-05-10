@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow p-3">
        <div class="row">
            <div class="col-12">
                <h3>Listado de empleados</h3>
                <hr class="opacity-100">
            </div>
            <div class="col-12">
                <a href="{{url('registro-empleado')}}" class="btn btn-primary">Crear nuevo empleado</a>
            </div>
            <div class="col-12">
                <div class="text-center" id="spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <table id="employeesTable" class="table table-bordered table-hover">
                    <thead class="thead-dark"></thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection