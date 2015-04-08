<?php 

$key_ID = $arr_request['key_ID'];
$field1 = $arr_request['field1'];
$field2 = $arr_request['field2'];
$newvalue1 = $arr_request['newvalue1'];
$newvalue2 = $arr_request['newvalue2'];
$both = $arr_request['both'];


# check we are updating a valid record
	$str_sql = "Select TriageTimeStamp from Patients where key_ID = $key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
if ((! $key_ID)  || (mysql_num_rows($result) == 0)) {
	error ("Sorry! That Patient has been discharged","or does not exist");
	}
else{}

if ($both == "Y"){
$str_sql = "UPDATE Patients SET	$field1 = '$newvalue1', $field2 = '$newvalue2' WHERE key_ID = $key_ID ";
}
elseif ($both == "code") {
$str_sql = "UPDATE Patients SET	$field1 = '$newvalue2' WHERE key_ID = $key_ID ";
}
else{
$str_sql = "UPDATE Patients SET	$field1 = '$newvalue1' WHERE key_ID = $key_ID ";
}

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}


?>