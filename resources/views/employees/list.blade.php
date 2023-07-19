@extends('layouts.app')

@vite([
'resources/js/app.js',
'resources/js/employeesList.js',
'resources/css/whiteBackgroundColor.css',
])

@section('title', 'Empleados')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row">
            <div class="col-12">
                <h3>Listado de empleados</h3>
                <hr class="opacity-100">
            </div>
            <div class="col-12">
                <table id="employeesTable" class="table table-striped table-hover" style="font-size:12px;  width: 100%">
                    <thead class="thead-custom1"></thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection