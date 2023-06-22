import * as language from './datatables.spanish.json';

$(function () {
    loadServiceOrders();
});

const appendNewServiceOrderButton = function () {
    $("#newServiceOrderButton").append(`
        <a href="ordenes-servicio/crear" class="btn btn-primary w-100 mt-2 mt-md-0">
            <i class="typcn icon typcn-plus"></i>
            Nueva orden de servicio
        </a>
    `);
}

const loadServiceOrders = function () {

    $.ajax({
        url: 'ordenes-servicio/getOrders',
        type: 'get',
        dataType: 'json',
    })
    .done(function (orders) {
        $('#ordersTable').DataTable({
            data: orders.data,
            columns: columnsByUserRole(orders.user_role),
            dom: "<'row justify-content-end' <'col-sm-12 col-lg-4' f> <'#newServiceOrderButton.col-sm-12 col-lg-2 px-1'> >",
            language,
            responsive: true
        });
        appendNewServiceOrderButton();
    });

};

const columnsByUserRole = function (userRole) {
    if (userRole == 'departmentSupervisor') {
        return [
            { data: 'id', title: 'Id', visible: false },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'status', title: 'Estado' },
            { data: 'technician', title: 'Técnico asignado' },
        ]
    } else if (userRole == 'maintenanceSupervisor') {
        return [
            { data: 'id', title: 'Id' },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            {
                data: 'order_number',
                render: (orderNumber) => "<a href='ordenes-servicio/" + orderNumber + "' class='btn btn-primary'>Desaprobar o asignar técnico</a>"
            },
        ]
    }
}