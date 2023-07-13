import * as language from './datatables.spanish.json';

const quotesTable = $("#quotesTable");

$(function () {
    activeQuotes();
});

const appendNewQuoteButton = function () {
    $("#newQuoteButton").append(`
        <a href="cotizaciones/crear" class="btn btn-primary mt-2 mt-md-0 w-100">
            <i class="typcn icon typcn-plus"></i>
            Nueva cotización
        </a>
    `);
};

const activeQuotes = function () {
    quotesTable.DataTable({
        ajax: {
            url: './solicitud-materiales/pendientes',
            type: 'post',
            dataType: 'json',
            dataSrc: function (activeQuotes) {
                appendNewQuoteButton();
                return activeQuotes;
            },
        },
        processing: true,
        columns: [
            { title: 'Orden de servicio', data: "service_order_number" },
            { title: 'Fecha solicitud', data: "material_request_date" },
            { title: 'Solicitador', data: "requestor" },
            {
                title: 'Acción',
                data: 'service_order_number',
                render: (serviceOrderNumber) => "<a href='articulos/despachar/" + serviceOrderNumber + "' class='btn btn-primary'>Despachar materiales</a>"
            },
        ],
        dom: "<'row justify-content-end' <'col-sm-12 col-lg-5' f> <'#newQuoteButton.col-sm-12 col-lg-2 px-1 px-md-3'> >",
        destroy: true,
        language,
        cache:false,
    });
};