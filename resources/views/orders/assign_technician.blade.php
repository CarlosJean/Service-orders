@vite([
'resources/js/app.js',
'resources/js/assignTechnician.js',
])

@extends('layouts.orders_template')

@section('screenName','Órden de servicio')
@push('orderNumber')
<input type="text" value="{{$order->number}}" readonly id="txt_order_number" class="form-control">
@endpush

@section('orderContent')
<div class="row justify-content-end p-3">
    <div class="col-12">
        <h3>Detalle de la orden</h3>
        <hr class="opacity-100">
    </div>

    <div class="form-group col-6">
        <label for="txt_required_by">Requerido por</label>
        <input type="text" name="" id="txt_required_by" readonly class="form-control" value="{{$order->requestor}}">
    </div>
    <div class="form-group col-6">
        <label for="txt_requird_by">Fecha y hora de solicitud</label>
        <input type="text" name="" id="txt_requird_by" readonly class="form-control" value="{{$order->created_at}}">
    </div>
    <div class="form-group col-12">
        <label for="">Problema</label>
        <textarea name="" id="" cols="30" rows="5" class="form-control" readonly>{{$order->issue}}</textarea>
    </div>
    @if($order->status != 'desaprobado' && $order->observations == null)
    <div class="col-12">
        <h3>Asignación de técnico</h3>
        <hr class="opacity-100" />
    </div>
    <div class="col-12">
        <div class="row">
            <form action="../asignar-tecnico" method="post">
                @csrf
                <input type="hidden" name="order_number" value="{{$order->number}}">
                <div class="row justify-content-between">
                    <div class="form-group col-4">
                        <label for="">Servicio</label>
                        <select name="" id="" class="form-select slcServices">
                            <option value="">Seleccione un servicio</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="">Técnico</label>
                        <select name="technician_id" id="" class="form-select slcTechnicians">
                            <option value="">Seleccione un técnico</option>
                        </select>
                        @if($errors->first('technician_id'))
                        <span class="text-danger">
                            <?= $errors->first('technician_id') ?>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-2">
                        <div class="row align-items-end h-100">
                            <div>
                                <input type="submit" value="Asignar técnico" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    @if($order->technician == null)
    <div class="col-12">
        <h3>Desaprobación de la orden</h3>
        <hr class="opacity-100" />
        <form action="../desaprobar" method="post">
            @csrf
            <input type="hidden" name="order_number" value="{{$order->number}}">
            <div class="row justify-content-end">
                <div class="form-group col-12">
                    <label for="">Observación</label>
                    @if($order->status != 'desaprobado' && $order->observations == null)
                    <textarea name="observations" id="" cols="30" rows="5" class="form-control"></textarea>
                    @else
                    <textarea name="observations" id="" cols="30" rows="5" class="form-control" readonly>{{$order->observations}}</textarea>
                    @endif
                    @if($errors->first('observations'))
                    <span class="text-danger">
                        <?= $errors->first('observations') ?>
                    </span>
                    @endif
                </div>
                @if($order->status != 'desaprobado' && $order->observations == null)
                <div class="form-group col-2">
                    <input type="submit" value="Desaprobar" class="btn btn-warning w-100">
                </div>
                @endif
            </div>
        </form>
    </div>
    @endif
    <div class="col-12 p-0">
        <div class="row justify-content-center">
            <a class="btn btn-primary col-3" href="http://localhost/service-orders/public/ordenes-servicio">Volver</a>
        </div>
    </div>
</div>
@endsection