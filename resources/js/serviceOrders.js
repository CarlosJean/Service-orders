import * as language from './datatables.spanish.json';

const canCreateNewOrder = $("input[name='can_create_new_order']").val();

$(function () {
    loadServiceOrders();
});

const appendNewServiceOrderButton = function () {
    $("#newServiceOrderButton").append(`
        <a href="ordenes-servicio/crear" class="btn btn-primary mt-2 mt-md-0">
            <i class="typcn icon typcn-plus"></i>
            Nueva orden de servicio
        </a>
    `);
}

const loadServiceOrders = function () {

    const dom = (canCreateNewOrder)
        ? "<'row justify-content-end' <'col-sm-12 col-lg-4' f> <'#newServiceOrderButton.col-sm-12 col-lg-2 px-1 px-md-2'> >"
        : "f"; 

    $.ajax({
        url: 'ordenes-servicio/getOrders',
        type: 'get',
        dataType: 'json',
    })
        .done(function (orders) {
            $('#ordersTable').DataTable({
                data: orders.data,
                columns: columnsByUserRole(orders.user_role),
                dom,
                language,
                responsive: true
            });

            if (canCreateNewOrder) {
                appendNewServiceOrderButton();
            }
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
                render: (orderNumber) => `
                    <div class="row mx-1">
                        <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Desaprobar o asignar técnico</a>
                    </div>
                `,
                title: 'Acción'
            },
        ]
    }
}