const btnAddMaterial = $("#btn_add_material");
const materials = $("#materials");
const txtMaterialName = $("#txt_material_name");
const txtMaterialQuantity = $("#txt_material_quantity");
const tblMaterials = $("#tbl_materials");
const frmFindServiceOrder = $("#frm_find_service_order");
const btnFindServiceOrder = $("#btn_find_service_order");
const txtServiceOrderNumber = $("#txt_service_order_number");
const slcSuppliers = $("#slc_suppliers");
const btnAddToList = $("#btn_add_to_list");
const txtItem = $("#txt_item");
const txtReference = $("#txt_reference");
const txtQuantity = $("#txt_quantity");
const txtPrice = $("#txt_price");
const hiddenServiceOrderNumber = $("#frm_quote input[name='service_order_number']");

$(function () {
    loadItems();
    slcSuppliers.select2({
        placeholder: 'Seleccione un artículo',
    });
})

const loadItems = function () {
    $.ajax({
        url: '../suplidores',
        type: 'get',
        dataType: 'json',
        success: function (suppliers) {
            //Limpiamos y cargamos los artículos al localstorage
            localStorage.setItem('suppliers', JSON.stringify(suppliers));

            //Limpiamos y cargalos los artículos al select
            slcSuppliers.empty();
            slcSuppliers.append(new Option('Seleccione un suplidor', ''));
            suppliers.forEach((supplier) => {
                slcSuppliers.append(new Option(supplier.name, supplier.id));
            });
        }
    });

};

btnFindServiceOrder.on('click', function () {

    const orderNumber = txtServiceOrderNumber.val();
    $.ajax({
        url: '../ordenes-servicio/orden-servicio',
        type: 'post',
        data: {
            'order_number': orderNumber, _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (serviceOrder) {
            //Limpiar el span de mensaje de error.
            $("#spn_message").text("");
            //Llenar campos
            $("#txt_requestor").val(serviceOrder.requestor);
            $("#txt_technician").val(serviceOrder.technician);            

            //Si el campo oculto del número de servicio no existe
            //se crea el campo de la orden de servicio en el formulario
            if (hiddenServiceOrderNumber.length) {
                hiddenServiceOrderNumber.val(orderNumber);
            } else {
                $("#frm_quote").append(`
                    <input type="hidden" name="service_order_number" value="${orderNumber}"/>
                `);
            }

        },
        error: function (error) {
            const message = error.responseJSON.message;
            $("#spn_message").text(message);
            $("#frm_quote input[name='service_order_number']").remove();
        }
    });
});

btnAddToList.on('click', function () {

    const selectedOption = $("#slc_suppliers option:selected");

    const rowNumber = $("table tbody tr").length - 1;
    const newRow = `
        <tr>            
            <input type="hidden" name="quotes[${rowNumber}][supplier_id]" value="${selectedOption.val()}"/>
            <input type="hidden" name="quotes[${rowNumber}][supplier_name]" value="${selectedOption.text()}"/>
            <input type="hidden" name="quotes[${rowNumber}][item]" value="${txtItem.val()}"/>
            <input type="hidden" name="quotes[${rowNumber}][reference]" value="${txtReference.val()}"/>
            <input type="hidden" name="quotes[${rowNumber}][quantity]" value="${txtQuantity.val()}"/>
            <input type="hidden" name="quotes[${rowNumber}][price]" value="${txtPrice.val()}"/>

            <td>${selectedOption.text()}</td>
            <td>${txtItem.val()}</td>
            <td>${txtReference.val()}</td>
            <td>${txtQuantity.val()}</td>
            <td>${txtPrice.val()}</td>
            <td><button class="btn_remove btn btn-warning">Remover</td>
        </tr>
    `;

    $("table tbody").prepend(newRow);

    let totalQuantity = $("#td_total_quantity").text() === "" ? 0 : parseFloat($("#td_total_quantity").text());
    totalQuantity += parseFloat(txtQuantity.val());

    let totalPrice = $("#td_total_price").text() === "" ? 0 : parseFloat($("#td_total_price").text());
    totalPrice += parseFloat(txtPrice.val());

    $("#td_total_quantity").text(totalQuantity);
    $("#td_total_price").text(totalPrice);
});

$("#frm_quote").on('submit', function (e) {

    const hiddenServiceOrderNumberExists = $("#frm_quote input[name='service_order_number']").length;

    if (!hiddenServiceOrderNumberExists) {
        e.preventDefault();
    
        Swal.fire({
            title: 'No ha especificado un número de orden de servicio',
            text: "Aún no ha especificado una orden de servicio. ¿Desea continuar?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })        
    }
});