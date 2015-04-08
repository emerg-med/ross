<?php
include('common.inc');

#phpinfo();

	    $image_sql = "select Pic".$arr_request[Pic]." from MedHelp where key_ID=".$arr_request[key_ID];

 

	 $image = mysql_db_query($dbname, $image_sql, $id_link);

		 if (!$image) {
		 affy_error_exit('SQL Execution has failed.');
		
		 }

		$imagearr=mysql_fetch_array($image);

		header ("Content-type: image/pjpeg");
		print $imagearr[0];
	
	exit;
?>