function generateLabelsFromTable()
{
    var labels = [];
    var rows = $(".dataset .label");
    rows.each(function(){
        labels.push($(this).text());
    });
    return labels;
}
function generateDataSetsFromTable()
{
    var data;
    var label;
    var datasets = [];
    var rows = $(".dataset .data-row");
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
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    data: {
        labels : generateLabelsFromTable(),
        datasets : generateDataSetsFromTable()
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
