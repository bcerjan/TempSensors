<?php
require_once '../../functions.php/insert_data.php';
require_once '../../functions.php/MeasurementData.php';
require_once '../../secret_key.php';

if (strcmp($_POST['secret'], $secret) !== 0) {
  exit('Bad Secret Provided...');
}


$data = new MeasurementData(
	$_POST['location'],
	$_POST['temperature'],
	$_POST['humidity']
	);

insert_data($data);

