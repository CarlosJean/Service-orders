
const htmlSelect = $("#tipoReporte");

$(document).ready(function () {

 

    fillSelectReport();

});



function fillSelectReport () {
    $.ajax({
        url: "fillSelectReport",
        type: 'get',
        dataType: 'json',
        success: function (data) {

            data.forEach(data => {
                const option = new Option(data.name, data.id);
                htmlSelect.append(option);
            });

        }
    })
}




document.getElementById ("getReport").addEventListener ("click", getReport, false);

function getReport(){

    var fechaIn =  $("#desde").val()
    var fechaFin =  $("#hasta").val()
    var tipoReporte =  $("#tipoReporte").val()

    $.ajax({
        url: 'get-report',
        type: 'POST',
        data: {"_token": $('#token').val(),fromDate:fechaIn,toDate: fechaFin,selectedReport: tipoReporte},
        dataType: 'json',
    })
        .done(function (data) {

            $("#spinner").css('display', 'none');
   


            if ( $.fn.DataTable.isDataTable('#dataTable') ) {
                $('#dataTable').DataTable().clear().destroy();
                $('#dataTable').empty();
              }

              if (tipoReporte == "Reporte de compras") {


                $('#dataTable').DataTable({
    
                    data: data,
                    
                    paging: false,
                    searching: false,
                    retrieve: true,
                    colReorder: true,
    
    
                    columns: [
    
                        { data: 'id', title: 'Id orden compra' },
                        { data: 'created_at', title: 'Fecha' },
    
                        { data: 'name', title: 'Nombre' },     
                        { data: 'quantity', title: 'Cantidad' },   
                        { data: 'price', title: 'Precio' }    
                       
    
    
                    ],
                    dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                    responsive:true,
                    // language:{
                    //     url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                    // }
                });
    
            }
              
            if (tipoReporte == "Reporte servicios") {


            $('#dataTable').DataTable({

                data: data,
                
                paging: false,
                searching: false,
                retrieve: true,
                colReorder: true,


                columns: [

                    { data: 'number', title: 'numero orden servicio' },
                    { data: 'requestor', title: 'Requerida por' },

                    { data: 'assignation_date', title: 'fecha asignacion' },     
                    { data: 'assigned_by', title: 'asignado por' },   
                    { data: 'technician', title: 'tecnico asignado' },     
                    // { data: 'Descripción', title: 'Descripción' },        
                    { data: 'issue', title: 'problema' },        
                    // { data: 'Unidad', title: 'Unidad' },        
                    // { data: 'cellphone', title: 'Celular' },   
                    { data: 'start_date', title: 'fecha de inicio' },       
                    { data: 'end_date', title: 'fecha fin' },  
                    { data: 'status', title: 'estado' },       


                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                responsive:true,
                // language:{
                //     url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                // }
            });

        }

         if (tipoReporte == "Reporte de usuarios registrados") {

                $('#dataTable').DataTable({
      
                    data: data,
                    paging: false,
                    searching: false,
                    retrieve: true,
                    colReorder: true,

                    columns: [
    
                        { data: 'id', title: 'Id' },     
                        { data: 'created_at', title: 'Fecha registro' },
                        { data: 'name', title: 'Mombre' },     
                        // { data: 'Descripción', title: 'Descripción' },        
                         { data: 'email', title: 'Correo' },        
                        // { data: 'Unidad', title: 'Unidad' },        
                        // { data: 'cellphone', title: 'Celular' },   
                        //{ data: 'price', title: 'Precio' },       
                        //{ data: 'total_price', title: 'Precio total' },       
    
                    ],
                    dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                    responsive:true,
                    // language:{
                    //     url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                    // }
                });

            }

     

            if (tipoReporte == "Reporte costo por servicios") {

                $('#dataTable').DataTable({
      
                    data: data,
                    paging: false,
                    searching: false,
                    retrieve: true,
                    colReorder: true,

                    columns: [
    
                        { data: 'number', title: 'Numero orden servicio' },
                        { data: 'cantidad_articulos', title: 'Total articulos' },
                        { data: 'total_cost', title: 'Costo total' },
                       // { data: 'name', title: 'Mombre' },     
                        // { data: 'Descripción', title: 'Descripción' },        
                        // { data: 'email', title: 'Correo' },        
                        // { data: 'Unidad', title: 'Unidad' },        
                        // { data: 'cellphone', title: 'Celular' },   
                        //{ data: 'price', title: 'Precio' },       
                        //{ data: 'total_price', title: 'Precio total' },       
    
                    ],
                    dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                    responsive:true,
                    // language:{
                    //     url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                    // }
                });

            }

        }); // fin ajax
}




document.getElementById ("export").addEventListener ("click", fnExcelReport, false);


function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    var tab = document.getElementById('dataTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Report.xls");
    }  
    else                 //other browser not tested on IE 11s
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}









