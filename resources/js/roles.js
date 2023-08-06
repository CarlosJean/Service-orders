
import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;

const slcMenus = $(".slcMenus");
const slcSubmenu = $(".slcSubmenu");
const inputol = $("#rol");
const inputrolId = $("#rolId");


const getServices = function () {
    $.ajax({
        url: "get-menu",
        type: 'get',
        dataType: 'json',
        success: function (menu) {

            slcMenus.empty();

            const option = new Option('Seleccione un menu', '');
            slcMenus.append(option);

            menu.forEach(menu => {
                const option = new Option(menu.name, menu.id);
                slcMenus.append(option);
            });

        }
    })
}






$(document).on('show.bs.modal','#asignarMenu', function () {
   // $("#asignarMenu").html("");
//    slcMenus.val('');
//    slcSubmenu.val('');

    var triggerLink = $(e.relatedTarget);
    var id = triggerLink.data("id");
    var fieldname = triggerLink.data("fieldname");
    $(this).find(".modal-body").html("<h5>id: "+id+"</h5>");
});






$(".slcMenus").on('change', function (e) {

    const Id = e.target.value;
    
    $.ajax({
        url: `get-submenu-by-menu/${Id}`,
        type: 'get',
        dataType: 'json',
        success: function (submenu) {

            slcSubmenu.empty();

            const option = new Option('Seleccione un submenu', '');
            slcSubmenu.append(option);
            
            submenu.forEach(submenu => {
                const option = new Option(submenu.name, submenu.id);
                slcSubmenu.append(option);
            });

        }
    })
});


$(document).ready(function () {


    slcMenus.select2();
    slcSubmenu.select2();

    getServices();

    slcMenus.select2({
        dropdownParent: $('#asignarMenu'),
        // placeholder: 'Seleccione un Menu'
    });

    slcSubmenu.select2({
        dropdownParent: $('#asignarMenu'),
        placeholder: 'Seleccione un Submenu'
    });


    $.ajax({
        url: 'get-roles',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                data: employees,

                "initComplete": function(settings, json) {
                             
                    applyStyle('<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleModal">+ Nuevo rol</button>')
        

            $('.commonClass').bind('click', function(e) {

                $(".modal-body input").val("")
                $(".modal-body select").val(null).trigger('change');              

                e.preventDefault();

                
                var value = this.value.split('-');
                    inputol.val(value[1]);

                    inputrolId.val(value[0]);
                     

});

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
            url:  `update-role/${Id}`,
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


                columns: [
                    
                    { data: 'id', title: 'id' },
                    { data: 'name', title: 'nombre' },      
                    { data: 'description', title: 'descripcion' },  
                    { data: 'submenus', title: 'Submenus asignados' },        
                    { 
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion 1',
                        data: 'id',
                        render: (Id) => "<a href='update-role/" + Id + "' class='btn btn-primary btn-sm'>Activar/Desactivar</a>"
                    },
                    {
                        title: 'Accion 2',
                        data: 'id',
                        render: function(data,type,row) {
                          
                            return '<button type="button"  class="btn btn-primary commonClass" value='+data+"-"+row.name+' id="asigMenu" data-bs-toggle="modal" data-bs-target="#asignarMenu">Asignar menu</button>'; }

                        //render: (data, type, row) => '<button type="button" class="btn btn-primary asigMenu" value='+data+"-"+row.name+' id="asigMenu'+data+'" data-bs-toggle="modal" data-bs-target="#asignarMenu">Asignar menu</button>'
                    },
                 
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });

        
});








