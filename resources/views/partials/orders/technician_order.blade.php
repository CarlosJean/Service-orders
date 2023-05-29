<div class="row">
    @include('partials.orders.detail')
    <div class="col-12">
        <h3>Informe técnico</h3>
        <hr class="opacity-100">
    </div>
    <form action="" method="post" class="col-12">
        <div class="form-check col-12">
            <input type="checkbox" name="start" id="chk_start" class="form-check-input">
            <label for="chk_start" class="form-check-label">Iniciar al guardar</label>
        </div>
        <textarea name="" id="" cols="30" rows="7" placeholder="Indique el informe técnico" class="form-control col-12"></textarea>        
        <div class="col-12">
            <div class="row justify-content-end py-2">
                <input type="submit" value="Guardar" class="btn btn-primary col-2">
            </div>
        </div>
    </form>
</div>

@vite([
    'resources/js/app.js',
    'resources/js/technicianOrder.js'
])