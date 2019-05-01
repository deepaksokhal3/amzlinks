$(function(){
  'use strict';

  try{
  var options = {
    lines: 12, // The number of lines to draw
    angle: 0.5, // The length of each line
    lineWidth: 0.08, // The line thickness
    pointer: {
      length: 0.9, // The radius of the inner circle
      strokeWidth: 0.035, // The rotation offset
      color: '#000000' // Fill color
    },
    limitMax: 'false',   // If true, the pointer will not go past the end of the gauge
    colorStart: $.brandInfo,   // Colors
    colorStop: $.brandInfo,    // just experiment with them
    strokeColor: '#d1d4d7',   // to see which ones work best for you
    generateGradient: true
  };
  var target = document.getElementsByClassName('composition-grp-sec');
  for(var i=0; target.length; i++ ){
      var target1 = target[i].childNodes[1].childNodes[1]; // your canvas element
      var gauge1 = new Donut(target1).setOptions(options); // create sexy gauge!
      var  comp = parseInt(target[i].getAttribute('rel')) ;
      gauge1.maxValue = 100; // set max gauge value
      gauge1.animationSpeed = 32; // set animation speed (32 is default value)
      gauge1.set(comp); 
  }
}catch(err){
  console.log(err.message);
}
 try{
var  googleAnalytics = document.getElementById('analyticResults').value? JSON.parse(document.getElementById('analyticResults').value):[];
var uniqueClicks = [];
var totalClicks = [];
var checkDateExist = [];


for(var i=0; i< googleAnalytics.rows.length; i++){ 
    var year        = googleAnalytics.rows[i][0].substring(0,4);
    var month       = googleAnalytics.rows[i][0].substring(4,6)-1;
    var day         = googleAnalytics.rows[i][0].substring(6,8);

    // Set clicks unique vs total clicks
    if(checkDateExist.indexOf(googleAnalytics.rows[i][0]) != -1){
      for(var l=0; l<uniqueClicks.length; l++ ){
         if(uniqueClicks[l].indexOf(Date.UTC(parseInt(year), parseInt(month), parseInt(day))) != -1){
              totalClicks[l][1] = parseInt(totalClicks[l][1]) + parseInt(googleAnalytics.rows[i][2]) ;
              uniqueClicks[l][1] = parseInt(uniqueClicks[l][1]) + parseInt(googleAnalytics.rows[i][3]);
         }
      }
    }else{
      checkDateExist.push(googleAnalytics.rows[i][0]);
      uniqueClicks.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(googleAnalytics.rows[i][3])]);
      totalClicks.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(googleAnalytics.rows[i][2])]);
    }
  }

Highcharts.chart('total-vs-unique-clicks', {
    chart: {
        type: 'spline'
    },
    title:{
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
    exporting: { enabled: false },
    plotOptions: {
        spline: {
            marker: {
                enabled: true
            }
        }
    },
legend: {
    enabled: true,
    verticalAlign: 'top',
    borderWidth: 0,
    itemMarginTop: 0,
    itemMarginBottom: 0
},
    colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

    // Define the data points. All series have a dummy year
    // of 1970/71 in order to be compared on the same x axis. Note
    // that in JavaScript, months start at 0 for January, 1 for February etc.
    series: [{
        name: "Unique Clicks",
        data:uniqueClicks
    }, {
        name: "Total Clicks",
        data: totalClicks
    }]
});
 }catch(err){
  console.log(err.message);
 }


try{
var  dshAnalytics = document.getElementById('dahResults').value? JSON.parse(document.getElementById('dahResults').value):[];
var totalUser=[];
var newUser=[];
for(var i=0; i< dshAnalytics.rows.length; i++){ 
    var year        = dshAnalytics.rows[i][0].substring(0,4);
    var month       = dshAnalytics.rows[i][0].substring(4,6)-1;
    var day         = dshAnalytics.rows[i][0].substring(6,8);
     totalUser.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(dshAnalytics.rows[i][1])]);
      newUser.push([Date.UTC(parseInt(year), parseInt(month), parseInt(day)), parseInt(dshAnalytics.rows[i][2])]);
  }

   Highcharts.chart('user-vs-newusers', {
    chart: {
        type: 'spline'
    },
    title:{
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
            text: 'Users'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y} Users'
    },
    exporting: { enabled: false },
    plotOptions: {
        spline: {
            marker: {
                enabled: true
            }
        }
    },
legend: {
    enabled: true,
    verticalAlign: 'top',
    borderWidth: 0,
    itemMarginTop: 0,
    itemMarginBottom: 0
},
    colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

    // Define the data points. All series have a dummy year
    // of 1970/71 in order to be compared on the same x axis. Note
    // that in JavaScript, months start at 0 for January, 1 for February etc.
    series: [{
        name: "New Users",
        data:newUser
    }, {
        name: "Users",
        data: totalUser
    }]
});
 }catch(err){
  console.log(err.message);
 }



});
