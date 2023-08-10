const btnAddMaterial = $("#btn_add_material");
const materials = $("#materials");
const txtMaterialName = $("#txt_material_name");
const txtMaterialQuantity = $("#txt_material_quantity");
const tblMaterials = $("#tbl_materials");
const frmTechnicalReport = $("#frmTechnicalReport");
const validationRules = {
    rules: {
        technical_report: {
            required: true
        },
    },
    messages: {
        technical_report: 'Debe indicar el informe técnico',
    },
    errorClass: 'text-danger'
};

var validator = frmTechnicalReport.validate(validationRules);

const removeRow = function () {
    const row = $(this).parent()
        .parent();
    row.remove();
    const materialCount = $('#materials tr').length;
    if(materialCount == 0) tblMaterials.addClass('d-none');
}

const addMaterial = function (e) {

    tblMaterials.removeClass('d-none');;

    const material = `
    <tr>
        <td class="align-middle">Algo</td>
        <td class="align-middle">${txtMaterialQuantity.val()}</td>
        <td class="row justify-content-end align-middle">
            <input type="button" value="Remover" class="btn btn-warning removeRow">
        </td>
    </tr>
    `;

    materials.append(material);
};

btnAddMaterial.on('click', addMaterial);
$(document).on('click','.removeRow', removeRow);