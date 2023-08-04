<div class="col-12">
    <hr />
    <h3>Detalle de la orden</h3>
</div>

<div class="form-group col-md-3">
    <label for="txt_required_by">Requerido por</label>
    <input type="text" name="" id="txt_required_by" readonly class="form-control" value="{{$order->requestor}}">
</div>
<div class="form-group col-md-3">
    <label for="txt_requird_by">Fecha y hora de solicitud</label>
    <input type="text" name="" id="txt_requird_by" readonly class="form-control" value="{{$order->created_at}}">
</div>
<div class="form-group col-md-3">
    <label for="txt_department">Departamento</label>
    <input type="text" name="" id="txt_department" readonly class="form-control" value="{{$order->department}}">
</div>
<div class="form-group col-md-3">
    <label for="txt_required_by">Estado</label>
    <input type="text" name="" id="txt_required_by" readonly class="form-control text-uppercase" value="{{$order->status}}">
</div>
<div class="form-group col-12">
    <label for="txtIssue">Problema</label>
    <textarea name="" id="txtIssue" cols="30" rows="5" class="form-control" readonly>{{$order->issue}}</textarea>
</div>