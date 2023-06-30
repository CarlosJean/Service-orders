@extends('layouts.app')


@section('content')


@vite(['resources/js/reports.js'])


<!-- Inicio contenido -->
<br>
<div class="container">
<div class="card shadow" style="width: 70rem;">
  <div class="card-body">
    <!-- <select style="height:26px;">
        <optgroup label="Presente">
            <option>Hoy</option>
            <option>Esta semana</option>
            <option>Este mes</option>
            <option>Este año</option>
        </optgroup>
        <optgroup label="Anterior">
            <option>Ayer</option>
            <option>Semana anterior</option>
            <option>Mes anterior</option>
            <option>Año anterior</option>
        </optgroup>
           </select>
     -->
    <label for="">Desde</label>
    <input type="date" id="desde">
    <label for="">Hasta</label>
    <input type="date" id="hasta">
    <label for="">Tipo de reporte</label>
    <select style="height:26px;" id="tipoReporte">
        <option>Seleccione el reporte</option>
        <option>Reporte de compras</option>
        <option>Reporte costo por servicios</option>
        <option>Reporte servicios</option>
        <!-- <option>Reporte de aprobaciones</option> -->
        <option>Reporte de usuarios registrados</option>
        <!-- <option>Reporte de ajuste de inventario</option> -->
       
 </select>

    <button type="button" id="getReport" class="btn btn-warning btn-sm" style="margin-top:-4px ;">Generar reporte</button>
    <button type="button" class="btn btn-secondary btn-sm" id="export" style="margin-top:-4px ;">Exportar a excel</button>           

    <br>
    <br>
    <p>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

<table class="table table-striped" id="dataTable">
</table>
</div>
</div>

</div>
<!-- Final contenido -->

@endsection

 