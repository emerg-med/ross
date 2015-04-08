<?php 
print "<TD $tableformat VALIGN=TOP>";
# table to hold all patients for that cell 
print '<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><TR><TD VALIGN=TOP>';


#get patients for this cell   
$str_sql = "SELECT key_ID,TriageCategory,TriageTimeStamp,TriagePosition,Doctor,FirstName,Surname,Age,TriageDiagnosis,StatusReport,FlagsDischargeScreen,FlagsTreatment,FlagsReferral,FlagsDiagnostics,FlagsBarriers FROM Patients WHERE Location = '$location' ORDER BY TriageCategory" ;
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed.');}

if (mysql_num_rows($result)!=0) {

#fetch each array
while ($row = mysql_fetch_array($result)){

#table to hold individual patient details
print '<TABLE cellpadding=0 cellspacing=0 border=1 width=100%><TR>';

$triagecategory = $row["TriageCategory"];
$triagetime = $row["TriageTimeStamp"];

print "<TD bgcolor=";
	#insert row of correct colour

	switch ($triagecategory){
		case '1': print "$triage1colour"; break;
		case '2': print "$triage2colour"; break;
		case '3': print "$triage3colour"; break;
		case '4': print "$triage4colour"; break;
		case '5': print "$triage5colour"; break;
		default : print "$triage6colour"; break;
	}

print '  VALIGN=TOP><A HREF="detail.php?key_ID='.$row[key_ID].'">';

print "<TABLE border = 0 cellpadding=2 cellspacing=0 border=0 width=100%><TR><TD><H6>$location</H6></TD><TD ALIGN=RIGHT><H6>";#table to hold top line

print $row["Doctor"]."</H6></TD></TR>";

print "<TR><TD ALIGN=LEFT>";

if (strpos($row["FlagsDischargeScreen"], '-') === false) {
	print '<IMG SRC="images/flaggreen.gif"></IMG>';
} else {
	print '<IMG SRC="images/flagred.gif"></IMG>';
}

if ($row["FlagsTreatment"] == "YYYY") {
	print '<IMG SRC="images/flaggreen.gif"></IMG>';
} else {
	print '<IMG SRC="images/flagred.gif"></IMG>';
}

$flagsReferral = $row["FlagsReferral"];

if ((strpos($flagsReferral, ' ') !== false) || (strpos($flagsReferral, 'N') !== false) || (strpos($flagsReferral, 'Y') === false)) {
	print '<IMG SRC="images/flagred.gif"></IMG>';
} else {
	print '<IMG SRC="images/flaggreen.gif"></IMG>';
}

$flagsDiagnostics = $row["FlagsDiagnostics"];

if ((strpos($flagsDiagnostics, ' ') !== false) || (strpos($flagsDiagnostics, 'N') !== false) || (strpos($flagsDiagnostics, 'Y') === false)) {
	print '<IMG SRC="images/flagred.gif"></IMG>';
} else {
	print '<IMG SRC="images/flaggreen.gif"></IMG>';
}

$flagsBarriers = $row["FlagsBarriers"];

if ((strpos($flagsBarriers, ' ') !== false) || (strpos($flagsBarriers, 'N') !== false) || (strpos($flagsBarriers, 'Y') === false)) {
	print '<IMG SRC="images/flagred.gif"></IMG>';
} else {
	print '<IMG SRC="images/flaggreen.gif"></IMG>';
}

print "</TD><TD ALIGN=RIGHT>";

# $waittime = (int)((time() +  120 - $triagetime)/1800); #1800

if (strpos($location, 'AAU') === 0) {
	$waittime = 1 + floor((5.0 * (time() - $triagetime)) / 43201.0);
} else {
	# $waittime = 1 + floor((5.0 * (time() - $triagetime)) / 172801.0);
	$waittime_delta =  time() - $triagetime;

	if ($waittime_delta > 259200.0) {		# 60*60*24*3 - i.e. 3 days in seconds
		$waittime = 3 + ceil(($waittime_delta - 259200.0) / 172800.0);	# 3 + number of elapsed two-day periods, rounding up
	} else {
		$waittime = ceil($waittime_delta / 86400.0);	# number of elapsed one-day periods, rounding up
	}
}

if ($waittime < 1 ){$waittime = 1 ;} 
if ($waittime > 6 ){$waittime = 6 ;} 

print '<IMG SRC="images/timeout' . $waittime. '.gif"></IMG>';

print "</TD></TR>";

print "</TABLE></H6>";

print '<H5>&nbsp;'.$row[FirstName]." <B>".$row["Surname"]."</B>, &nbsp;&nbsp;&nbsp;".$row["Age"]."<BR>";

print '<H6>&nbsp;'.substr($row[TriageDiagnosis], 0,40).'</H6>';


if ($row["StatusReport"]!='') {print '<H6 class="blue">&nbsp;'.$row["StatusReport"].'</H6>';}

print '</H5></A>';

#close individual patient table
print '</TD></TR></TABLE>';

} #end while statement

} #end if statement

else { #blank space if no patient
if ($location=="Waiting Room") {$location="No one in waiting room!";}
print "<H6>&nbsp;$location &nbsp;</H6>";
print '<H5>&nbsp;<BR>&nbsp;</H5>';
	}

#close cell table
print '</TD></TR></TABLE></TD>';
?>