const services = [
    {
        service: 'gas',
        backgroundColor: 'rgb(153,204,50)'
    },
    {
        service: 'agua',
        backgroundColor: 'rgb(30,143,253)'
    },
    {
        service: 'luz',
        backgroundColor: 'rgb(252,214,0)'
    }
]

const users = {backgroundColor: 'rgb(30,143,253)'};


function doughnutfnt(set_data) {
    const result = set_data.reduce((acc, target) => {
        const {service, count} = target;

        const foundService = services.find(item => item.service === service);
        if (foundService) {
            acc.labels.push(capitalizeFirstLetter(foundService.service));
            acc.data.push(count);
            acc.backgroundColor.push(foundService.backgroundColor);
        } else {
            console.warn(`Service "${service}" not found in services.`);
        }
        return acc;
    }, {labels: [], data: [], backgroundColor: []});

    return {
        labels: result.labels,
        datasets: [{
            label: 'Suministro',
            data: result.data,
            backgroundColor: result.backgroundColor,
            hoverOffset: 4
        }]
    }
}

function horizontalBarfnt(set_data) {
    const result = set_data.reduce((acc, target) => {
        const {user, count} = target;
        acc.labels.push(capitalizeFirstLetter(user));
        acc.data.push(count);
        return acc;
    }, {labels: [], data: []});
    console.log(set_data)
    return {
        labels: result.labels,
        datasets: [{
            label: 'RANKING',
            data: result.data,
            backgroundColor: users.backgroundColor
        }]
    }
}

function verticalBarfnt(set_data) {
    /*
    const services = new Set();
    set_data.forEach(entry => {
        entry.items.forEach(item => {
            services.add(item.service);
        });
    });

    const serviceArray = Array.from(services);


    const chartData = {
        labels: set_data.map(entry => entry.period),
        datasets: serviceArray.map(service => {
            return {
                label: service,
                data: set_data.map(entry => {
                    const item = entry.items.find(i => i.service === service);
                    return item ? item.count : 0;
                }),
                //backgroundColor: getRandomColor(), // Function to generate random colors
            };
        }),
    };
    return chartData;
     */

    const serviceColors = {};
    services.forEach(service => {
        serviceColors[service.service] = service.backgroundColor;
    });

    const chartData = {
        labels: set_data.map(entry => entry.period),
        datasets: services.map(service => {
            return {
                label: capitalizeFirstLetter(service.service),
                data: set_data.map(entry => {
                    const item = entry.items.find(i => i.service === service.service);
                    return item ? item.count : 0;
                }),
                backgroundColor: service.backgroundColor,
            };
        }),
    };
    return chartData;
}

function capitalizeFirstLetter(string) {
    if (string.length === 0) return ''; // Handle empty string
    return string.charAt(0).toUpperCase() + string.slice(1);
}
