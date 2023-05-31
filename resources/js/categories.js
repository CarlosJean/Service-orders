
import applyStyle from '../js/azia.js';


$(document).ready(function () {


    $.ajax({
        url: 'get-categories',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                "initComplete": function(settings, json) {
                               
                    applyStyle('<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleModal">+ Nueva categoria</button>')

                },

                data: employees,

                columns: [
                    { data: 'id', title: 'id' },
                    { data: 'name', title: 'nombre' },      
                    { data: 'description', title: 'descripcion' },        
  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (id) => "<a href='update-categories/" + id + "' class='btn btn-primary'>Eliminar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });


});








