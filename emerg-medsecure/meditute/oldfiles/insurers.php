<?php 
include('/home/httpd/html/common.inc');
#phpinfo();
include('checkvalid.inc');


if ($arr_request[action]=='delete'){

	$str_sql = " DELETE FROM Private WHERE Insurance='$arr_request[delete]'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	


	}
if ($arr_request[add]){
	$arr_request[add]=bigcleanup($arr_request[add]);
	$str_sql = " INSERT INTO Private SET Insurance='$arr_request[add]' ";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	


	}



$str_sql = " SELECT Insurance FROM Private";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}



include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='insurers.php'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE><H3>This form allows you to edit names of the insurance companies</H3><BR>";

print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

while($resultar = mysql_fetch_array($result)){
	print "<TR><TD><A HREF=\"insurers.php?action=delete&delete=$resultar[0]&user=$arr_request[user]\"><SPAN class='redbutton' >Delete</SPAN></A></TD><TD>";
	print $resultar[0]."</TD></TR>";
	}

print "</TABLE>";
print "<BR>Add a new company: ";
print "<INPUT TYPE=TEXT NAME='add' SIZE=40>";

print "";
print "<INPUT TYPE='SUBMIT' VALUE='add' action='add'><BR><BR>";


print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 

?>