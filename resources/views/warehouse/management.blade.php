@extends('layouts.orders_template')

@section('screenName', 'Gestión de materiales')
@push('orderNumber')
<input type="text" readonly="readonly" class="form-control">
@endpush

@section('orderContent')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materialsManagement">
  Agregar artículo
</button>
<table class="table table-striped mt-2">
    <thead>
        <tr>
            <td>Artículo</td>
            <td>Referencia</td>
            <td>Descripción</td>
            <td>Medida</td>
            <td>Cantidad</td>
        </tr>
    </thead>
</table>
<!-- Material Management Modal -->
@include('partials.materials_management.add_materials')
@endsection

@vite(['resources/js/app.js', 'resources/js/materialsManagement.js'])