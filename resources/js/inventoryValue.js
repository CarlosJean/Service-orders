

$(document).ready(function () {



});


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
        sa=txtArea1.document.execCommand("SaveAs",true,"Valor de Inventario.xls");
    }  
    else                 //other browser not tested on IE 11s
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}




document.getElementById ("getInventory").addEventListener ("click", getInventoryValue, false);

function getInventoryValue(){

    var fecha =  $("#colFormLabelSm").val()

    $.ajax({
        url: 'inventory_value',
        type: 'POST',
        data: {"_token": $('#token').val(),fromDate:fecha},
        dataType: 'json',
    })
        .done(function (data) {
console.log(data['total_value'])

            //$("#spinner").css('display', 'none');
            $("#total").text("")

            $("#total").text(data['total_value'])

            $('#dataTable').DataTable({

                // "initComplete": function(settings, json) {                   
                    
   
                //    },
                "bDestroy": true,
                data: data['items'],
                paging: false,
                searching: false,
                columns: [
                    { data: 'name', title: 'Articulo' },
                    { data: 'reference', title: 'Referencia' },        
                    // { data: 'Descripción', title: 'Descripción' },        
                    { data: 'quantity', title: 'Cantidad' },        
                    // { data: 'Unidad', title: 'Unidad' },        
                    // { data: 'cellphone', title: 'Celular' },   
                    { data: 'price', title: 'Precio' },       
                 
                ],
                dom:"<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });
}








