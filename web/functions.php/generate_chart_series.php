<?php
/*
 * Function to generate a Series appropriate for passing to ApexChart
 *
 * Input: location string
 *
 * Output: string appropriate for embedding in JS
 *
 */

function generate_chart_series($loc) {
  require_once __DIR__ . '/MeasurementData.php';
  require_once __DIR__ . '/generate_chart_data.php';
  require_once __DIR__ . '/get_loc_data.php';

  $data = get_loc_data($loc);
  $data = generate_chart_data($data);

  $name = str_replace('_', ' ', $loc);
  $name = ucwords($name);

  $tdata = json_encode($data['temperature']);
  $hdata = json_encode($data['humidity']);

  $temp = <<<EOD
  name: "$name",
  data: $tdata
EOD;

  $hum = <<<EOD
  name: "$name",
  data: $hdata
EOD;

  return ['temperature' => $temp, 'humidity' => $hum];
}
