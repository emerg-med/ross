<?php 
require('common.inc');

##### Set up arrays

require('regsetup.inc');

#####


$key_ID = $arr_request['key_ID'];

if (($arr_request['action']=='Lookup Hospital')&&($key_ID)){ #check that we are looking up a valid patient
	$field1 = 'ArriveSource'; 
	$both= "code";
	$table_name = 'Hospitals';	
	$action = 'Lookup Hospital';
	$search_str= $arr_request['Hospital_search'];
	$sort_field = 'Hospital';
	$description = "Hospital";
	$code = "Code";
	include('datalookup.php');
	exit;
	}

if (($arr_request['action']=='Lookup Country')&&($key_ID)){ 
	$field1 = 'Country'; 
	$both= "code";
	$table_name = 'Country';	
	$action = 'Lookup Country';
	$search_str= $arr_request['Country_search'];
	$sort_field = 'Country';
	$description = "Country";
	$code = "Code";
	include('datalookup.php');
	exit;
	}

if (($arr_request['action']=='Lookup GP')&&($key_ID)){ 
	$field1 = 'GP'; 
	$both= "code";
	$table_name = 'GP';	
	$action = 'Lookup GP';
	$search_str = $arr_request['GP_search'];
	$sort_field = 'GP';
	$description = "GP";
	$code = "Code";
	include('datalookup.php');
	exit;
	}

if (($arr_request['action']=='Lookup Locality')&&($key_ID)){ 
	$field1 = 'Locality'; 
	$field2 = 'Postcode'; 
	$both= "Y";
	$table_name = 'Postcode';	
	$action = 'Lookup Locality';
	$search_str= $arr_request['Locality_search'];
	$sort_field = 'Locality';
	$description = "Locality";
	$code = "Code";
	include('datalookup.php');
	exit;
	}

if ($arr_request['action']=='UpdateData'){ 
	include('updatedata.inc');
	}

if ($arr_request['action']=='Update'){ #update details
	include('update.inc');
	}else{}



$refresh = ''; # don't refresh
include('header.inc'); 
include('navbar.inc');



	


print '<CENTER>';#####  Start Main Table
print '<H4><TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD>';##### main table
print '<FORM action="reg.php" method="post">';

print '<TABLE cellpadding=1 cellspacing=1 border=3 width=100%>';##### 2 side by side windows

print '<TR><TD width=15% valign=top background=bckgrnddk.gif>';##### window 1



print '<TABLE cellpadding=0 cellspacing=1 border=0 width=100%>';# table to put all patient into

## get all patients(Surname, FirstName, Location, TriageCategory)

$str_sql = "SELECT * FROM Patients ORDER BY Surname";
	 	

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {
    affy_error_exit('SQL Select Execution has failed.');
  }else{}

while ($row = mysql_fetch_array($result)){

print '<TR><TD bgcolor=';
	#insert row of correct colour
	if ($row["TriageCategory"]=='1') {print "$triage1colour";}
	elseif ($row["TriageCategory"]=='2') {print "$triage2colour";}
	elseif ($row["TriageCategory"]=='3') {print "$triage3colour";}
	elseif ($row["TriageCategory"]=='4') {print "$triage4colour";}
	elseif ($row["TriageCategory"]=='5') {print "$triage5colour";}
	else {print "$triage6colour";}


print ' VALIGN=TOP><A HREF="reg.php?key_ID='.$row[key_ID].'">';

print "<H5><B>$row[Surname],&nbsp;&nbsp;</B>$row[FirstName]<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $row[Location]";

print '</H5></A>';

print '</TD></TR>';

} #end while statement


print '</TABLE>';




print "</TD>";##### window 1 
print "<TD width=85% valign=top>";##### window 2 

##### SQL

$str_sql = "select * FROM Patients WHERE key_ID = '$key_ID'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed.');}
else{}

#fetch array
$patient = mysql_fetch_array($result);

if($key_ID){
	include('reglock.inc');# lock record so that only one user can use
	}

#####


print"<CENTER><H1>";

if ($key_ID){
	print $patient[FirstName]."&nbsp;&nbsp;<B>".$patient[Surname]."</B></H1>";
	}
else {print"Registration</H1><H6><FONT COLOR=\"#FF0000\">Click on a patient on the list on the left to load their details</FONT></H6>";
	}
print "</CENTER><HR width=80%>";



$hiddenar = array ("key_ID","Sex","Locality","Postcode","TriageDate","TriageTime","TriageNurse","TriageCategory","DoctorDate","DoctorTime","Procedures","BedReq","BedReqDate","BedReqTime","DepartureDate","DepartureTime","DischargedStatus","TransHosp","DischargedTo","CareComm","TransReason","TransEscort","TransMode","Diagnosis1","Diagnosis2","Diagnosis3","InjuryNatureof","InjuryBodyRegion","TriageDiagnosis","InjuryCause","InjuryIntent","InjuryPlace","InjuryActivity","ArrivalTimeStamp","TriageTimeStamp","DoctorTimeStamp","BedReqTimeStamp","DischargedTimeStamp","Location","StatusReport","Doctor","Age","TriageNurseCode","TriagePosition","AdmitWard");
hiddeninput ($hiddenar, $patient);


print '<TABLE cellpadding=5 cellspacing=0 border=0 width=100%>';


#print "<TR><TD>Triage Time/ Date </TD><TD>" . date("H:i - j M Y", $patient[TriageTimeStamp]);
#print '</TD>';
#print "<TD></TD><TD></TD></TR>";


print "<TR><TD>";
if (!$patient[FirstName]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print"First Name </FONT></TD><TD><input type=\"text\" name=\"FirstName\" size= \"20\" value=\"$patient[FirstName]\">";


print '</TD><TD>';
if (!$patient[Surname]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Surname </FONT></TD><TD><input type=\"text\" name=\"Surname\" size= \"20\" value=\"$patient[Surname]\">";
print '</TD></TR>';

$dobday = substr ($patient[DateOfBirth],0,2);
$dobmonth =  substr ($patient[DateOfBirth],2,2);
$dobyear =  substr ($patient[DateOfBirth],4,4);


if ($patient[Age] && ($dobday=='00'|| $dobmonth=='00')){# if no dob, but age is set, guess the dobyear
	$dobyear = $todayyear-$patient[Age];
	}
	
if(!$dobday || $dobday == '00'){
	$dobday = '00';
	array_unshift ($daylist, "00");
	}else{
	array_push ($daylist, "00");
	}

if(!$dobmonth ||$dobmonth == '00'){
	$dobmonth = '00';
	array_unshift ($monthlist, "00");
	}else{
	array_push ($monthlist, "00");
	}

print "<TR><TD>";

if ($dobday=='00'|| $dobmonth=='00'){
	print "<FONT COLOR= #FF0000 >";
	}else{print"<FONT>";}

print "Date Of Birth </FONT></TD><TD>";
dropdownbox ($daylist, "dobday", $dobday );
print "<FONT SIZE=\"4\">/ </FONT>";
dropdownbox ($monthlist, "dobmonth", $dobmonth );
print "<FONT SIZE=\"4\">/ </FONT>";
dropdownbox ($dobyearlist, "dobyear", $dobyear );

print '</TD>';



print "<TD>Age / Sex </TD><TD>" . $patient[Age]."&nbsp;/&nbsp;".$patient[Sex];
print '</TD></TR>';


/* 
print "<TR><TD>Address </TD><TD colspan=3><input type=\"text\" name=\"Address\" size= \"50\" value=\"$patient[Address]\">";
print '</TD></TR>';


print "<TR><TD>";
if (!$patient[Locality]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Locality </FONT></TD><TD>$patient[Locality]";
print '</TD><TD>';
if (!$patient[Postcode]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Postcode </FONT></TD><TD>$patient[Postcode]";
print '</TD></TR>';

print "<TR><TD></TD><TD colspan=3 ><input type=\"text\" name=\"Locality_search\" size= \"15\">&nbsp;&nbsp;";
print "<input type=\"submit\" name = \"action\" value=\"Lookup Locality\">";
print '<BR><HR width=80%>';
print '</TD></TR>';

print "<TR><TD>Home Phone</TD><TD><input type=\"text\" name=\"PhoneHome\" size= \"15\" value=\"$patient[PhoneHome]\"";
print '</TD>';

print "<TD>Work Phone</TD><TD><input type=\"text\" name=\"PhoneWork\" size= \"15\" value=\"$patient[PhoneWork]\"";
print '</TD></TR>';


print "<TR><TD>Mobile Phone</TD><TD><input type=\"text\" name=\"PhoneMob\" size= \"15\" value=\"$patient[PhoneMob]\"";
print '</TD>';

print "<TD>e-mail </TD><TD><input type=\"text\" name=\"Email\" size= \"15\" value=\"$patient[Email]\"";
print '</TD></TR>';
*/
print "<TR><TD colspan=4><HR width=80%>";
print "<CENTER><input type=\"submit\" name=\"action\" value=\"Update\" ></CENTER><HR width=80%></TD></TR>";

print "<TR><TD>NHS Number </TD><TD><input type=\"text\" name=\"Medicare\" size= \"15\" value=\"$patient[Medicare]\">";
print '</TD>';

# print "<TD>Medicare Suffix </TD><TD>";
# codedropdownbox($medicaresuffixlist, "MedicareSuffix", $patient[MedicareSuffix]);
print "<TD>";
if (!$patient[TypeVisit]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}
print "Type of Visit</FONT></TD><TD>";
codedropdownbox($visitlist, "TypeVisit", $patient[TypeVisit]);
print "</TD><TD>";
print "</TD></TR>";

print "<TR><TD>";
if (!$patient[UR]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Hospital Number </FONT></TD><TD><input type=\"text\" name=\"UR\" size= \"10\" value=\"".$patient[UR]."\">";
print '</TD><TD>';

if (!$patient[GP]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

	print "GP</FONT></TD>";
	print "<TD><input type = \"hidden\" name = \"GP\" value = \"$patient[GP]\">";

	$str_sql = "SELECT GP from GP WHERE Code = '$patient[GP]' ";
	$gpresult = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $gpresult) { affy_error_exit('SQL Select Execution has failed.');}
	$gpar = mysql_fetch_row($gpresult);


	print $gpar[0]; 
	print "<BR><input type=\"text\" name=\"GP_search\" size= \"10\">&nbsp;";
	print "<input type=\"submit\" name = \"action\" value=\"Lookup GP\">";
	

print '</TD></TR>';



/*
print "<TR><TD>";
if (!$patient[Marital]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Marital Status</FONT></TD>";
print "<TD>";
codedropdownbox($maritallist, "Marital", $patient[Marital]);
print "</TD><TD valign=top>";

if (!$patient[Language]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Language</FONT></TD><TD>";

$language = $patient[Language];
#if (! $language) {$language = "19" ;}#default language = English
codedropdownbox($languagelist, "Language", "$language");
print "</TD></TR>";

print "<TR><TD>";
if (!$patient[Religeon]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print" Religion</FONT></TD><TD>";
codedropdownbox($religeonlist, "Religeon", $patient[Religeon]);
print "</TD><TD>";


if (!$patient[GP]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

	print "GP</FONT></TD>";
	print "<TD><input type = \"hidden\" name = \"GP\" value = \"$patient[GP]\">";

	$str_sql = "SELECT GP from GP WHERE Code = '$patient[GP]' ";
	$gpresult = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $gpresult) { affy_error_exit('SQL Select Execution has failed.');}
	$gpar = mysql_fetch_row($gpresult);


	print $gpar[0]; 
	print "<BR><input type=\"text\" name=\"GP_search\" size= \"10\">&nbsp;";
	print "<input type=\"submit\" name = \"action\" value=\"Lookup GP\">";
	

print "</TD></TR>";

print "<TR><TD>";
if (!$patient[ReferredBy]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Referred By </FONT></TD><TD>";
codedropdownbox($referredbylist, "ReferredBy", $patient[ReferredBy]);
print "</TD>";
;


if ($patient[ReferredBy] == '6'){ #if transport from another hosp
	print "<TD>";
	if (!$patient[ArriveSource]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

	print "Transferred From</FONT></TD><TD>";
	print "<input type = \"hidden\" name = \"ArriveSource\" value = \"$patient[ArriveSource]\">";

	$str_sql = "SELECT Hospital from Hospitals WHERE Code = '$patient[ArriveSource]' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$hospar = mysql_fetch_row($result);


	print $hospar[0]; 
	print "<BR><input type=\"text\" name=\"Hospital_search\" size= \"10\">&nbsp;";
	print "<input type=\"submit\" name = \"action\" value=\"Lookup Hospital\">";
	}

	else {
	print "<TD></TD><TD>";
	}

print"</TD></TR>";

print "<TR><TD>";
if (!$patient[ArriveTrans]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Transport</FONT></TD><TD>";
codedropdownbox($transmodelist, "ArriveTrans", $patient[ArriveTrans]);
print "</TD>";

if ($patient[ArriveTrans]<6){
	print "<TD>";
	if (!$patient[AmbCase]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

	print "Amb. Case No.</FONT></TD>";
	print "<TD><input type=\"text\" name=\"AmbCase\" size= \"15\" value= \"$patient[AmbCase]\"></TD></TR>";
	}else{
	print "<TD></TD><TD></TD></TR>";
	}

print "<TR><TD>";
if (!$patient[TypeVisit]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}
print "Type of Visit</FONT></TD><TD>";
codedropdownbox($visitlist, "TypeVisit", $patient[TypeVisit]);
print "</TD><TD>";
if (!$patient[Country]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Country of Birth</FONT></TD>";
print "<TD>";

print "<input type = \"hidden\" name = \"Country\" value = \"$patient[Country]\">";

	$str_sql = "SELECT Country from Country WHERE Code = '$patient[Country]' AND Main = 'm'";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$hospar = mysql_fetch_row($result);


	print $hospar[0]; 
	print "<BR><input type=\"text\" name=\"Country_search\" size= \"10\">&nbsp;";
	print "<input type=\"submit\" name = \"action\" value=\"Lookup Country\">";
	

print "</TD></TR>";



print "<TR><TD>";
if (!$patient[Indigenous]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Compensable</FONT></TD><TD>";
codedropdownbox($compenslist, "Compensable", $patient[Compensable]);
print "</TD><TD>";

if (!$patient[Indigenous]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}

print "Indigenous</FONT></TD><TD>";
codedropdownbox($indiglist, "Indigenous", $patient[Indigenous]);
print "</TD></TR>";

print "<TR><TD colspan=4><HR width=80%></TD></TR>";

print "<TR><TD>Medical Alert</TD><TD>";
dropdownbox ($yesnolist, "MedAlert", $patient[MedAlert] );
print "&nbsp;&nbsp;Drug Alert&nbsp;";
dropdownbox ($yesnolist, "DrugAlert", $patient[DrugAlert] );

print "</TD><TD>";
if (!$patient[ClericalID]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}
print "Clerk</FONT></TD><TD>";
dropdownbox2($clericallist, "ClericalID", $patient[ClericalID]);
print "</TD></TR>";


print "<TR><TD>";
if (!$patient[PrivInsurance]){print "<FONT COLOR= #FF0000 >";}else{print"<FONT>";}
print "Private Insurance</FONT></TD><TD>";
dropdownbox2($privlist, "PrivInsurance", $patient[PrivInsurance]);
print "</TD>";
print "<TD>Number</TD><TD>";
print "<input type=\"text\" name=\"PrivNumber\" size= \"15\" value= \"$patient[PrivNumber]\">";
print "</TD></TR>";
*/

print "<TR><TD></TD><TD>";

print "</TD>";
print "<TD></TD>";
print "<TD></TD></TR>";

print "<TR><TD colspan=4><HR width=80%>";
print "<CENTER><input type=\"submit\" name=\"action\" value=\"Update\" ></CENTER><HR width=80%></TD></TR>";

print '</TABLE>';


print "</TD></TR>";##### window 2 
print "</TABLE>";##### 2 side by side windows 
print "</TD></TR></TABLE>";##### main table
print "</FORM></H4></CENTER>";##### Finish Main Table

 
include('footer.inc');