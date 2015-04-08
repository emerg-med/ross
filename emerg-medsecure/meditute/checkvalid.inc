<?php 

# check user is still at the same computer
$str_sql = "SELECT AdminTimeOut FROM User WHERE Name = '".$arr_request[user]."' AND AdminIP = '$REMOTE_ADDR'";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$resultar = mysql_fetch_array($result);

if (!$resultar){
	# authentication failed
	error ('This session is no longer active',"Click <A HREF=\"https://$hostname/meditute/admin.php?login=n\"><FONT COLOR=\"0000FF\"><U>here</U></FONT></A> to log in again");
	}

# check user has not expired
$time=time();
#print $resultar[AdminTimeOut]."<BR>".$time;

if ($resultar[AdminTimeOut]>$time){

	# reset AdminTimeOut to 15 minutes from now

	$str_sql = "UPDATE User SET AdminTimeOut='".(time()+900)."' WHERE Name = '$arr_request[user]'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}else{
	# timed out
	error ('This session is no longer active',"Click <A HREF=\"https://$hostname/meditute/admin.php?login=n\"><FONT COLOR=\"0000FF\"><U>here</U></FONT></A> to log in again");
	}

?>