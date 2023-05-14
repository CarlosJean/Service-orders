$(document).ready(function () {
    $.ajax({
        url: 'ordenes-servicio/getOrders',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {
            $("#spinner").css('display', 'none');

            $('#ordersTable').DataTable({
                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'order_number', title: 'Número de órden' },
                    { data: 'created_at', title: 'Fecha y hora de creación' },
                    { data: 'status', title: 'Estado' },
                    { data: 'technician', title: 'Técnico asignado' },
                ],
                dom: "<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });
});