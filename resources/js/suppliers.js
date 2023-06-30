import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json' ;

document.getElementById ("tipoidentificacion").addEventListener ("change", setIdent
, false);

function setIdent(){
   var selectedIdent = $('#tipoidentificacion').val()

   $('#inIdent').val('')

    if(selectedIdent=="RNC")
    {
        $("#inIdent").prop('readonly', false);
        $('#ident').text('RNC (formato: x-xx-xxxxx-x)')
        $("#inIdent").prop('pattern', "^\\d{1}-\\d{2}-\\d{5}-\\d{1}$");
        $("#inIdent").prop('maxlength', 12);
    }
else if(selectedIdent=="Cedula"){
    $("#inIdent").prop('readonly', false);
    $('#ident').text('Cedula (formato: xxx-xxxxxxx-x)')
    $("#inIdent").prop('pattern', "^\\d{3}-\\d{7}-\\d{1}$");
    $("#inIdent").prop('maxlength', 13);

    }
else {
    $("#inIdent").prop('readonly', true);

    $('#ident').text('RNC o Cedula')
}

}



$(document).ready(function () {


    $(".btn").click(function(){
        $("#myModal").modal('show');
    });

      
    $.ajax({
        url: 'get-suppliers',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                "initComplete": function(settings, json) {                   
                    
                       applyStyle('<button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"> + Nuevo suplidor</button>')
   
                   },

                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'name', title: 'Nombre' },        
                    { data: 'address', title: 'Direccion' },        
                    // { data: 'city', title: 'Ciudad' },        
                    { data: 'email', title: 'Correo'},        
                    { data: 'cellphone', title: 'Celular' },   
                    { data: 'ident', title: 'RNC/Cedula' },        
                    { 
                        title:'Estado' ,
                        data: 'active', 
                        render: function(data,type,row) { if(data==0) return "Inactiva"; else return "Activa"; }
                    },  
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-suppliers/" + Id + "' class='btn btn-primary btn-sm'>Activar/Desactivar</a>"
                    },
                ],
                columnDefs: [{width: 5, targets: 3}],
                fixedColumns: true,
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language
            });
        });


});









