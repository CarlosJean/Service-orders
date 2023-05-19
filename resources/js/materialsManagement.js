const slcItems = $("#slc_items");
const btnAddItem = $("#btn_add_item");

const items = [
    { name: 'Tape', current_quantity: 10 },
    { name: 'Destornillador plano', current_quantity: 5 },
    { name: 'Destornillador estrella', current_quantity: 5 },
]

$(function () {
    loadItems();
    slcItems.select2({
        placeholder: 'Seleccione un artículo',
        dropdownParent: $('#materialsManagement'),
    });
})

const loadItems = function () {
    items.forEach((item, index) => {
        slcItems.append(new Option(item.name, index));
    });
};

slcItems.on('change', function (e) {
    const index = $("#slc_items option:selected").val();
    const item = items[index];

    $("#td_current_quantity").text(item.current_quantity);
});

btnAddItem.on('click', function(){

    const addedItems = JSON.parse(localStorage.getItem('items'));
    addedItems.push({});

    localStorage.setItem('items');
});