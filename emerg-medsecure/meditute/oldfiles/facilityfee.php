<?php 
include('/home/httpd/html/common.inc');
#phpinfo();
include('checkvalid.inc');



if ($arr_request[FacFee]){
	$arr_request[FacFee]=cleanup($arr_request[FacFee]);
	if ($arr_request[oldFacFee]){# update previous facility fee set

		$str_sql = " UPDATE Setup SET Number1='$arr_request[FacFee]' WHERE  Name='FacilityFee' ";

		}else{# insert new facility fee

		$str_sql = " INSERT INTO Setup SET Name='FacilityFee', Number1='$arr_request[FacFee]' ";
		}

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}



$str_sql = " SELECT Number1 FROM Setup WHERE Name= 'FacilityFee' ";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$resultar = mysql_fetch_array($result);


include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='facilityfee.php'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE><H3>This form allows you to change the Facility Fee</H3><BR>";

print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";


print "<TR><TD>The current Facility Fee is </A></TD><TD>";
print "$ $resultar[Number1]</TD></TR>";
	
print "<INPUT TYPE='HIDDEN' NAME='oldFacFee' VALUE='$resultar[Number1]' >";

print "<TR><TD>New Facility Fee</TD><TD>";
print "$ <INPUT TYPE=TEXT NAME='FacFee' SIZE=10 VALUE= $resultar[Number1]></TD></TR>";
print "</TABLE>";
print "";
print "<INPUT TYPE='SUBMIT' VALUE='change' ><BR><BR>";


print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 

?>