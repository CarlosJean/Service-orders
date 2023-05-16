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