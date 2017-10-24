var ctx = document.getElementById("myChart").getContext('2d');

var colors = [];
colors.push(
    {
        fillColor : "rgba(95,0,0,0.5)",
        strokeColor : "rgba(95,137,250,0.9)",
        highlightFill: "rgba(95,137,250,0.75)",
        highlightStroke: "rgba(95,137,250,1)"
    });
colors.push(
    {
        fillColor : "rgba(245,0,0,0.5)",
        strokeColor : "rgba(245,75,75,0.8)",
        highlightFill : "rgba(245,75,75,0.75)",
        highlightStroke : "rgba(245,75,75,1)"
    });
colors.push(
    {
        fillColor : "rgba(98,0,0,0.5)",
        strokeColor : "rgba(98,223,114,0.8)",
        highlightFill : "rgba(98,223,114,0.75)",
        highlightStroke : "rgba(98,223,114,1)",
    });
console.log(colors[1%3]);
console.log(colors[2%3]);
function generateLabelsFromTable()
{
    var labels = [];

    var rows = $(".dataset .label");
    rows.each(function(index){
        var cols = $(this).find("th");
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
        cols.each(function(innerIndex){
            // we dont need first columns of the row
                data.push($(this).text());
        });

        var dataset =
            {
                label: label,
                backgroundColor : colors[index%3].fillColor,
                borderColor : colors[index%3].strokeColor,
                // highlightFill: colors[index%3].highlightFill,
                // highlightStroke: colors[index%3].highlightStroke,
                data : data
            }

        datasets.push(dataset);
    });
    return datasets;
}

var myChart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    data: {
        labels : generateLabelsFromTable(),
        datasets : generateDataSetsFromTable()
    },

    // Configuration options go here
    options: {
        events: ['click']
    }
});