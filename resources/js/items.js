import applyStyle from '../js/azia.js';
import * as language from './datatables.spanish.json';
const slc = $(".slc");


const getCategories = function () {
    $.ajax({
        url: "get-categories",
        type: 'get',
        dataType: 'json',
        success: function (data) {

            slc.empty();

            slc.append(new Option('Selecione la categoria', null))


            data.forEach(data => {
                const option = new Option(data.name, data.id);
                if(data.active=='1')
                slc.append(option);
            });

        }
    })
}

$(document).ready(function () {

    slc.select2();
    slc.select2({
        dropdownParent: $('#exampleModal')
    });

    getCategories();
    $("input[id*='txtQty']").keydown(function (event) {


        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
            (event.keyCode >= 96 && event.keyCode <= 105) ||
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

        } else {
            event.preventDefault();
        }

        if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault();
        //if a decimal has been added, disable the "."-button

    });

    $(".btn").click(function () {
        $("#myModal").modal('show');
    });

    $(document).on('click', '.btnActivateDiactivate', function (e) {
        e.preventDefault();
        var Id = this.href.substring(this.href.lastIndexOf('/') + 1);

        Swal.fire({
            title: '¿Está seguro que desea proceder con la acción?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `update-items/${Id}`,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        if (data.type == 'success')
                            Swal.fire({
                                title: data.message,
                                icon: data.type

                            }).then((result) => { location.reload(); });
                        else
                            Swal.fire({
                                title: 'Cambios no aplicados',
                                text: data.message,
                                icon: 'error'
                            }).then((result) => { location.reload(); });
                    }
                })
            }
        })

    });

    $.ajax({
        url: 'getItemsAll',
        type: 'get',
        dataType: 'json',
    })
        .done(function (employees) {

            $("#spinner").css('display', 'none');

            $('#dataTable').DataTable({

                "initComplete": function (settings, json) {
                    applyStyle('<button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"> + Nuevo articulo</button>')
                },

                data: employees,
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'name', title: 'Nombre' },        
                    { data: 'description', title: 'Descripcion' },        
                    { data: 'quantity', title: 'Cantidad' },        
                    { data: 'measurement_unit', title: 'Medida' },        
                    { data: 'price', title: 'Precio' },        
                    { data: 'reference', title: 'Referencia' },   
                    { data: 'category', title: 'Categoria' },   

                    {
                        title: 'Estado',
                        data: 'active',
                        render: function (data, type, row) { if (data == 0) return "Inactiva"; else return "Activa"; }
                    },
                    {
                        title: 'Accion',
                        data: 'id',
                        render: (Id) => "<a href='update-items/" + Id + "' class='btn btn-primary btn-sm btnActivateDiactivate'>Activar/Desactivar</a>"
                    },
                ],
                dom: "<'row justify-content-end'<'col-3'f><'col-12't><'col-12'<'row justify-content-center'<'col-3'p>>>>",
                language,
                responsive:true,
            });
        });


});









