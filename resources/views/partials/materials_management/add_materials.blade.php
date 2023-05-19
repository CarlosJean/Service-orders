<div class="modal fade" id="materialsManagement" tabindex="-1" aria-labelledby="materialsManagementLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="materialsManagementLabel">Agregar materiales</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Artículo</td>
                    <td>Cantidad Actual</td>
                    <td>Cantidad</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="" id="slc_items" style="width:200px"></select>
                    </td>
                    <td id="td_current_quantity"></td>
                    <td id="td_quantity">
                        <input type="number" class="form-control">
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_add_item">Agregar</button>
      </div>
    </div>
  </div>
</div>