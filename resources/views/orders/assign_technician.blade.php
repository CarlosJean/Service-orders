@extends('layouts.orders_template')

@section('screenName','Órden de servicio')
@push('orderNumber')
<input type="text" value="" readonly id="txt_order_number" class="form-control">
@endpush

@section('orderContent')
<div class="row">
    <form action="" method="post">
        <div class="row justify-content-center">
            <div class="form-group col-4">
                <label for="">Servicio</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="">Técnico</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="form-group col-3">
                <div class="row align-items-end h-100">
                    <div>
                        <input type="submit" value="Asignar técnico" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="form-group col-12">
        <label for="">Problema</label>
        <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
    </div>
    <div class="form-group col-6">
        <label for="">Observación</label>
        <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
    </div>
    <div class="form-group col-6">
        <label for="">Informe técnico</label>
        <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-4">
        <div class="row justify-content-center">
            <div class="col-7 my-0 text-center requestor-signature-line">
                <label for="">Jean Carlos Holguin</label>
            </div>
            <div class="col-6 my-0 text-center">
                <label for=""><strong>Requerido por</strong></label>
            </div>
        </div>
    </div>
</div>
@endsection