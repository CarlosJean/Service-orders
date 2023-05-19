

$(function () {
    $.ajax({
        url: 'ordenes-servicio/getOrders',
        type: 'get',
        dataType: 'json',
    })
        .done(function (orders) {
$("#spinner").css('display', 'none');

            $('#ordersTable').DataTable({
                data: orders.data,
                columns: columnsByUserRole(orders.user_role),
                dom: "<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                responsive:true
            });

        });  
});

const columnsByUserRole = function (userRole) {
    if (userRole == 'departmentSupervisor') {
        return [
            { data: 'id', title: 'Id', visible:false },
            { data: 'order_number', title: 'Número de órden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'status', title: 'Estado' },
            { data: 'technician', title: 'Técnico asignado' },
        ]
    } else if (userRole == 'maintenanceSupervisor') {
        return [
            { data: 'id', title: 'Id' },
            { data: 'order_number', title: 'Número de órden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            {
                data: 'order_number',
                render: (orderNumber) => "<a href='ordenes-servicio/" + orderNumber + "' class='btn btn-primary'>Desaprobar o asignar técnico</a>"
            },
        ]
    }
}