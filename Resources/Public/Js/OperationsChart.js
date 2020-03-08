function generateLabelsFromTable(chartId)
{
    var labels = [];
    var rows = $("." + chartId + ".dataset .chart-label");
    rows.each(function(){
        labels.push($(this).text());
    });
    return labels;
}
function generateDataSetsFromTable(chartId)
{
    var data;
    var label;
    var datasets = [];
    var rows = $("." + chartId + ".dataset .data-row");
    rows.each(function(index){
        var cols = $(this).find(".data-row-data");
        var label = $(this).find(".data-row-label").text();
        var data = [];
        cols.each(function(){
            // we dont need first columns of the row
                data.push($(this).text());
        });
        var dataset =
            {
                label: label,
                backgroundColor : $(this).find(".data-row-label").data('color'),
                data : data,
                stack: 'group1'
            }
        datasets.push(dataset);
    });
    return datasets;
}

var charts = document.getElementsByClassName("operations-chart");
Object.keys(charts).forEach(function(key) {
    chartId = charts[key].id;

    var ctx = document.getElementById(chartId).getContext('2d');
    var myChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        data: {
            labels : generateLabelsFromTable(chartId),
            datasets : generateDataSetsFromTable(chartId)
        },
        // Configuration options go here
        options: {
            events: ['mousemove'],
            legend: {
                position: 'bottom',
                labels: {
                }
            },
            tooltips: {
                backgroundColor:'rgba(255,0,0,0.8)'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        // suggestedMax: 20,
                    }
                }]
            }
        }
    });
});
