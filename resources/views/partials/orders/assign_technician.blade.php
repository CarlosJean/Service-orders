<div class="row justify-content-end p-md-3">
    @include('partials.orders.detail')
    @if($order->technician != null)
    <div class="form-group col-12">
        <div class="row">
            <div class="col-md-6">
                <label >Técnico asignado</label>
                <input type="text" class="form-control text-uppercase" value="{{$order->technician_fullname}}" readonly>
            </div>
        </div>
    </div>
    @endif
    @if($order->diagnosis != null)
    <div class="form-group col-12">
        <label>Informe técnico</label>
        <textarea cols="30" rows="5" class="form-control" readonly>{{$order->diagnosis}}</textarea>
    </div>
    @endif
    @if($order->status != 'desaprobado' && $order->observations == null)
    <div class="col-12">
        <hr />
        <h3>Asignación de técnico</h3>
    </div>
    <div class="col-12">
        <div class="container">
            <div class="row">
                <form action="./asignar-tecnico" method="post">
                    @csrf
                    <input type="hidden" name="order_number" value="{{$order->number}}">
                    <div class="row justify-content-between">
                        <div class="form-group col-md-4">
                            <label for="slcService">Servicio</label>
                            <select name="" id="slcService" class="form-select slcServices">
                                <option value="">Seleccione un servicio</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="slcTechnician">Técnico</label>
                            <select name="technician_id" id="slcTechnician" class="form-select slcTechnicians">
                                <option value="">Seleccione un técnico</option>
                            </select>
                            @if($errors->first('technician_id'))
                            <span class="text-danger">
                                <?= $errors->first('technician_id') ?>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 mt-2 mt-md-0">
                            <div class="row align-items-end h-100 m-0">
                                <div class="p-0">
                                    <input type="submit" value="Asignar técnico" class="btn btn-primary w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @if($order->technician == null)
    <div class="col-12">
        <hr />
        <h3>Desaprobación de la orden</h3>
        <form action="./desaprobar" method="post">
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
                <div class="form-group col-md-2 mt-2">
                    <input type="submit" value="Desaprobar" class="btn btn-warning w-100">
                </div>
                @endif
            </div>
        </form>
    </div>
    @endif
    <div class="col-12 p-md-0 mt-1 mt-md-3">
        <div class="row justify-content-center">
            <a class="btn btn-secondary col-3" href="{{URL::previous()}}">Volver</a>
            <a class="btn btn-secondary col-3 ms-2">
                <i class="typcn typcn-printer"></i>
                Imprimir
            </a>
        </div>
    </div>
</div>

<!-- Scripts -->
@vite([
'resources/js/app.js',
'resources/js/assignTechnician.js',
])