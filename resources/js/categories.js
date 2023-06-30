
import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;


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
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-categories/" + Id + "' class='btn btn-primary'>Activar/Desactivar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });


});








