import * as language from './datatables.spanish.json' ;

const tblItems = $("#tblItems");
var itemsTable = null;
const txtServiceOrder = $("#txtServiceOrder");
const btnFindOrderItems = $("#btnFindOrderItems");
var findServiceOrderItemsUrl = '../ordenes-servicio/materiales';

$(function(){
    $("#dvOrderNumber").addClass('d-none');
    const serviceOrderNumber = txtServiceOrder.val();
    if (serviceOrderNumber != "") {
        findServiceOrderItemsUrl = '../../ordenes-servicio/materiales';
        btnFindOrderItems.trigger('click');
    }
});

//Funciones
const serviceOrderItems = function (serviceOrderNumber) {
    itemsTable = tblItems.DataTable({
        ajax: {
            url:findServiceOrderItemsUrl,
            data: { service_order_number: serviceOrderNumber },
            type: 'post',
            dataType: 'json',
            dataSrc:function(serviceOrderItems){
                $("#items").removeClass('d-none');
                return serviceOrderItems.data;
            },
            error:function(){
                $("#items").addClass('d-none');
            }
        },
        processing: true,
        columns: [
            { title: 'Artículo', data: "name" },
            { title: 'Referencia', data: 'reference' },
            { title: 'Cantidad', data: 'quantity' },
        ],
        dom: 'ftp',
        destroy: true,
        language,
    });
};

$("#btnDispatch").on('click', function () {
    var selectedRowsData = itemsTable?.rows()?.data();

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