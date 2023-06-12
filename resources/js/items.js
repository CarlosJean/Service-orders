import applyStyle from '../js/azia.js';


$(document).ready(function () {

    $(".btn").click(function(){
        $("#myModal").modal('show');
    });

      
    $.ajax({
        url: 'get-items',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                "initComplete": function(settings, json) {                   
                    
                       applyStyle('<button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"> + Nuevo articulo</button>')
   
                   },

                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'name', title: 'Nombre' },        
                    { data: 'quantity', title: 'Cantidad' },        
                    { data: 'measurement_unit', title: 'Medida' },        
                    { data: 'price', title: 'Precio' },        
                    { data: 'reference', title: 'Referencia' },   
                    // { data: 'ident', title: 'RNC/Cedula' },        
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-items/" + Id + "' class='btn btn-primary'>Eliminar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });


});








