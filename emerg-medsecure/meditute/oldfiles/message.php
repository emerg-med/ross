<?php 
include('/home/httpd/html/common.inc');

include('checkvalid.inc');


if ($arr_request[action]=='update'){
	$arr_request[newmessage]=bigcleanup($arr_request[newmessage]);
	$str_sql = " UPDATE Setup SET Text1='$arr_request[newmessage]' WHERE Name='Message'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	
	error('the message has been changed',"check <A HREF='http://$hostname/waitingroom.php'>$hostname/waitingroom.php</A> to check");

	}




$str_sql = " SELECT Text1  FROM Setup WHERE Name='Message'";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$resultar = mysql_fetch_array($result);

include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='message.php?action=update'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE><H3>This form allows you to edit the message shown to the waiting room</H3>";

print "<BR><textarea name=newmessage ROWS=8 COLS=50 WRAP=virtual>";
print $resultar[Text1];
print "</textarea>";


print "<BR><BR>";
print "<INPUT TYPE='SUBMIT' >";


print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 

?>