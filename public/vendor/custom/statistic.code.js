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

const months = [
    "Ene", "Feb", "Mar", "Abr", "May", "Jun",
    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
];

const frequencySet = {
    ANUAL: 'anual',
    MENSUAL: 'mensual',
    SENAMAL: 'semanal',
    DIARIO: 'diario'
}


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
            //label: 'Suministro',
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

    if (set_data === null) return chartsInit().verticalBar;

    const {data, frequency, from} = set_data;

    const serviceColors = {};
    services.forEach(service => {
        serviceColors[service.service] = service.backgroundColor;
    });

    const chartData = {
        labels: getPeriod(frequency, data, from),
        datasets: services.map(service => {
            return {
                label: capitalizeFirstLetter(service.service),
                data: data.map(entry => {
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
    if (string.length === 0) return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getPeriod(frequency, data, date) {
    if (!Array.isArray(data)) {
        throw new Error("Data must be an array");
    }
    switch (frequency) {
        case frequencySet.MENSUAL:
            return data.map(entry => {
                return convertMonthly(entry.period)
            });
            break;
        case frequencySet.SENAMAL:
            return data.map(entry => {
                return convertWeekly(entry.period, date);
            });
        default:
            return data.map(entry => entry.period);
    }
}


function convertMonthly(data) {
    const [year, month] = data.split("-");
    const output = months[parseInt(month, 10) - 1];
    return `${output} ${year}`;
}

function convertWeekly(week, date) {
    console.log(week)
    const [year, month, day] = date.split("-");
    const firstDayOfYear = new Date(year, 0, 1);
    console.log(firstDayOfYear);
    const daysToMonday = (firstDayOfYear.getDay() === 0 ? 6 : firstDayOfYear.getDay() - 1);

    const firstDayOfWeek = new Date(firstDayOfYear);

    firstDayOfWeek.setDate(firstDayOfYear.getDate() + (week - 1) * 7 - daysToMonday);

    const options = {month: 'short', day: '2-digit', year: 'numeric'};
    return firstDayOfWeek.toLocaleDateString('es-ES', options);

}


function chartsInit() {
    return {
        doughnut: {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    //label: 'Suministro',
                    data: [],
                    backgroundColor: [],
                    hoverOffset: 4
                }]
            },
        },
        horizontalBar: {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'RANKING',
                    backgroundColor: users.backgroundColor,
                    data: [],
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true
            }
        },
        verticalBar: {
            type: 'bar',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    }
                }
            }
        }
    }
}
