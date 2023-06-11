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
 * Function to get a list of data for a specific location in the database
 *
 * Example usage:
 * <code>
 * require_once './functions.php/get_loc_data.php'
 * <code>
 *
 * Use of function:
 * $data = get_loc_data($loc);
 *
 * On success returns an array of MeausurementData for disply
 *
 * @param string $loc : location to pull data for
 *
**/

function get_loc_data($loc) {
        // Require table variables:
        require __DIR__ . '/table_variables.php';

        // Connect to database
        require_once __DIR__ . '/db_connect.php';
        $db = db_connect();

	// Get preferences:
        require_once __DIR__ . '/MeasurementData.php';


	$sql = "SELECT * from $dataTable WHERE location = :loc
	        ORDER BY datetime";

	$stmt = $db->prepare($sql);
	$stmt->bindValue(':loc',strtolower($loc));
	$stmt->execute();

        // Get names from specified table
	$results = $stmt->fetchAll();

	$data = array();

	foreach($results as $val) {
	  $temp = new MeasurementData($val['location'],
			$val['temperature'], $val['humidity']);
	  $temp->timestamp = $val['datetime'];
          $data[] = $temp;
	}

	return $data;

}
