const services = [
    {
        service: 'gas',
        backgroundColor: 'rgb(154,255,99)'
    },
    {
        service: 'agua',
        backgroundColor: 'rgb(17,136,255)'
    },
    {
        service: 'luz',
        backgroundColor: 'rgb(255, 205, 86)'
    }
]


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
        acc.labels.push(user);
        acc.data.push(count);
        return acc;
    }, {labels: [], data: []});
    console.log(set_data)
    return {
        labels: result.labels,
        datasets: [{
            label: 'RANKING',
            data: result.data,
        }]
    }
}


function capitalizeFirstLetter(string) {
    if (string.length === 0) return ''; // Handle empty string
    return string.charAt(0).toUpperCase() + string.slice(1);
}
