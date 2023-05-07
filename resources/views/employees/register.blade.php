@extends('layouts.orders_template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-11">
            <div class="card shadow p-2">
                <div class="row">
                    <div class="col-12">
                        @if($errors->has('error'))
                        <ul class="alert alert-danger">
                            {{$errors->first('error')}}
                        </ul>
                        @endif
                        <h1>Registro de empleado</h1>
                        <hr class="opacity-100">
                        @if(isset($employee))
                        @include('partials.employees.update')
                        @else
                        @include('partials.employees.create')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection