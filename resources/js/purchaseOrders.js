import * as language from './datatables.spanish.json' ;

var table = {};

$("#frmGetQuoteByNumber").on('submit', function (e) {
    e.preventDefault();

    const quoteNumber = $("#frmGetQuoteByNumber input[name='quote_number']").val();

    $.ajax({
        url: `../cotizaciones/${quoteNumber}`,
        dataType: 'json',
        success: function (quote) {

            console.log(quote);
            $("#frmPurchaseOrder input[name='quote_number']").val(quote[0].number);

            if (quote == null) {
                $("#spnQuoteNotFound").text('No existe una cotización con este número.')
                $("#spnQuoteNotFound").removeClass('d-none');
            } else {
                table = $('#tblQuotes').DataTable({
                    columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                    {
                        target: 1,
                        visible: false
                    },
                    {
                        target: 2,
                        visible: false
                    }],
                    select: {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    order: [[1, 'asc']],
                    data: quote,
                    columns: [
                        { title: '', data: null, defaultContent: "" },
                        { title: '', data: 'supplier_id' },
                        { title: '', data: 'item_id' },
                        { title: 'Suplidor', data: 'supplier' },
                        { title: 'Artículo', data: 'item' },
                        { title: 'Referencia', data: 'reference' },
                        { title: 'Cantidad', data: 'quantity' },
                        { title: 'Precio', data: 'price' },
                    ],
                    dom:'ft',
                    language,
                });
                $("#spnQuoteNotFound").addClass('d-none');
                $("#dvItems").removeClass('d-none');
            }
        },
        error: function (error) {
            $("#spnQuoteNotFound").text('No existe una cotización con este número.')
            $("#spnQuoteNotFound").removeClass('d-none');
        }
    });

});


$("#btnSave").on('click', function () {
    const rows = table.rows('.selected').data();

    for (let index = 0; index < rows.length; index++) {
        const row = rows[index];
        $("#frmPurchaseOrder").append(`
        <input type="hidden" name="items[${index}][supplier_id]" value="${row.supplier_id}" />
        <input type="hidden" name="items[${index}][item_id]" value="${row.item_id}" />
        <input type="hidden" name="items[${index}][item]" value="${row.item}" />
        <input type="hidden" name="items[${index}][reference]" value="${row.reference}" />
        <input type="hidden" name="items[${index}][quantity]" value="${row.quantity}" />
        <input type="hidden" name="items[${index}][price]" value="${row.price}" />
        `);

    }
})