@vite([
'resources/js/app.js',
'resources/js/quotesIndex.js',
'resources/css/whiteBackgroundColor.css',
])

@extends('layouts.app')

@section('title', 'Cotizaciones pendientes')

@section('content')
<div class="container">
    <div class="card p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2><strong>Cotizaciones pendientes</strong></h2>
                <hr>
            </div>
            <div class="col-12">
                <input type="hidden" name="can_create_new_order">
                <table id="quotesTable" class="table table-striped table-hover">
                    <thead class="thead-custom1"></thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection