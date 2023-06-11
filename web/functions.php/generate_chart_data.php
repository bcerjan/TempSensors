<?php
/*
 * Function to generate data for passing to ApexChart object
 *
 * Takes in an array of MeasurementData and returns a nested pair of
 * arrays for temperature and humidity data with time in unix epoch time
 *
 * Need to convert from php arrays to JS arrays when decoding
 */

function generate_chart_data($data_arr) {
  require_once __DIR__ . '/MeasurementData.php';

  $temps = array();
  $hum = array();

  foreach($data_arr as $data) {
    $ts = strtotime($data->timestamp) * 1000; // the 1000 is because JS expects milliseconds instead of seconds
    $temps[] = [$ts, $data->temperature];
    $hum[] = [$ts, $data->humidity];
  }

  return ['temperature' => $temps, 'humidity' => $hum];

}
