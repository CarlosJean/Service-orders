@if($errors->has('error'))
<div class="alert alert-danger" role="alert">
    {{$errors->first('error')}}
</div>
@endif
<form action="crear" method="post">
    @csrf
    <input type="hidden" name="order_number" value="{{$orderNumber}}">
    <div class="form-group">
        <label for="txa_issue" class="form-label">Inconveniente</label>
        <textarea class="form-control" placeholder="¿Cuál es el inconveniente?" name="issue" rows=10 id="txa_issue"></textarea>
        @if($errors->first('issue'))
        <span class="text-danger">
            <?= $errors->first('issue') ?>
        </span>
        @endif
    </div>
    <div class="form-group">
        <div class="container">
            <div class="row justify-content-end">
                <a href="{{url('ordenes-servicio/')}}" class="btn btn-secondary col-2">Volver</a>
                <input type="submit" value="Crear" class="btn btn-primary col-2 ml-1">
            </div>
        </div>
    </div>
</form>