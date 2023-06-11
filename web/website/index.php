<?php
require_once '../functions.php/get_loc_data.php';
require_once '../functions.php/generate_chart_series.php';
require_once '../locations.php';

$locSeries = array();
foreach($locations as $loc) {
  $locSeries[$loc] = generate_chart_series($loc);
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cerjan-Fink House Temperature Data</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <body>
    <div id="chartTemp">
    </div>
    <div id="chartHum">
    </div>
  </body>

  <script type="text/javascript">
    var options = {
      series: [
        {
          <?php echo $locSeries['jenny_bedroom']['temperature']; ?>
        }
      ],
      colors: ['#ED320A'],
      chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
          type: 'x',
          enabled: true,
          autoScaleYAxis: true
        }
      },
      toolbar: {
        autoSelected: 'zoom',
      },
      xaxis: {
        type: 'datetime',
        labels: {
          datetimeUTC: false
        }
      },
      dataLabels: {
        enabled: false,
      },
      markers: {
        size: 0
      },
      title: {
        text: 'Temperature (C)',
        alignment: 'left'
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [15,25,35]
        }
      }
    };

    var chartTemp = new ApexCharts(document.querySelector("#chartTemp"), options);
    chartTemp.render();


    var optionsHum = {
      series: [{
        <?php echo $locSeries['jenny_bedroom']['humidity']; ?>
      }],
      chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
          type: 'x',
          enabled: true,
          autoScaleYAxis: true
        }
      },
      toolbar: {
        autoSelected: 'zoom',
      },
      xaxis: {
        type: 'datetime',
        labels: {
          datetimeUTC: false
        }
      },
      dataLabels: {
        enabled: false,
      },
      markers: {
        size: 0
      },
      title: {
        text: 'Humidity (%)',
        alignment: 'left'
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [50,75,100]
        }
      }
    };

    var chartHum = new ApexCharts(document.querySelector("#chartHum"), optionsHum);
    chartHum.render();





  </script>
</html>
