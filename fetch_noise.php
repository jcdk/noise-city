<?php
	ini_set('memory_limit', '150M');

//Connect to Database
// Load secret config settings.
require("config.php");
$connect_ID=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db("DB_NAME") or die ("Could not connect to database");

########################################################
#	GET SOME NOISE									   #
########################################################
if ($_POST["get_noise"]=="nyc") { 
	//Get the new coordinates to crop the image.

	// FORMAT THE DATA PRIOR TO INSERT
	$lat = addslashes($_POST["lat"]);
	$lng = addslashes($_POST["lng"]);
	$acc = addslashes($_POST["accuracy"]);

	$altype = array();
	$adesc = array();
	$incd = array();

	// GET LAST LOCATION
	$querys = "SELECT `Unique Key` as ukid, LocationType, Descriptor, IncidentAddress, CreatedDate, mCreatedDate, Latitude, Longitude, SQRT(
			    POW(69.1 * (Latitude - ".$lat."), 2) +
			    POW(69.1 * (".$lng." - Longitude) * COS(Latitude / 57.3), 2)) AS distance
			FROM noise_rawr 
			HAVING distance < 0.04 ORDER BY distance, mCreatedDate DESC LIMIT 9; ";
	$results = mysql_query($querys);

	if ($results && mysql_num_rows($results) > 0) {

		$ncnt = mysql_num_rows($results);

		while ($row = mysql_fetch_object($results)) {

			$altype[] = $row->LocationType;
			$adesc[] = $row->Descriptor;
			$aincd[] = $row->IncidentAddress;
			
			$ukid = $row->ukid;

		}
		
		// INSERT OR RETRIEVE EXISTING LOCATION
		$querysa = "INSERT INTO noise_track (nr_id) VALUES (".$ukid.") ";
		$resultsa = mysql_query($querysa) or die (mysql_error() . " in ".$querysa);
		
	} else {


	}

	echo "success|".json_encode($altype)."|".json_encode($adesc)."|".json_encode($aincd)."|".$ncnt;
}