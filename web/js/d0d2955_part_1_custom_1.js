$(function () { 
    $( '#container' ).highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Occurrences of the word... Gareth'
        },
        xAxis: {
            categories: ['2010', '2011', '2012', '2013', '2014', '2015']
        },
        yAxis: {
            title: {
                text: 'Number of appearances'
            }
        },
        series: [{
            name: 'Gareth',
            data: [50, 15, 65, 10, 20, 5]
        }]
    });
});