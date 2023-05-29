const slcItems = $("#slc_items");
const btnAddItem = $("#btn_add_item");
const txtQuantity = $("#txt_quantity");
const tblOrderItems = $("#tbl_order_items");

$(function () {
    loadItems();
    slcItems.select2({
        placeholder: 'Seleccione un artículo',
        dropdownParent: $('#materialsManagement'),
    });
})

const loadItems = function () {
    $.ajax({
        url: '../../articulos',
        type: 'get',
        dataType: 'json',
        success: function (items) {
            //Limpiamos y cargamos los artículos al localstorage
            localStorage.setItem('items', JSON.stringify(items));

            //Limpiamos y cargalos los artículos al select
            slcItems.empty();
            slcItems.append(new Option('Seleccione material', ''));
            items.forEach((item) => {
                slcItems.append(new Option(item.name, item.id));
            });
        }
    });

};

//Consigue el artículo partir del id del artículo seleccionado.
const itemById = function (itemId) {
    const items = JSON.parse(localStorage.getItem('items'));
    return items.find(item => item.id == itemId);
}

slcItems.on('change', function () {
    //El id del artículo seleccionado en el select de artículos.
    const selectedItemId = $("#slc_items option:selected").val();

    //Se consigue la cantidad disponible del arículo seleccionado
    const selectedItemQuantity = itemById(selectedItemId).quantity;

    //Se muestra la cantidad disponible en la tabla de la vista.
    $("#td_current_quantity").text(selectedItemQuantity);
});

btnAddItem.on('click', function () {
    //El id del artículo seleccionado en el select de artículos.
    const selectedItemId = $("#slc_items option:selected").val();
    
    const wantedQuantity = txtQuantity.val();

    //Se consigue la cantidad disponible del arículo seleccionado
    const item = itemById(selectedItemId);

    const rowNumber = $("#orderItems tr").length;

    $("#orderItems").append(`
        <tr>       
            <input type="hidden" name="items[${rowNumber}][id]" value="${item.id}"/>
            <input type="hidden" name="items[${rowNumber}][quantity]" value="${wantedQuantity}"/>
            <td>${item.name}</td>
            <td>${item.reference}</td>
            <td>${item.measurement_unit}</td>
            <td>${wantedQuantity}</td>
            <td><button class="btn btn-warning btn_remove_item">Remover</button></td>
        </tr>
    `);
    
    txtQuantity.val('');
    tblOrderItems.removeClass('d-none');
});

$(document).on('click','.btn_remove_item',function(){
    const row = $(this).parents()[1];
    row.remove();

    const hasRows = $("#orderItems").children().length > 0;
    if (!hasRows) {
        tblOrderItems.addClass('d-none');
    }
});