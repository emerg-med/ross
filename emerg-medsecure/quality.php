<?php 
include("../common.inc");
#phpinfo();
include('checkvalid.inc');


if ($arr_request['Quality_search']){
	$field1 = 'Qualitytext'; 
	$both= "code";
	$table_name = 'Quality';	
	$action = 'Lookup Quality';
	$search_str= $arr_request['Quality_search'];
	$sort_field = 'AlertName';
	$description = "AlertName";
	$code = "AlertUR";
	include("$securepath/datalookup.php");
	exit;
	}

$str_sql = " SELECT * FROM Quality where Current='Y' ORDER BY QualTimeStamp DESC"; #newest first
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}



include("$path/header.inc"); 
include("$securepath/adminnavbar.inc");
print "<FORM METHOD=POST ACTION='quality.php'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE><H3>This allows you to review quality data.<BR>The system administrator can erase the data when the list becomes too large.</H3><BR>";

print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

print "<TR><TH VALIGN=TOP>Date/ Time</TH><TH VALIGN=TOP>UR</TH><TH VALIGN=TOP>Name</TH><TH VALIGN=TOP>Problem</TH></TR>";

while($resultar = mysql_fetch_array($result)){
	$qualtime = date("H:i", $resultar[QualTimeStamp]);
	$qualdate = date("j/n/y", $resultar[QualTimeStamp]);
	print "<TR><TD VALIGN=TOP>$qualdate<BR>$qualtime</TD><TD VALIGN=TOP>$resultar[UR]</TD><TD VALIGN=TOP>$resultar[FirstName] $resultar[Surname]</TD><TD VALIGN=TOP>";
	print "$resultar[QualityText]</TD></TR>";
	}

print "</TABLE>";
/*
print "<BR>Add a new company: ";                     	$qualdate = date("H:i - j M Y", $TriageTimeStamp);

print "<INPUT TYPE=TEXT NAME='add' SIZE=40>";

print "";
print "<INPUT TYPE='SUBMIT' VALUE='add' action='add'><BR><BR>";
*/

print "</BLOCKQUOTE></FORM>";
include("$path/footer.inc"); 

/*
if ($arr_request[delkey_ID]){
	$str_sql = " DELETE FROM Alerts WHERE key_ID ='$arr_request[delkey_ID]'";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}

if ($arr_request[action]=='Add'){
	$arr_request[AlertUR]=cleanup($arr_request[AlertUR]);
	$arr_request[AlertName]=cleanup($arr_request[AlertName]);
	$arr_request[Alert]=cleanup($arr_request[Alert]);
	$str_sql = " INSERT INTO Alerts SET AlertUR='$arr_request[AlertUR]', Alert='$arr_request[Alert]', AlertName='$arr_request[AlertName]', AlertSuperuser='$arr_request[user]', AlertDate= '".time()."' ";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}

if ($arr_request[action]=='Update'){
	$arr_request[AlertUR]=cleanup($arr_request[AlertUR]);
	$arr_request[AlertName]=cleanup($arr_request[AlertName]);
	$arr_request[Alert]=cleanup($arr_request[Alert]);
	$str_sql = " UPDATE Alerts SET AlertUR='$arr_request[AlertUR]', Alert='$arr_request[Alert]', AlertName='$arr_request[AlertName]', AlertSuperuser='$arr_request[user]', AlertDate= '".time()."' WHERE key_ID='$arr_request[key_ID]' ";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}





include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='$PHP_SELF'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'><BLOCKQUOTE>";


if ($arr_request[action]=='addnew'){
	print "<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

	print "<TR><TD>Name</TD><TD><INPUT TYPE=\"text\" NAME=\"AlertName\" SIZE=70 VALUE='$resultar[AlertName]'></TD></TR>";
	print "<TR><TD>UR</TD><TD><INPUT TYPE=\"text\" NAME=\"AlertUR\" SIZE=\"10\" VALUE='$resultar[AlertUR]'></TD></TR>";
	print "<TR><TD VALIGN=TOP>Alert</TD><TD><TEXTAREA NAME=\"Alert\" ROWS=\"2\" COLS=\"60\">$resultar[Alert]</TEXTAREA></TD></TR>";

	print "</TABLE>";	
	print "<INPUT TYPE='HIDDEN' NAME='action' VALUE='Add'>";
	print "<INPUT TYPE='SUBMIT' VALUE='Add' action='Add'><BR><BR>";

	}

*/


/*
elseif ($arr_request[action]=='UpdateData'){
	$str_sql = " SELECT * FROM Quality ORDER BY Date ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

	$resultar = mysql_fetch_array($result);
	

	print "<INPUT TYPE='HIDDEN' NAME='key_ID' VALUE='$resultar[key_ID]'>";
	print "<H3>Edit alert message</H3>";
	print "<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";
	print "<TR><TD>Name</TD><TD><INPUT TYPE=\"text\" NAME=\"AlertName\" SIZE=70 VALUE='$resultar[AlertName]'></TD></TR>";
	print "<TR><TD>UR</TD><TD><INPUT TYPE=\"text\" NAME=\"AlertUR\" SIZE=\"10\" VALUE='$resultar[AlertUR]'></TD></TR>";
	print "<TR><TD VALIGN=TOP>Alert</TD><TD><TEXTAREA NAME=\"Alert\" ROWS=\"2\" COLS=\"60\">$resultar[Alert]</TEXTAREA></TD></TR>";
	print "<TR><TD>Submitted&nbsp;by</TD><TD>$resultar[AlertSuperuser]</TD></TR>";
	print "<TR><TD>Date</TD><TD>".strftime( '%d/%m/%y' ,$resultar[AlertDate])."</TD></TR>";
	print "</TABLE>";

	print "<A HREF=\"$PHP_SELF?delkey_ID=$resultar[key_ID]&user=$arr_request[user]\"><SPAN class='redbutton' >Delete</SPAN></A>";
	print "<INPUT TYPE='HIDDEN' NAME='action' VALUE='Update'>";
	print "<CENTER><INPUT TYPE='SUBMIT' VALUE='Update' action='Update'></CENTER><BR><BR>";
	}

else {

	print "<H3>This form allows you to add/edit/delete alerts for patients</H3><BR><H5>Remember that what you write becomes part of the notes, and therefore patients may see it.<BR>Therefore rather than write 'this person is stupid and violent', it is better to write 'this patient has a history of poorly controlled aggressive behaviour'.<BR>Similarly 'history of drug seeking behaviour' is preferable to 'addict'</H5><BR>";

	print "<A HREF=\"$PHP_SELF?action=addnew&user=$arr_request[user]\"><SPAN class='greenbutton' >Add&nbsp;New&nbsp;Alert</SPAN></A><BR>";

	print "<BR>Search for [Name or UR]: ";
	print "<INPUT TYPE=TEXT NAME='AlertName_search' SIZE=40>";

	print "";
	print "<INPUT TYPE='SUBMIT' VALUE='search' action='search'><BR><BR>";

	}



print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 
*/
?>