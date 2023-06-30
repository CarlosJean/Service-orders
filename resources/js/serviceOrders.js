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
    } else if (userRole == 'maintenanceSupervisor' || userRole == 'maintenanceManager') {
        return [
            { data: 'id', title: 'Id' },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            {
                data: null,
                render: (data) => {             
                    console.log(userRole);
                    const requestedItems = data.items_requested
                    const orderNumber = data.order_number

                    if (!requestedItems || userRole == 'maintenanceSupervisor') {
                        return `<div class="row mx-1 justify-content-around">
                            <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary col-md-5'>Desaprobar o asignar técnico</a>
                            <a href='ordenes-servicio/${orderNumber}/gestion-materiales' class='btn btn-primary col-md-5 mt-2 mt-md-0'>Gestión de materiales</a>
                        </div>`;
                    }else if(requestedItems && userRole == 'maintenanceManager'){
                        return `<div class="row mx-1 justify-content-between">
                            <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary col-md-4'>Desaprobar o asignar técnico</a>
                            <a href='ordenes-servicio/${orderNumber}/gestion-materiales' class='btn btn-primary col-md-3 mt-2 mt-md-0'>Gestión de materiales</a>
                            <a href='ordenes-servicio/${orderNumber}/aprobacion-materiales' class='btn btn-primary col-md-3 mt-2 mt-md-0'>Aprobar materiales</a>
                        </div>`;
                    }
                },
                title: 'Acción'
            },
        ]
    } else if (userRole == 'maintenanceTechnician') {
        return [
            { data: 'id', title: 'Id' },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            {
                data: 'order_number',
                render: (orderNumber) => `
                    <div class="row mx-1">
                        <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Detalles</a>
                    </div>
                `,
                title: 'Acción'
            },
        ]
    }
}