import * as language from './datatables.spanish.json';

const tblItems = $("#tblItems");
var itemsTable = null;
const txtServiceOrder = $("#txtServiceOrder");
const btnFindOrderItems = $("#btnFindOrderItems");
var findServiceOrderItemsUrl = '../ordenes-servicio/materiales';
const btnDispatch = $("#btnDispatch");

$(function () {
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
            url: findServiceOrderItemsUrl,
            data: { service_order_number: serviceOrderNumber },
            type: 'post',
            dataType: 'json',
            dataSrc: function (serviceOrderItems) {

                if (serviceOrderItems.data.length == 0) {
                    btnDispatch.prop('disabled', true);
                } else {
                    btnDispatch.prop('disabled', false);
                }

                $("#items").removeClass('d-none');
                $("#errorMessage").add('d-none');
                $("input[name='service_order_id']").val(serviceOrderNumber);
                return serviceOrderItems.data;
            },
            error: function (error) {
                $("#errorMessage").text(error.responseJSON.message);
                $("#items").addClass('d-none');
                $("#errorMessage").removeClass('d-none');
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

btnDispatch.on('click', function () {
    var form = document.getElementById("frmDispatchItems");
    form.submit();
});


btnFindOrderItems.on('click', function (e) {
    e.preventDefault();

    const serviceOrderNumber = txtServiceOrder.val();
    serviceOrderItems(serviceOrderNumber);
});