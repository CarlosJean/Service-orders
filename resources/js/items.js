import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;


$(document).ready(function () {

    $("input[id*='txtQty']").keydown(function (event) {


        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

        } else {
            event.preventDefault();
        }

        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault(); 
        //if a decimal has been added, disable the "."-button

    });

    $(".btn").click(function(){
        $("#myModal").modal('show');
    });

      
    $.ajax({
        url: 'getItemsAll',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                "initComplete": function(settings, json) {                   
                    
                       applyStyle('<button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"> + Nuevo articulo</button>')
   
                       $('.btn-sm').bind('click', function(e) {
                        e.preventDefault();
                        var Id= this.href.substring(this.href.lastIndexOf('/') + 1); 
                    
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
                                url:  `update-items/${Id}`,
                                type: 'get',
                               // data: {slcServices:slcServices.val(),EmpId:inputEmpId.val()},
                                dataType: 'json',
                                success: function (data) {
                    
                                  //  location.reload(); 
                                    if(data.type=='success') 
                                    Swal.fire({
                                        title: data.message,
                                        icon:  data.type
                    
                                    }).then((result) => {    location.reload();     }) ;
                                       else
                                       Swal.fire({
                                        title:  'Cambios no aplicados',
                                        text: data.message,
                                        icon:  'error'
                                    }).then((result) => {    location.reload();     }) ;
                                }
                            })
                        }
                    })    
                    
                    });
                   },

                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'name', title: 'Nombre' },        
                    { data: 'quantity', title: 'Cantidad' },        
                    { data: 'measurement_unit', title: 'Medida' },        
                    { data: 'price', title: 'Precio' },        
                    { data: 'reference', title: 'Referencia' },   
                    { 
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-items/" + Id + "' class='btn btn-primary btn-sm'>Activar/Desactivar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });


});









