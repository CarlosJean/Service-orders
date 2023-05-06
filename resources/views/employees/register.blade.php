@extends('layouts.orders_template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-11">
            <div class="card shadow p-2">
                <div class="row">
                    <div class="col-12">
                        <h1>Registro de empleado</h1>
                        <hr class="opacity-100">
                        <form action="registro-empleado" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="">Documento de identificación</label>
                                    <input type="text" name="identification" id="" class="form-control" placeholder="Escriba el número de identificación">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="">Correo electrónico</label>
                                    <input type="email" name="email" id="" class="form-control" placeholder="Escriba el correo electrónico">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="">Nombres del empleado</label>
                                    <input type="text" name="names" id="" class="form-control" placeholder="Nombres">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="">Apellidos del empleado</label>
                                    <input type="text" name="last_names" id="" class="form-control" placeholder="Apellidos">
                                </div>
                                <div class="col-6 form-group">
                                    <div class="form-check row px-0">
                                        <label class="form-check-label col-11" for="flexCheckDefault">
                                            Crear usuario para este empleado
                                        </label>
                                        <input class="form-check-input col-1" type="checkbox" id="flexCheckDefault" name="create_user">
                                    </div>
                                </div>
                                <div class="col-12 form-group">
                                    <div class="row justify-content-end">
                                        <button  class="col-2 btn btn-secondary w-100" type="reset">Limpiar</button>
                                        <div class="col-2">
                                            <input type="submit" value="Guardar" class="btn btn-primary w-100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection