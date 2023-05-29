$(document).ready(function () {
    $.ajax({
        url: 'getEmployees',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#employeesTable').DataTable({
                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'names', title: 'Nombres' },
                    { data: 'last_names', title: 'Apellidos' },
                    { data: 'identification', title: 'Identificación' },
                    { data: 'email', title: 'Correo electrónico' },
                    { data: 'department', title: 'Departmanento' },
                    { data: 'role', title: 'Rol' },
                    { data: 'has_user', title: '¿Tiene usuario asignado?' },
                    {
                        data: 'id',
                        render: (employeeId) => "<a href='registro-empleado/" + employeeId + "' class='btn btn-primary'>Actualizar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                responsive:true
            });
        });
});