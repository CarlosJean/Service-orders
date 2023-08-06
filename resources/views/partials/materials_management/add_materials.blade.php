<div class="modal fade" id="materialsManagement" tabindex="-1" aria-labelledby="materialsManagementLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="materialsManagementLabel">Agregar materiales</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmAddItem">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="" class="col-12">Artículo</label>
                <select name="item" id="slc_items" class="form-select col-12" style="width: 100%;"></select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-12">Cantidad Actual</label>
                <label id="td_current_quantity" class="text-center w-100"></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Cantidad</label>
                <input type="number" class="form-control" id="txt_quantity" min="1" name="quantity">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_add_item">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>