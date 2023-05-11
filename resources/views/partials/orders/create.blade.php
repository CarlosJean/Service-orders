<form action="crear" method="post">
    @csrf
    <input type="hidden" name="order_number" value="{{$orderNumber}}">
    <div class="form-group">
        <label for="txa_issue" class="form-label">Inconveniente</label>
        <textarea class="form-control" placeholder="¿Cuál es el inconveniente?" name="issue" rows=10 id="txa_issue"></textarea>
    </div>
    <div class="form-group row justify-content-end">
        <input type="submit" value="Crear" class="btn btn-primary col-2">
    </div>
</form>