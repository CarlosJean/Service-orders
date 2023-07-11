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
            url: './cotizaciones/activas',
            type: 'post',
            dataType: 'json',
            dataSrc: function (activeQuotes) {
                appendNewQuoteButton();
                return activeQuotes;
            },
        },
        processing: true,
        columns: [
            { title: 'Cotización', data: "quote_number" },
            { title: 'Orden de servicio', data: "order_number" },
            { title: 'Solicitante orden de servicio', data: 'requestor' },
            { title: 'Fecha', data: 'date' },
            {
                title: 'Accion',
                data: 'quote_number',
                render: (quoteNumber) => "<a href='cotizaciones/" + quoteNumber + "' class='btn btn-primary'>Detalles</a>"
            },
        ],
        dom: "<'row justify-content-end' <'col-sm-12 col-lg-5' f> <'#newQuoteButton.col-sm-12 col-lg-2 px-1 px-md-3'> >",
        destroy: true,
        language,
    });
};