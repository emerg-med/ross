<?php 
include('/home/httpd/html/common.inc');
#phpinfo();
include('checkvalid.inc');

if ($arr_request[action]=='Update'){

	$triagetimestampar = mktime($arr_request[triagehours],$arr_request[triageminutes],30,$arr_request[triagemonth],$arr_request[triageday],$arr_request[triageyear]);

	$str_sql = " UPDATE Patients SET TriageTimeStamp='$triagetimestampar' ,Sex='$arr_request[Sex]' ,TriageNurse='$arr_request[TriageNurse]' ,TriageCategory='$arr_request[TriageCategory]' ,TriageNurseCode='$arr_request[TriageNurseCode]'  WHERE key_ID=$arr_request[key_ID] ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

	#monitor patients whose triage is changed
	if ($arr_request[TriageCategory]<>$arr_request[oldtriagecat]){

		$quality="Triage code changed from ".$arr_request[oldtriagecat]." to ".$arr_request[TriageCategory]." by ".$arr_request[user]." - Original triage done by ".$arr_request[oldnurse];
		$str_sql = "INSERT INTO Quality SET UR='$arr_request[UR]',  Date='".$arr_request[triageday]."/".$arr_request[triagemonth]."/".$arr_request[triageyear]."', QualityText='$quality', FirstName= '$arr_request[FirstName]', Surname='$arr_request[Surname]' ";
		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');} 	
	
		}


	$updated = "<B>[updated successfully]</B><BR><BR>";
	}


if ($arr_request[change]){

	#set up arrays
	$str_sql = "SELECT TriageDiagnosis FROM TriageDiagnosis ORDER BY TriageDiagnosis";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} 
	$triagenursecodelist = array ();
	$dummy='0';
	while ($triage =  mysql_fetch_array($result)){
		$triagenursecodelist[$dummy] = $triage[TriageDiagnosis];
		$dummy++;
		}
	$str_sql = "SELECT Name FROM User WHERE UserType LIKE '%N%' AND Current = 'Yes' ORDER BY Name";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} 
	$nurselist = array ();
	$dummy='0';
	while ($nurse =  mysql_fetch_array($result)){
		$nurselist[$dummy] = $nurse[Name];
		$dummy++;
		}


	$str_sql = " SELECT FirstName, Surname, UR, TriageTimeStamp,Sex,TriageNurse,TriageCategory,TriageNurseCode FROM Patients where key_ID=$arr_request[change] ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$resultar = mysql_fetch_array($result);

	$triagetimestampar = getdate($resultar[TriageTimeStamp]);


	include('/home/httpd/html/header.inc'); 
	include('adminnavbar.inc');

	
	
	print "<FORM METHOD=POST ACTION='$PHP_SELF'>";

	print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
	print "<INPUT TYPE='HIDDEN' NAME='key_ID' VALUE='$arr_request[change]'>";
	print "<INPUT TYPE='HIDDEN' NAME='oldnurse' VALUE='$resultar[TriageNurse]'>";
	print "<INPUT TYPE='HIDDEN' NAME='oldtriagecat' VALUE='$resultar[TriageCategory]'>";
	print "<INPUT TYPE='HIDDEN' NAME='UR' VALUE='$resultar[UR]'>";
	print "<INPUT TYPE='HIDDEN' NAME='FirstName' VALUE='$resultar[FirstName]'>";
	print "<INPUT TYPE='HIDDEN' NAME='Surname' VALUE='$resultar[Surname]'>";
		
	print "<BLOCKQUOTE><H3>This form allows you to edit the triage details of $resultar[FirstName] $resultar[Surname]</H3><BR>";

	print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";
	
	print "<TR><TD>Triage Date";
	print "</TD><TD> ";
	dropdownbox ($daylist, "triageday", $triagetimestampar[mday]);

	
	print "&nbsp;<B>/</B>&nbsp;";
	dropdownbox ($monthlist, "triagemonth", $triagetimestampar[mon]);
	
	print "&nbsp;<B>/</B>&nbsp;";
	dropdownbox ($yearlist, "triageyear", $triagetimestampar[year]);
	print "</TD></TR>";

	print "<TR><TD>Triage Time";
	print "</TD><TD> ";
	dropdownbox ($hourlist, "triagehours", $triagetimestampar[hours]);

	
	print "&nbsp;<B>:</B>&nbsp;";
	dropdownbox ($minutelist, "triageminutes", $triagetimestampar[minutes]);
	print "</TD></TR>";


	print "<TR><TD>Sex";
	print "</TD><TD>";
	print "<input type=\"radio\" name=\"Sex\" value=\"M\"";
	if ($resultar[Sex]== 'M') {print ' checked ';}
	print '>Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	print "<input type=\"radio\" name=\"Sex\" value=\"F\"";
	if ($resultar[Sex]== 'F') {print ' checked ';} else{}
	print '>Female';
	print "</TD></TR>";
	
	print "<TR><TD>Triage Nurse";
	print "</TD><TD>";
	dropdownbox ($nurselist, "TriageNurse", $resultar[TriageNurse]);
	print "</TD></TR>";

	print "<TR><TD>Triage Category";
	print "</TD><TD>";
	dropdownbox ($triagecatlist, "TriageCategory", $resultar[TriageCategory]);
	print "</TD></TR>";

	print "<TR><TD>Triage Code";
	print "</TD><TD>";
	codedropdownbox($triagenursecodelist, "TriageNurseCode", $resultar[TriageNurseCode]);
	print "</TD></TR>";

	print "</TABLE>";
	print "<INPUT TYPE=SUBMIT NAME=action VALUE=Update >";
	print "</BLOCKQUOTE></FORM>";
	include('/home/httpd/html/footer.inc'); 	

	exit;
	}




if ($arr_request[add]){
	$arr_request[add]=bigcleanup($arr_request[add]);
	$str_sql = " INSERT INTO Private SET Insurance='$arr_request[add]' ";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	


	}

$str_sql = " SELECT key_ID,FirstName,Surname FROM Patients ";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}


include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='$PHP_SELF'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE>$updated<H3>This form allows you to edit the triage details of patients in the department</H3><BR>";

print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

while($resultar = mysql_fetch_array($result)){
	print "<TR><TD><A HREF=\"$PHP_SELF?change=$resultar[key_ID]&user=$arr_request[user]\"><SPAN class='redbutton' >Change</SPAN></A></TD><TD>";
	print "$resultar[FirstName] <B>$resultar[Surname]</B></TD></TR>";
	}

print "</TABLE>";


print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 

?>