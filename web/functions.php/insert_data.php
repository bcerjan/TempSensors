<?php
/**
 *    Copyright (c) 2023 Ben Cerjan
 *
 *    This file is part of HomeTemp.
 *
 *    HomeTemp is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Affero General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    HomeTemp is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with HomeTemp.  If not, see <https://www.gnu.org/licenses/>.
**/

/**
 * Function for insertion of temperature and humidity data
 *
 * Example usage:
 * require_once '../insert_data.php';
 *
 * insert_data($data);
 *
 *
 *
 * @author Ben Cerjan
 * @param MeasurementData $data : MeasurementData object to be inserted
 *
 * returns TRUE if insert was successful

**/

function insert_data($data) {
	// Require table variables:
	require __DIR__ . '/table_variables.php';

	// Include database connection
	require_once __DIR__ . '/db_connect.php';

	// Class containing our data
	require_once __DIR__ . '/MeasurementData.php';

	// Connect to db
	$db = db_connect();

	try {
		$sql = "INSERT INTO $dataTable (location, temperature, humidity)
                        VALUES (:loc, :temp, :hum)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':loc', $data->location);
		$stmt->bindValue(':temp', $data->temperature);
		$stmt->bindValue(':hum', $data->humidity);
		$success = $stmt->execute();
	} catch(PDOException $e) {
		die('ERROR: ' . $e->getMessage() . "\n");
	}


	return $success;
}
