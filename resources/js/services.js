
import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;


$(document).ready(function () {


    $.ajax({
        url: 'getServices',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#servicesTable').DataTable({

                "initComplete": function(settings, json) {
                               
                    applyStyle('<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleModal">+ Nuevo servicio</button>')

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
                                url:  `update-services/${Id}`,
                                type: 'get',
                               // data: {slcServices:slcServices.val(),EmpId:inputEmpId.val()},
                                dataType: 'json',
                                success: function (data) {
                    
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
                    { data: 'name', title: 'Descripcion' },        
                    { 
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-services/" + Id + "' class='btn btn-primary btn-sm'>Activar/Desactivar</a>"
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });


});








