$(document).ready(function () {
    $.ajax({
        url: 'employees',
        type: 'get',
        dataType: 'json',
    })
    .done(function (employees) {
        $('#myTable').DataTable({
            data: employees,
            columns:[
                {data:'id', title:'Id'},
                {data:'names', title:'Nombres'},
                {data:'last_names', title:'Apellidos'},
                {data:'identification', title:'Identificación'},
                {data:'email', title:'Correo electrónico'},
                {data:'department', title:'Departmanento'},
                {data:'role', title:'Rol'},
                {data:'has_user', title:'¿Tiene usuario asignado?'},
            ]
            });
        });
});