import * as language from './datatables.spanish.json';

const quotesTable = $("#quotesTable");

$(function () {
    pendingItemsRequests();
});

const pendingItemsRequests = function () {

    $.ajax({
        url: './solicitud-materiales/pendientes',
        type: 'post',
        dataType: 'json',
        success: function (orderItems) {

            let dom = "ft";
            let actionVisible = true;
            if (orderItems.user_system_role != "warehouseman") {
                actionVisible = false;
            }
            
            quotesTable.DataTable({
                data: orderItems.data,
                columnDefs:[
                    {
                        targets: 4,
                        visible: actionVisible,
                    }
                ],
                columns: [
                    { title: 'Orden de servicio', data: "service_order_number" },
                    { title: 'Fecha solicitud', data: "material_request_date" },
                    { title: 'Solicitador', data: "requestor" },
                    { title: 'Estado', data: "status" },
                    {
                        title: 'Acción',
                        data: 'service_order_number',
                        render: (serviceOrderNumber) => "<a href='articulos/despachar/" + serviceOrderNumber + "' class='btn btn-primary'>Despachar materiales</a>" 
                    },
                ],
                dom,
                language,
            });
        },
    });
};