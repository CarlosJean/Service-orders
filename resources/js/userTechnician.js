
import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;

const slcServices =  $('#slcServices');
const inputol = $("#rol");
const inputEmpId = $("#emp");

$(document).ready(function () {

    $('#guardar').bind('click', function(e) {
        e.preventDefault();
       
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
                url: "setServices",
                type: 'post',
                data: {slcServices:slcServices.val(),EmpId:inputEmpId.val()},
                dataType: 'json',
                success: function (data) {
                    //if(data.type=='success') 
                    Swal.fire({
                        title: data.message,
                        icon:  data.type

                    }).then((result) => {    location.reload();     }) ;
                    //    else
                    //    Swal.fire({
                    //     title:  'Cambios no aplicados',
                    //     text: data.message,
                    //     icon:  'error'
                    // }).then((result) => {    location.reload();     }) ;
                }
            })
        }
    })    

});

    slcServices.select2({
        dropdownParent: $('#asignarMenu'),
        placeholder: 'Seleccione los servicios'
    });
    getServices();

    $.ajax({
        url: 'getUsersten',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#servicesTable').DataTable({

                "initComplete": function(settings, json) {
                               
                    $('.commonClass').bind('click', function(e) {

                        $(".modal-body input").val("")
                        $(".modal-body select").val(null).trigger('change');     
                        
                        e.preventDefault();
                        var value = this.value.split('-');
                            inputol.val(value[1]);
        
                            $("#emp").val(value[0]);
                            
                            $('#slcServices').val(getServicesByIdEmployee(value[0]));

        });
                },

                data: employees,


                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'names' , title: 'Nombre' }, 
                    { data: 'services' , title: 'Servicios asignados' }, 


                    
                    // { 
                    //     title:'Estado' ,
                    //     data: 'active', 
                    //     render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    // },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: function(data,type,row) {
                          
                            return '<button type="button"  class="btn btn-primary commonClass" value='+data+"-"+row.names+' id="asigMenu" data-bs-toggle="modal" data-bs-target="#asignarMenu">Asignar servicios</button>'; }

                        //render: (data, type, row) => '<button type="button" class="btn btn-primary asigMenu" value='+data+"-"+row.name+' id="asigMenu'+data+'" data-bs-toggle="modal" data-bs-target="#asignarMenu">Asignar menu</button>'
                    },
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });


});

function getServicesByIdEmployee(IdEmployee){
    var array = []
    $.ajax({
        url: "getServicesByIdEmployee",
        type: 'post',
        dataType: 'json',
        data: {IdEmployee:IdEmployee},
        }).done(function (data) {
            data.forEach(data => {
                array.push(data.id)
            });

           $("#slcServices").val(array).trigger('change');


        })
}

function getServices(){
    $.ajax({
        url: "ordenes-servicio/get-services",
        type: 'get',
        dataType: 'json',
                success: function (menu) {

            menu.forEach(menu => {
                const option = new Option(menu.name, menu.id);
                slcServices.append(option);
            });

        }
    })
}








