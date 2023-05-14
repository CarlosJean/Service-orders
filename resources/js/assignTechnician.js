const slcServices = $(".slcServices");
const slcTechnicians = $(".slcTechnicians");

$(function () {
    slcServices.select2();
    slcTechnicians.select2();
    getServices();
});

const getServices = function () {
    $.ajax({
        url: "../../ordenes-servicio/get-services",
        type: 'get',
        dataType: 'json',
        success: function (services) {

            services.forEach(service => {
                const option = new Option(service.name, service.id);
                slcServices.append(option);
            });

        }
    })
}

$(".slcServices").on('change', function (e) {

    const serviceId = e.target.value;
    $.ajax({
        url: `../../ordenes-servicio/get-employees-by-service/${serviceId}`,
        type: 'get',
        dataType: 'json',
        success: function (employees) {

            slcTechnicians.empty();

            const option = new Option('Seleccione un técnico', '');
            slcTechnicians.append(option);
            employees.forEach(employee => {
                const option = new Option(employee.name, employee.id);
                slcTechnicians.append(option);
            });

        }
    })
});
