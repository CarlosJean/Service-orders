@extends('layouts.app')


@section('content')

@section('title', 'Reportes')

@vite(['resources/js/reports.js','resources/css/whiteBackgroundColor.css',])

<!-- Inicio contenido -->
<br>
<div class="container">
<div class="card shadow" style="width: 70rem;">
  <div class="card-body">

    <label for="">Desde</label>
    <input type="date" id="desde">
    <label for="">Hasta</label>
    <input type="date" id="hasta">
    <label for="">Tipo de reporte</label>
    <select style="height:26px;" id="tipoReporte">
        <option>Seleccione el reporte</option> 
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

 