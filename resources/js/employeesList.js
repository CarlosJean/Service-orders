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

        "initComplete": function(settings, json) {
                             
            $('.commonClass').bind('click', function(e) {
                e.preventDefault();
                var value = this.value;
                Swal.fire({
                    title: 'Esta seguro que desea proceder con la accion?',
                    // text: "Un usuario desactivado no podra acceder al sistema.",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `update-employee/${value}`,
                            type: 'get',
                            dataType: 'json',
                        })
                            .done(function (data) {
                                if(data==1) 
                                Swal.fire({
                                    title:  'Usuario activado!',
                                    text: 'Este usuario ya puede acceder al sistema.',
                                    icon:  'success'
                                }).then((result) => {    location.reload();     }) ;
                                   else
                                   Swal.fire({
                                    title:  'Usuario desactivado!',
                                    text: 'Este usuario ya no puede acceder al sistema.',
                                    icon:  'success'
                                }).then((result) => {    location.reload();     }) ;
                                                        
                            });
                    }
                  })                 
});
 

        },   
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
            { data: 'department', title: 'Departamento' },
            { data: 'role', title: 'Rol' },
            { data: 'has_user', title: '¿Tiene usuario asignado?' },
            { 
                title:'Estado' ,
                data: 'active', 
                render: function(employeeId) { if(employeeId==0) return "Inactivo"; else return "Activo"; }
            }, 
            
            {
                data: 'id',
                render: (employeeId) => "<a href='registro-empleado/" + employeeId + "' class='btn btn-primary btn-sm'>Actualizar</a>",
                title: 'Acción 1'
            },
            {
                data: 'userId',
                render: (employeeId) =>  "<button type='button' value='" +employeeId+"' class='btn btn-primary btn-sm commonClass'>Activar/Desactivar</button>",
                title: 'Acción 2'
            },
        ],
        dom: "<'row justify-content-end' <'col-sm-12 col-lg-4' f> <'#newEmployeeButton.col-sm-12 col-lg-2 px-1'> >",
        responsive: true,
        language
    })

    appendNewEmployeeButton();
};