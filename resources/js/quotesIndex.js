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

    $.ajax({
        type: 'post',
        url: './cotizaciones/activas',
        dataType: 'json',
    }).done(function (response) {
        quotesTable.DataTable({
            data: response.data,
            processing: true,
            columns: columnsByUserRole(response),
            dom: "<'row justify-content-end' <'col-sm-12 col-lg-5' f> <'#newQuoteButton.col-sm-12 col-lg-2 px-1 px-md-3'> >",
            destroy: true,
            language,
        });
        appendNewQuoteButton();
    });
};

const columnsByUserRole = (response) => {
    
    if (response.user_role == "maintenancemanager" || response.user_role == "maintenancesupervisor") {
        return [
            { title: 'Cotización', data: 'quote_number' },
            { title: 'Orden de servicio', data: "order_number" },
            { title: 'Solicitante orden de servicio', data: 'requestor' },
            { title: 'Fecha', data: 'date' },
            {
                title: 'Accion',
                data: 'quote_number',
                render: (quoteNumber) => "<a href='cotizaciones/" + quoteNumber + "' class='btn btn-primary'>Detalles</a>"
            },
        ];

    } else if (response.user_role == "warehouseman") {
        return [
            { title: 'Cotización', data: 'quote_number' },
            { title: 'Orden de servicio', data: "order_number" },
            { title: 'Solicitante orden de servicio', data: 'requestor' },
            { title: 'Fecha', data: 'date' },
            {
                title: 'Accion',
                data: 'quote_number',
                render: (quoteNumber) => "<a href='cotizaciones/" + quoteNumber + "' class='btn btn-primary'>Detalles</a>"
            },
            {
                title: 'Accion 2',
                data: 'quote_number',
                render: (quoteNumber) => "<a href='ordenes-compra/crear/" + quoteNumber + "' class='btn btn-primary'>Orden de compra</a>"
            },
        ];
    }
}