try {
    var googleAnalytics = document.getElementById('analyticResults').value ? JSON.parse(document.getElementById('analyticResults').value) : [];
    var browsers = [
        ['Chrome', 0],
        ['Firefox', 0],
        ['Opera', 0],
        ['Safari', 0],
        ['Internet Explorer',0],
        ['Unknown', 0],
        ['Others', 0]
    ];
    var uniqueClicks = [];
    var totalClicks = [];
    var checkDateExist = [];
    var os = [{
            "name": "Android",
            "y": 0
        },
        {
            "name": "Windows",
            "y": 0
        },
        {
            "name": "IOS",
            "y": 0
        },
        {
            "name": "Linux",
            "y": 0
        },
        {
            "name": "Others",
            "y": 0
        },
        {
            "name": "OS X",
            "y": 0
        },
        {
            "name": "Unknown",
            "y": 0
        },
        {
            "name": "Spider/Bot",
            "y": 0
        }
    ]
    var cityLables = [];
    var cityValues = [];
    for (var i = 0; i < googleAnalytics.rows.length; i++) {

        // Sep open with browsers
        for (var k = 0; k < browsers.length; k++) {
            if (browsers[k].indexOf(googleAnalytics.rows[i][2]) != -1) {
                browsers[k][1] = parseInt(browsers[k][1]) + parseInt(googleAnalytics.rows[i][6]);
                break;
            }
        }
        var year = googleAnalytics.rows[i][0].substring(0, 4);
        var month = googleAnalytics.rows[i][0].substring(4, 6) - 1;
        var day = googleAnalytics.rows[i][0].substring(6, 8);

        // Set clicks unique vs total clicks
        if (checkDateExist.indexOf(googleAnalytics.rows[i][0]) != -1) {

            for (var l = 0; l < uniqueClicks.length; l++) {
                if (uniqueClicks[l].indexOf(Date.UTC(parseInt(year), parseInt(month), parseInt(day))) != -1) {
                    totalClicks[l][1] = parseInt(totalClicks[l][1]) + parseInt(googleAnalytics.rows[i][6]);
                    uniqueClicks[l][1] = parseInt(uniqueClicks[l][1]) + parseInt(googleAnalytics.rows[i][7]);
                }
            }
        } else {
            checkDateExist.push(googleAnalytics.rows[i][0]);
            uniqueClicks.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(googleAnalytics.rows[i][7])]);
            totalClicks.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(googleAnalytics.rows[i][6])]);
        }

        // Set oprating systems
        for (var m = 0; m < os.length; m++) {
            if (os[m].name == googleAnalytics.rows[i][3]) {
                os[m].y = parseInt(os[m].y) + parseInt(googleAnalytics.rows[i][6]);
            }

        }
        // set top  clicks in cities
        if (checkDateExist.indexOf(googleAnalytics.rows[i][5] + '-' + googleAnalytics.rows[i][4]) != -1) {
            var idx = cityLables.indexOf(googleAnalytics.rows[i][5] + '-' + googleAnalytics.rows[i][4]);
            cityValues[idx] = parseInt(cityValues[idx]) + parseInt(googleAnalytics.rows[i][6]);
        } else {
            checkDateExist.push(googleAnalytics.rows[i][5] + '-' + googleAnalytics.rows[i][4]);
            cityLables.push(googleAnalytics.rows[i][5] + '-' + googleAnalytics.rows[i][4]);
            cityValues.push(googleAnalytics.rows[i][6]);
        }
    }

} catch (err) {
    console.log(err.message);
}


try {
    Highcharts.chart('canvas-1', {
        chart: {
            type: 'spline'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            }
        },
        yAxis: {
            title: {
                text: 'Clicks'
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y} Clicks'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

        // Define the data points. All series have a dummy year
        // of 1970/71 in order to be compared on the same x axis. Note
        // that in JavaScript, months start at 0 for January, 1 for February etc.
        series: [{
            name: "Unique Clicks",
            data: uniqueClicks
        }, {
            name: "Total Clicks",
            data: totalClicks
        }]
    });
} catch (err) {
    console.log(err.message);
}


try {

    var t2 = new Highcharts.chart({
        chart: {
            renderTo: 'browser-chart',
            type: 'column'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Clicks'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Total clicks <b>{point.y}</b>'
        },
        series: [{
            name: 'clicks',
            data: browsers,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#E3E4E5',
                align: 'right',
                format: '{point.y} Clicks', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

} catch (err) {
    console.log(err.message);
}


try {


    // Create the chart
    Highcharts.chart('canvas-5', {
        chart: {
            type: 'pie'
        },
        credits: {
            enabled: false
        },
        title: {
            text: null
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y} Clicks'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} Clicks<br/>'
        },

        series: [{
            name: 'browsers',
            colorByPoint: true,
            data: os
        }]

    });
} catch (err) {
    console.log(err.message);
}

// 
try {

    Highcharts.chart('canvas-6', {
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: cityLables
        },
        yAxis: {
            min: 0,
            title: {
                text: null
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Clicks',
            data: cityValues
        }]
    });
} catch (err) {
    console.log(err.message);
}