const tblItems = $("#tblItems");
var itemsTable = null;

$(function () {
    serviceOrderItems();
})

//Funciones
const serviceOrderItems = function () {
    itemsTable = tblItems.DataTable({
        ajax: {
            url: '../ordenes-servicio/materiales',
            data: { service_order_number: '546646' },
            type: 'post',
            dataType: 'json'
        },
        processing: true,
        columns: [
            { title: '', data: null, defaultContent: "" },
            { title: 'Id', data: "id" },
            { title: 'Artículo', data: "name" },
            { title: 'Referencia', data: 'reference' },
            { title: 'Cantidad', data: 'quantity' },
        ],
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
    });
};

$("#btnDispatch").on('click', function(){
    var selectedRowsData = itemsTable.rows('.selected').data();

    var form = document.getElementById("frmDispatchItems");
    var formData = new FormData(form);
    
    for (let index = 0; index < selectedRowsData.length; index++) {
        const element = selectedRowsData[index];
        $(form).append(`<input type="hidden" name="items[${index}]" value="${element.id}" />`)
    }
    
    form.submit();
});
