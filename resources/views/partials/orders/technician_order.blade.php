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

        <div class="row pt-3">
            <div class="col-12">
                <div class="col-12">
                    <div class="row justify-content-end">
                        <h3 class="col-10 text-left p-0">Materiales</h3>
                        <input type="submit" value="Guardar" class="btn btn-primary col-2">
                    </div>
                </div>
                <hr class="opacity-100">
            </div>
            <div class="col-12">
                <div class="row m-0">
                    <div class="col-4 form-group p-0">
                        <label for="txt_material_name">Nombre artículo</label>
                        <select name="" id="txt_material_name" class="form-control"></select>
                    </div>
                    <div class="col-4 form-group">
                        <label for="txt_material_quantity">Cantidad</label>
                        <input type="text" name="" id="txt_material_quantity" class="form-control" placeholder="Ingrese la cantidad deseada">
                    </div>
                    <div class="col-4 form-group">
                        <div class="row row align-items-end h-100">
                            <button class="btn btn-secondary" id="btn_add_material" type="button">Añadir</button>
                        </div>
                    </div>
                    <table class="table d-none" id="tbl_materials">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Material</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="materials"></tbody>
                    </table>
                </div>
            </div>
        </div>


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