<?php

$origkey_ID = $arr_request['key_ID'];
$origTriagePosition = $arr_request['TriagePosition'];
$positionabove = $origTriagePosition - 1;
$positionbelow = $origTriagePosition + 1;


if ($direction == 'down'){

#find next record with triage position 1 below, then use the script below to move it up

	$pos_update_sql = "SELECT key_ID FROM Patients WHERE (Doctor = '') AND (TriagePosition = $positionbelow) ";
	$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
	if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}

	$result = mysql_fetch_array($pos_result);

	$origkey_ID = $result['key_ID'];
	$origTriagePosition = $positionbelow;
	$positionabove = $origTriagePosition - 1;
	$positionbelow = $origTriagePosition + 1;
}


else {}

## find the record above, and move it down one point

	
	$pos_update_sql = "SELECT key_ID FROM Patients WHERE (Doctor = '') AND (TriagePosition = $positionabove) ";
	$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
	if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}

	$result = mysql_fetch_array($pos_result);

	$pos_update_sql = "UPDATE Patients SET TriagePosition = $origTriagePosition WHERE key_ID = '".$result[key_ID]."'";
	$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
	if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}

## move orig record up one point

	$pos_update_sql = "UPDATE Patients SET TriagePosition = $positionabove WHERE key_ID = '$origkey_ID'";
	$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
	if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}




?>