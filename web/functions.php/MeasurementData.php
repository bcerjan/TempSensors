<?php
/*
 * Class to store location, timestamp, temperature, and humidity data.
 *
 */

class MeasurementData {
  public $temperature;
  public $humidity;
  public $location;
  public $timestamp;

  function __construct($location, $temperature, $humidity) {
    $this->location = $location;
    $this->temperature = $temperature;
    $this->humidity = $humidity;
    $this->timestamp = date('Y-m-d H:i:s');
  }

}
