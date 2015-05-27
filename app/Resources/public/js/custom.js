$(function () {

    var date  = [];
    var count = [];

    // @todo what if data gets out of sync?
    $.each( data, function( key, value ) {
        date.push( value.year );
        count.push( value.count );
    });

    $( '#container' ).highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Occurrences of the word... Gareth'
        },
        xAxis: {
            categories: date
        },
        yAxis: {
            title: {
                text: 'Number of appearances'
            }
        },
        series: [{
            name: data[0].firstName,
            data: count
        }]
    });
});