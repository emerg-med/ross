<?

#phpinfo();

$timetoexpire = (time() + $locktime);
$lockedar = explode ("#",$patient[Locked]);

if (($lockedar[1] > time()) && ($lockedar[0] != $HTTP_SERVER_VARS[REMOTE_ADDR])) { 
# if this record is locked by another user	
		
	#  if another computer trying to access record
	error ("Sorry! Another user is editing that record","Try again in 1 minute");	
	}
	else{
			
	$str_sql = "update Patients set Locked = '".$HTTP_SERVER_VARS[REMOTE_ADDR]."#".$timetoexpire."' where key_ID = $key_ID"; #put IP and time locked into table
	
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Execution has failed.');}
	}

?>