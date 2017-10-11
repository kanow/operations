var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["2015", "2016", "2017"],
        datasets: [{
            label: "Brandeinsätze",
            // backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(25, 99, 132)',
            data: [200, 180, 145],
        },
        {
            label: "Gasalarm",
            // backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [160, 330, 425],
        }]
    },

    // Configuration options go here
    options: {
        events: ['click']
    }
});