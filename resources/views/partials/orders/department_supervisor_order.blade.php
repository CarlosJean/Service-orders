<div class="row justify-content-end p-md-3">
    @include('partials.orders.detail')
    <div class="form-group col-12">
        <label for="txtIssue">Informe técnico</label>
        <textarea name="" id="txtIssue" cols="30" rows="5" class="form-control" readonly>{{$order->diagnosis}}</textarea>
    </div>
    <div class="col-12 p-md-0 mt-1 mt-md-3">
        <div class="row justify-content-center">
            <a class="btn btn-secondary col-3" href="{{URL::previous()}}">Volver</a>
        </div>
    </div>
</div>

<!-- Scripts -->
@vite([
'resources/js/app.js',
'resources/js/assignTechnician.js',
])