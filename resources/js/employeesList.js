import * as language from './datatables.spanish.json' ;

$(function () {
    loadEmployeesTable();
});

const appendNewEmployeeButton = function () {
    $("#newEmployeeButton").append(`
        <a href="registro-empleado" class="btn btn-primary w-100">
            <i class="typcn icon typcn-plus"></i>
            Crear nuevo empleado
        </a>
    `);
}

const loadEmployeesTable = function () {

    $('#employeesTable').DataTable({
        ajax: {
            url: 'getEmployees',
            type: 'get',
            dataType: 'json'
        },
        columns: [
            { data: 'names', title: 'Nombres' },
            { data: 'last_names', title: 'Apellidos' },
            { data: 'identification', title: 'Identificación' },
            { data: 'email', title: 'Correo electrónico' },
            { data: 'department', title: 'Departmanento' },
            { data: 'role', title: 'Rol' },
            { data: 'has_user', title: '¿Tiene usuario asignado?' },
            {
                data: 'id',
                render: (employeeId) => "<a href='registro-empleado/" + employeeId + "' class='btn btn-primary'>Actualizar</a>",
                title: 'Acción'
            },
        ],
        dom: "<'row justify-content-end' <'col-sm-12 col-lg-4' f> <'#newEmployeeButton.col-sm-12 col-lg-2 px-1'> >",
        responsive: true,
        language
    })

    appendNewEmployeeButton();
};