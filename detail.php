<? 
require('common.inc');

########### get all doctors and put into an array

$str_sql = "SELECT Name FROM User WHERE UserType LIKE '%D%' AND Current = 'Yes' ORDER BY Name";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed -users.');} else{}

$doctorlist = array ();
$i='0';
while ($doctor =  mysql_fetch_array($result)){
$doctorlist[$i] = $doctor[Name];
$i++;
}

######### update/ search as necessary	

if ($arr_request['action']=='Update'){ 
	include('update.inc');
	}

if ($arr_request['action']=='Diagnosis search'){ 
	
	if (!$arr_request['field1']){

		if (!$arr_request['Diagnosis1']){$field1='Diagnosis1';}
		elseif (!$arr_request['Diagnosis2']){$field1='Diagnosis2';}
		else {$field1='Diagnosis3';}
		}else 
		{ $field1=$arr_request['field1']; }

	$table_name= 'UDDA';	
	$both= "code";
	$action = 'Diagnosis search';
	$search_str = $arr_request['Diagnosis_search'];
	$sort_field = 'Description';
	$description = "Description";
	$descriptiondescription = "Diagnosis";
	$code = "UDDAUniqueID";
	$codedescription = "Code";
	include('datalookup.php');
	exit;
	}

if ($arr_request['action']=='Lookup Hospital'){ 
	$field1 = 'TransHosp'; 
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



if ($arr_request['action']=='UpdateData'){ 
	include('updatedata.inc');
	}

## pull patient record off database 

    $key_ID  = $arr_request['key_ID']; 
	$str_sql = "SELECT * from Patients where key_ID = $key_ID";

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {affy_error_exit('This patient has been discharged or does not exist.');}

$patient = mysql_fetch_array($result);

## ready for action!


##prevent multiple users editing same record

include('recordlock.inc');

$refresh=""; #don't refresh
include('header.inc'); 
include('navbar.inc');


#  Start Main Table

print "<CENTER><TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD><!-- main table -->";

print "<TABLE cellpadding=1 cellspacing=1 border=3 width=100%><TR>";
print"<TD width=100% valign=top><H5><FORM action=detail.php method=\"post\">";

#send all variables back to the update function


print"<input type= 'hidden' name = 'dobday' value= '".substr ($patient[DateOfBirth],0,2)."'>";
print"<input type= 'hidden' name = 'dobmonth' value= '".substr ($patient[DateOfBirth],2,2)."'>";
print"<input type= 'hidden' name = 'dobyear' value= '".substr ($patient[DateOfBirth],4,4)."'>";

$hiddenar = array ("key_ID","UR","Medicare","MedicareSuffix","DVA","Sex","Country","Indigenous","Language","Locality","Postcode","ArriveTrans","ReferredBy","ArriveSource","TypeVisit","Compensable","AmbCase","ArrivalDate","ArrivalTime","TriageDate","TriageTime","TriageNurse","TriageCategory","TriageDiagnosis","ArrivalTimeStamp","TriageTimeStamp","BedReqTimeStamp","FirstName","Surname","Age","TriageNurseCode", "TriagePosition","GP","PatientTitle","PhoneHome","PhoneWork","PhoneMob","Email","Marital","Religeon","PrevName","MedAlert","DrugAlert","CurrIndic","HistIndic","ClericalID");
hiddeninput ($hiddenar, $patient);


#print"<input type= 'hidden' name = 'DoctorDate' value= '$patient[DoctorDate]'>";
#print"<input type= 'hidden' name = 'DoctorTime' value= '$patient[DoctorTime]'>";
#print"<input type= 'hidden' name = 'DoctorTimeStamp' value= '$patient[DoctorTimeStamp]'>";


print "<TABLE width = 100% border = 0 cellpadding = 3 cellspacing = 0>\n"; #whole patient table 

print "<TR><TD COLSPAN=4><TABLE width=100% border=0 cellpadding=0 cellspacing=0 >\n"; #patient header

$triagecategory = $patient["TriageCategory"];
print "<TR bgcolor=";
	#insert row of correct colour
	switch ($triagecategory){
		case '1': print "$triage1colour"; break;
		case '2': print "$triage2colour"; break;
		case '3': print "$triage3colour"; break;
		case '4': print "$triage4colour"; break;
		case '5': print "$triage5colour"; break;
		default : print "$triage6colour"; break;
	}

print " ><TD WIDTH=25% VALIGN=MIDDLE >&nbsp;";
print "<A HREF=\"notes.php?key_ID=$key_ID&notes=obs\"><IMG SRC=\"images/notesobs.gif\" ALT=\"Observation chart\"></A>&nbsp;";#so that observation chart can be started before patient fully clerked

if ($patient[UR]){
	print "<A HREF=\"notes.php?key_ID=$key_ID&notes=short\">
	<IMG SRC=\"images/notesshort.gif\" ALT=\"Short notes\"></A>&nbsp;<A HREF=\"notes.php?key_ID=$key_ID&notes=long\">
	<IMG SRC=\"images/noteslong.gif\" ALT=\"Long notes\"></A>&nbsp;<A HREF=\"notes.php?key_ID=$key_ID&notes=extra\">
	<IMG SRC=\"images/notese.gif\" ALT=\"Extra notes\"></A>&nbsp;<A HREF=\"notes.php?key_ID=$key_ID&notes=drugs\">
	<IMG SRC=\"images/notesfluids.gif\" ALT=\"Drug/ fluid chart\"></A>&nbsp;&nbsp;<A HREF=\"";
	
	if (strpos($patient[Location], "AAU") === 0) {
		print "labels_AAU.php?key_ID=$key_ID\"><IMG SRC=\"images/labels.gif\" ALT=\"Print labels\"></A>&nbsp;";
	} else {
		print "labels_SSU.php?key_ID=$key_ID\"><IMG SRC=\"images/labels.gif\" ALT=\"Print labels\"></A>&nbsp;";
	}
}


if ($patient[Procedures]){
	print "<A HREF=\"javascript:popupwindow('letter.php?key_ID=$key_ID');\"><IMG SRC=\"images/letter.gif\" ALT=\"Write letter to GP\"></A>&nbsp;";
	if ($private) {print "<A HREF=\"bill.php?key_ID=$key_ID\"><IMG SRC=\"images/bill.gif\" ALT=\"Print bill\"</A>";}
	}

print "</TD><TD ALIGN=CENTER WIDTH=55%>";
print "<H3 class= 'title' >$patient[FirstName] <B>$patient[Surname]</B>";
print "&nbsp;&nbsp;($patient[Sex])&nbsp;&nbsp;&nbsp;&nbsp;$patient[Age]</H3></TD><TD ALIGN= RIGHT WIDTH = 20%>"; #


print "<H3 class= 'title' ><A HREF=\"path.php\"><IMG SRC=\"images/path.gif\" ALT=\"Pathology\"></A>&nbsp;<A HREF=\"radiol.php\"><IMG SRC=\"images/radiol.gif\" ALT=\"Radiology\"></A>&nbsp;";

print"HN&nbsp;&nbsp;".$patient[UR]."&nbsp;</H3>";
print "</TD></TR></TABLE></TD></TR>";#end of patient header 

print "\n<TR><TD><CENTER><TABLE width = 98% border = 0 cellpadding = 2 cellspacing = 0>"; 

#start patient info


if ($patient[UR]){#look for any alerts for this UR

	$str_sql = "select * from Alerts where AlertUR = '$patient[UR]'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Execution has failed - alerts.');}
  	while ($alertarray = mysql_fetch_array($result)){
		print "<TR width=100% ><TD colspan =5>";

		print "<H4><FONT COLOR = '#FF0000'>ALERT: " . $alertarray[Alert] . ".<BR>(Alert for ". $alertarray[AlertName] . " written by " . $alertarray[AlertSuperuser] . " dated " . strftime( '%d/%m/%y' ,$alertarray[AlertDate]) . ")" ;

		print "</H4><BR></TD></TR><FONT COLOR = '#000000'>";
	}	
}

#row 1
print "<TR>";	#<TD rowspan=3>";

#include ('guidelines.inc'); #put guidelines etc into java menu

print"<TD width=20%>Location </TD><TD width=20%>";

if (strpos($patient[Location], "AAU") === 0) {
	dropdownbox ($locationlistAAU, "Location", $patient[Location] );
} else if (strpos($patient[Location], 'SSU-2') === 0) {
	dropdownbox ($locationlistSSU2, "Location", $patient[Location] );
} else if (strpos($patient[Location], 'SSU') === 0) {
	dropdownbox ($locationlistSSU, "Location", $patient[Location] );
} else {
	dropdownbox ($locationlist, "Location", $patient[Location] );
}

print "</select>";
print '</TD>';

print "<TD width=20%>Breach/ Incident </TD><TD width=20%><input type=\"text\" name=\"Quality\" size= \"25\" >" ;


print '</TD></TR>';

#row 2

print "<TR><TD>Doctor </TD><TD>";
if (!$patient[Doctor]){ #if a picked up by a doctor only allow transfer
dropdownbox2 ($doctorlist, "Doctor", $patient[Doctor] );
}
else {
dropdownbox ($doctorlist, "Doctor", $patient[Doctor] );
}
print "</select>";
print '</TD>';

print "<TD>Triage Diagnosis </TD><TD>";
print "<textarea onKeyPress=\"return ( this.value.length < 100 );\" onPaste=\"return (( this.value.length + window.clipboardData.getData('Text').length) < 100 );\" name=\"TriageDiagnosis\" cols= \"30\" rows=\"2\" >".$patient[TriageDiagnosis]."</textarea>";
print "</TD></TR>\n";

#row 3

print "<TR><TD>Bed requested</TD><TD>";
if (!$patient[BedReqTimeStamp]){
	print "<INPUT TYPE =\"checkbox\" NAME = \"BedReq\" VALUE = \"Y\" >Yes";
	}else{
	print strftime( "%H:%M &nbsp;%d/%m/%y" ,$patient[BedReqTimeStamp]);

	}
print "</TD>";

print "\n<TD>Action + Time </TD><TD>";
print "<input type=\"text\" name=\"StatusReport\" size= \"25\" value=\"$patient[StatusReport]\">";

print '</TD></TR>';

#row 4

#print "<TR><TD></TD><TD>";
#print '</TD><TD>';
#print "</TD></TR>\n";

#submit row

print "<TR><TD colspan = 5><CENTER><H6><BR></H6><input type=\"submit\" name = \"action\" value=\"Update\"></CENTER></TD></TR>";

print "</TABLE></CENTER>\n"; #close patient info table
print '</TD></TR>';

$Diagnosis1 = $patient[Diagnosis1];
$Diagnosis2 = $patient[Diagnosis2];
$Diagnosis3 = $patient[Diagnosis3];
$Diagnosis1Certainty = $patient[Diagnosis1Certainty];
$Diagnosis2Certainty = $patient[Diagnosis2Certainty];
$Diagnosis3Certainty = $patient[Diagnosis3Certainty];

$flagsDischargeScreen = $patient["FlagsDischargeScreen"];
$flagsTreatment = $patient["FlagsTreatment"];
$flagsReferral = $patient["FlagsReferral"];
$flagsDiagnostics = $patient["FlagsDiagnostics"];
$flagsBarriers = $patient["FlagsBarriers"];

$flagsDischargeScreenValid = (strpos($flagsDischargeScreen, '-') === false);
$flagsTreatmentValid = ($flagsTreatment == 'YYYY');
$flagsReferralValid = !((strpos($flagsReferral, ' ') !== false) || (strpos($flagsReferral, 'N') !== false) || (strpos($flagsReferral, 'Y') === false));
$flagsDiagnosticsValid = !((strpos($flagsDiagnostics, ' ') !== false) || (strpos($flagsDiagnostics, 'N') !== false) || (strpos($flagsDiagnostics, 'Y') === false));
$flagsBarriersValid = !((strpos($flagsBarriers, ' ') !== false) || (strpos($flagsBarriers, 'N') !== false) || (strpos($flagsBarriers, 'Y') === false));

$allFlagsValid = $flagsDischargeScreenValid && $flagsTreatmentValid && $flagsReferralValid && $flagsDiagnosticsValid && $flagsBarriersValid;

if (($Diagnosis1) && ($patient[Procedures]) && $allFlagsValid){ #if these completed, get injury data or discharge
	
#	if (ereg("^S.*|^T.*", $Diagnosis1)) { #if Diagnosis1 = trauma get injury data
		
#		if (($patient[InjuryNatureof]) && ($patient[InjuryBodyRegion]) && ($patient[InjuryPlace]) && ($patient[InjuryCause]) && ($patient[InjuryActivity]) && ($patient[InjuryIntent])) {
#		print '<TR><TD><HR size = 2 width = 90% >';
#		include('discharge.inc'); #if injury data complete, allow discharge
#		}else {}
#	print '<TR><TD><HR size = 2 width = 90% >';
#	include('injury.inc');
#	print '</TD></TR>';
#	}else{ #medical patient, but don't forget injury data if entered

	$hiddenar = array ("InjuryNatureof","InjuryBodyRegion","InjuryPlace","InjuryCause","InjuryActivity","InjuryIntent"
	#,"TransMode","TransHosp","TransEscort","TransReason"
	);
	hiddeninput ($hiddenar, $patient);

	print '<TR><TD><HR size = 2 width = 90%>';
	include('discharge.inc');
	print '</TD></TR>';
#	}
}else { #if procedures or diagnosis lost, don't forget injury or discharge data if entered

	$hiddenar = array ("InjuryNatureof","InjuryBodyRegion","InjuryPlace","InjuryCause","InjuryActivity","InjuryIntent","TransMode","TransHosp","TransEscort","TransReason","DischargedTo","TransHosp","DischargedStatus");
	hiddeninput ($hiddenar, $patient);
}

if ($patient[Doctor]) { #if seen by doctor, select diagnosis and procedures - added flags section (DJP, 06/07/2012)
	print '<TR><TD><HR size = 2 width = 90%>';
	include('flags.inc');
	print '</TD></TR>';

	print '<TR><TD><HR size = 2 width = 90%>';
	include('diagnosis.inc'); 
	print '</TD></TR>';	
	
	print '<TR><TD><HR size = 2 width = 90%>';
	$Procedures = $patient[Procedures];
	
	if($private){include('procedurespriv.inc');}
		else {include('procedures.inc');}
	print '</TD></TR>';
	
	

	}else {}


print "</TABLE></H5></FORM></TD><!-- window -->";
print "</TABLE></TD></TR></TABLE><!-- main table -->";
print "</CENTER><!-- Finish Main Table -->";

include('footer.inc'); ?>