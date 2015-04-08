<?php

$TriageNurseCode=cleanup($arr_request[TriageNurseCode]);

# get the relevant triage decision support data

$str_sql = "SELECT * FROM TriageDiagnosis WHERE TriageDiagnosis LIKE '$TriageNurseCode"."%'";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('triage help SQL Select Execution has failed.');} else{}

$triagehelp =  mysql_fetch_array($result);

$triagediagnosisrow= explode("{",$triagehelp[TriageDiagnosis]);
$triagerow1 = explode("{",$triagehelp[TriageA]);
$triagerow2 = explode("{",$triagehelp[TriageB]);
$triagerow3 = explode("{",$triagehelp[TriageC]);
$triagerow4 = explode("{",$triagehelp[TriageD]);
$triagerow5 = explode("{",$triagehelp[TriageE]);
$triagerow6 = explode("{",$triagehelp[TriageF]);


include('header.inc');
print "<FORM method='post' action = 'triage.php' name = 'triagehelpform'>";


# resubmit data after cleaning

$arr_request[FirstName]= stripslashes(cleanup($arr_request[FirstName]));
$arr_request[Surname]= stripslashes(cleanup($arr_request[Surname]));
$arr_request[TriageDiagnosis]= stripslashes(cleanup($arr_request[TriageDiagnosis]));
$arr_request[Age]= stripslashes(cleanup($arr_request[Age]));

$hiddenar = array ( "FirstName","Surname","TriageNurse","TriageNurseCode","TriageDiagnosis", "Location", "Age", "Sex", "TriageTimeStamp");
hiddeninput ($hiddenar, $arr_request);


print "<H5><TABLE cellpadding=10 cellspacing=4 WIDTH =98% border=0>";

print "<TR><TD colspan=3><H1>Triage Guidelines - $triagediagnosisrow[1]</H1></TD></TR>";

print "\n<TR>";

for ($dummy=1; $dummy < 8; $dummy++){

	$triagestring = 'triagerow'.$dummy;

	$colourbox1 = ${$triagestring}[0];

	if ($colourbox1){
		
		if ($dummy != 1 ){print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";}
		else{}
		print "<TD width =50%  bgcolor=";
			#insert row of correct colour
			switch ($colourbox1){
				case '1': print "$triage1colour"; break;
				case '2': print "$triage2colour"; break;
				case '3': print "$triage3colour"; break;
				case '4': print "$triage4colour"; break;
				case '5': print "$triage5colour"; break;
				case '6': print "$triage6colour"; break;
				default : print "$bgcolor"; break;
			}


	if ($colourbox1 != 7){
		
		if(ereg( "MSIE", $HTTP_USER_AGENT))
			{ 
			print " ><CENTER><input type = \"submit\" name = \"NewTriageCategory\" value= \"$colourbox1\"></CENTER></TD>";
			}else{

			print " ><CENTER>&nbsp;<button type=submit name='NewTriageCategory' value='$colourbox1' >".nl2br(${$triagestring}[1])."</CENTER></TD>";
			} 



	}else{
	print " ><CENTER>".nl2br(${$triagestring}[1])."</CENTER></TD>";
	}

	}
	$colourbox2 = ${$triagestring}[2];
	if ($colourbox2){
	
	print "<TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
	print "<TD width =25%  bgcolor=";
		#insert row of correct colour
		switch ($colourbox2){
			case '1': print "$triage1colour"; break;
			case '2': print "$triage2colour"; break;
			case '3': print "$triage3colour"; break;
			case '4': print "$triage4colour"; break;
			case '5': print "$triage5colour"; break;
			case '6': print "$triage6colour"; break;
			default : print "#CCCCFF"; break;
		}

	if ($colourbox2 != 7){
		
		if(ereg( "MSIE", $HTTP_USER_AGENT))
			{ 
			print " ><CENTER><input type = \"submit\" name = \"NewTriageCategory\" value= \"$colourbox2\"></CENTER></TD></TR>";
			}else{

			print " ><CENTER>&nbsp;<button type=submit name='NewTriageCategory' value='$colourbox2' >".nl2br(${$triagestring}[3])."</CENTER></TD></TR>";
			} 


	}else{
	print " ><CENTER>".nl2br(${$triagestring}[3])."</CENTER></TD></TR>";
	}

	}
	else {print "<TD colspan = 2></TD></TR>";}

}


#print "<input type = 'hidden' name = 'NewTriageCategory' value = '2'>";

if ($triagehelp[TriageNotes]){

	print "<TR><TD colspan=3><H3>Triage Notes</H3>";
	print "<BLOCKQUOTE>".nl2br($triagehelp[TriageNotes])."</BLOCKQUOTE>";
	print "</TD></TR>";
}

print "</TABLE></H5>";

print "</FORM></BODY></HTML>";

exit;

?>