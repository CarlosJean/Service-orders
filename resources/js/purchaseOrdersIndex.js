import * as language from './datatables.spanish.json';

const purchaseOrdersTable = $("#purchaseOrdersTable");

$(function () {
    activeQuotes();
});

const appendNewQuoteButton = function () {
    $("#newQuoteButton").append(`
        <a href="ordenes-compra/crear" class="btn btn-primary mt-2 mt-md-0 w-100">
            <i class="typcn icon typcn-plus"></i>
            Nueva orden de compra
        </a>
    `);
};

const activeQuotes = function () {
    purchaseOrdersTable.DataTable({
        ajax: {
            url: './ordenes-compra',
            type: 'post',
            dataType: 'json',
            dataSrc: function (purchaseOrders) {
                appendNewQuoteButton();
                return purchaseOrders;
            },
        },
        processing: true,
        columns: [
            { title: 'Fecha', data: "date" },
            { title: 'Creador', data: "created_by" },
            { title: 'Número', data: 'number' },
            { title: 'Total', data: 'total' },
            {
                title: 'Accion',
                data: 'number',
                render: (purchaseOrderNumber) => "<a href='ordenes-compra/" + purchaseOrderNumber + "' class='btn btn-primary'>Detalles</a>"
            },
        ],
        dom: "<'row justify-content-end' <'col-sm-12 col-lg-5' f> <'#newQuoteButton.col-sm-12 col-lg-3 px-1 px-md-3'>  <'col-12' t> <'row justify-content-center' <'col-sm-12 col-lg-4' p>>>",
        destroy: true,
        language,
    });
};