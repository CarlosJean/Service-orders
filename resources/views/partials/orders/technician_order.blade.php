<div class="row">
    @include('partials.orders.detail')

    @if($order->diagnosis != null)
    <div class="form-group col-12">
        <label for="txtDiagnosis">Informe técnico</label>
        <textarea name="" id="txtDiagnosis" cols="30" rows="5" class="form-control" readonly>{{$order->diagnosis}}</textarea>
    </div>
    @elseif($order->diagnosis == null && $order->start_date == null)
    <div class="col-12">
        <hr>
        <h3>Informe técnico</h3>
    </div>

    <form action="reporte-tecnico" method="post" class="col-12" id="frmTechnicalReport">
        @csrf
        <input type="hidden" name="order_number" value="{{$order->number}}">
        <div class="form-check col-12">
            <input type="checkbox" name="start" id="chk_start" class="form-check-input">
            <label for="chk_start" class="form-check-label">Iniciar al guardar</label>
        </div>
        <textarea id="" cols="30" rows="7" placeholder="Indique el informe técnico" class="form-control col-12" name="technical_report"></textarea>
        <div class="col-12">
            <div class="container">
                <div class="row justify-content-end py-2">
                    <input type="submit" value="Guardar" class="btn btn-primary col-md-3">
                </div>
            </div>
        </div>
    </form>
    @endif

    <div class="col-12 mb-2 mt-1">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-md-3 p-0">
                    <a href="{{url('ordenes-servicio')}}" class="btn btn-secondary w-100">Volver</a>
                </div>
                @if($order->diagnosis != null && $order->start_date == null)
                <div class="col-md-3 p-0 ps-md-2">
                    <form action="iniciar" method="post">
                        @csrf
                        <input type="hidden" name="order_number" value="{{$order->number}}">
                        <button class="btn btn-primary w-100 mt-1 mt-md-0" id="btnStartOrder" type="submit">Iniciar orden</button>
                    </form>
                </div>
                @elseif($order->start_date != null && $order->end_date == null)
                <div class="col-md-3 p-0 ps-md-2">
                    <form action="finalizar" method="post">
                        @csrf
                        <input type="hidden" name="order_number" value="{{$order->number}}">
                        <button class="btn btn-primary w-100" id="btnFinishOrder" type="submit">Finalizar orden</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@vite([
'resources/js/app.js',
'resources/js/technicianOrder.js'
])