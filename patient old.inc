<?php 
print "<TD $tableformat VALIGN=TOP>";
# table to hold all patients for that cell 
print '<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><TR><TD VALIGN=TOP>';


#get patients for this cell   
$str_sql = "SELECT key_ID,TriageCategory,TriageTimeStamp,TriagePosition,Doctor,FirstName,Surname,Age,TriageDiagnosis,StatusReport FROM Patients WHERE Location = '$location' ORDER BY TriageCategory" ;
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

if (!$row["Doctor"]) {        #if not seen display lights
	
	

	if ($triagecategory!='1') {
	$waittime = (int)((time() +  120 - $triagetime)/(60*$triagecategory*($triagecategory - 1)));
		if ($waittime > '6' ){$waittime = '6' ;} 
		else{}

		print '<IMG SRC="images/timeout' . $waittime. '.gif">';

	}
	else{$waittime = '6' ;

	print '<IMG SRC="images/timeout' . $waittime. '.gif">';
	}

if ($row["TriagePosition"] == "1") {
	print '<IMG SRC="images/nexttosee.gif">';
	}

print '</H6></TD></TR></TABLE></H6><H5';


}
else {print $row["Doctor"] . '</H6></TD></TR></TABLE></H6><H5';}


print '>&nbsp;'.$row[FirstName]." <B>".$row["Surname"]."</B>, &nbsp;&nbsp;&nbsp;".$row["Age"]."<BR>";

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