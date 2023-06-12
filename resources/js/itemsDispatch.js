const tblItems = $("#tblItems");
var itemsTable = null;
const txtServiceOrder = $("#txtServiceOrder");
const btnFindOrderItems = $("#btnFindOrderItems");

//Funciones
const serviceOrderItems = function (serviceOrderNumber) {
    itemsTable = tblItems.DataTable({
        ajax: {
            url: '../ordenes-servicio/materiales',
            data: { service_order_number: serviceOrderNumber },
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
        dom: 'ftp',
        destroy: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
};

$("#btnDispatch").on('click', function () {
    var selectedRowsData = itemsTable?.rows('.selected')?.data();

    console.log(selectedRowsData);
    if (selectedRowsData == undefined) {
        Swal.fire({
            icon: 'error',
            text: 'Debe seleccionar los materiales a despachar.',
        });
    }

    var form = document.getElementById("frmDispatchItems");

    for (let index = 0; index < selectedRowsData.length; index++) {
        const element = selectedRowsData[index];
        $(form).append(`<input type="hidden" name="items[${index}]" value="${element.id}" />`)
    }

    form.submit();
});


btnFindOrderItems.on('click', function (e) {
    e.preventDefault();

    const serviceOrderNumber = txtServiceOrder.val();
    serviceOrderItems(serviceOrderNumber);
});