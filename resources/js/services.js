
import applyStyle from '../js/azia.js';


$(document).ready(function () {


    $.ajax({
        url: 'ordenes-servicio/get-services',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#servicesTable').DataTable({

                "initComplete": function(settings, json) {
                               
                    applyStyle('<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleModal">+ Nuevo servicio</button>')

                },

                data: employees,


                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'name', title: 'Descripcion' },        
                    { 
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-services/" + Id + "' class='btn btn-primary'>Activar/Desactivar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });


});








