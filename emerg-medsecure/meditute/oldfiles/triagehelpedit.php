<?php 
include('/home/httpd/html/common.inc');
include('checkvalid.inc');
#PHPINFO(); 

######### update

if ($arr_request[updatetriagehelp] == 'yes' && $TriageDetails[0] && $TriageDetails[1]){


	$triagedetails = implode ($TriageDetails,"{");
	$triagerow1 = implode($TriageA,"{");
	$triagerow2 = implode($TriageB,"{");
	$triagerow3 = implode($TriageC,"{");
	$triagerow4 = implode($TriageD,"{");
	$triagerow5 = implode($TriageE,"{");
	$triagerow6 = implode($TriageF,"{");




	$str_sql = "UPDATE TriageDiagnosis SET TriageDiagnosis ='$triagedetails', TriageA = '$triagerow1', TriageB = '$triagerow2', TriageC = '$triagerow3', TriageD = '$triagerow4', TriageE = '$triagerow5', TriageF = '$triagerow6', TriageNotes = '".$arr_request[TriageNotes]."' WHERE key_ID = '".$arr_request[key_ID]."'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

}

elseif ($arr_request[action] == 'delete'){
	$str_sql = "DELETE FROM TriageDiagnosis WHERE key_ID = '".$arr_request[key_ID]."'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

}
elseif ($arr_request[action] == 'new'){
	$str_sql = "INSERT INTO TriageDiagnosis (TriageDiagnosis) VALUES ('Q###{BLANK')";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

}
else{}


# get the list of all the diagnoses

$str_sql = "SELECT key_ID, TriageDiagnosis FROM TriageDiagnosis ORDER BY TriageDiagnosis";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}


# display the list of diagnoses




include('/home/httpd/html/header.inc');
include('adminnavbar.inc');


print "<H5><CENTER><TABLE cellpadding=5 cellspacing=5 width=98% border=0>";

print "<TR><TD colspan=3><H1>Triage Code Setup</H1></TD></TR>";

print "<TR><TD colspan=3><H4><SPAN class=\"bluebutton\" ><A HREF=\"$PHP_SELF?action=new&user=$arr_request[user]\">Add New Triage Code</A></SPAN></H4></TD></TR>";


while ($triagehelp =  mysql_fetch_array($result)){


	$triagediagnosisrow= explode("{",$triagehelp[TriageDiagnosis]);

	print "<TR><TD width = 50>";
	print $triagediagnosisrow[0];
	print "</TD><TD width = 300>";
	print $triagediagnosisrow[1];

	print "</TD><TD width = 100>";
	print "<H5><A HREF= \"triagehelpeditdetail.php?key_ID=$triagehelp[key_ID]&user=$arr_request[user]\"><SPAN class=\"bluebutton\" >EDIT</SPAN></A>&nbsp;&nbsp;&nbsp;";

	print "<A HREF= \"javascript:popupwindow ('http://$hostname/triage.php?action=Help&TriageNurseCode=$triagediagnosisrow[0]&user=$arr_request[user]');\">";
	print '<SPAN class="greenbutton" >VIEW</SPAN></A></H5>';
	print "</TD><TD width = 50><A HREF= \"$PHP_SELF?action=delete&key_ID=$triagehelp[key_ID]&user=$arr_request[user]\">";
	print '<H5><SPAN class="redbutton" >DELETE</SPAN></A></H5>';
	print "</TD></TR>";

	}


print "</TABLE></CENTER></H5>";
print "</BODY></HTML>";

?>