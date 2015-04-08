<?php 
require('common.inc');

#print phpinfo();


##### Setup arrays 

$str_sql = "SELECT Name FROM User WHERE UserType LIKE '%N%' AND Current = 'Yes' ORDER BY Name";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQLname triage Select Execution has failed.');} 
$nurselist = array ();
$dummy='0';
while ($nurse =  mysql_fetch_array($result)){
$nurselist[$dummy] = $nurse[Name];
$dummy++;
}


$str_sql = "SELECT Diagnosis, Code FROM Canadian ORDER BY Diagnosis";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL triage diagnosis Select Execution has failed.');} 
$triagenursecodelist = array ();
$dummy='0';
while ($triage =  mysql_fetch_array($result)){
$triagenursecodelist[$dummy] = $triage[Code] . '{' . $triage[Diagnosis];
$dummy++;
}

#####  Do things

if ($arr_request['action']==Help){
	include('triagehelp.inc');
	}

elseif ($arr_request['action']==Triage){ #insert new patient into database
	include('newtriage.inc'); 
	$arr_request = array();
	$default = "yes";
	} 

elseif ($arr_request['action']==triageup){
	$direction = 'up';
	include('triageposition.inc');
	$default = "yes";
	}

elseif ($arr_request['action']==triagedown){
	$direction = 'down';
	include('triageposition.inc');
	$default = "yes";
	}

elseif ($arr_request['NewTriageCategory']){
	$default = "";
	}

elseif ($arr_request['action'] == 'Add Expected'){
	
	$default = "yes";

	##### get variables off array

	$TriageDiagnosis = cleanup($arr_request['TriageDiagnosis']);
	$FirstName = ucfirst(cleanup($arr_request['FirstName']));
	$Surname = ucfirst(cleanup($arr_request['Surname']));
	$Age = cleanup($arr_request['Age']);
	$Sex = $arr_request['Sex'];

	##### insert into expected
	$str_sql = "insert into Expected 
	( TriageDiagnosis,  FirstName, Surname, Age, Sex)
	VALUES 
	( '$TriageDiagnosis',  '$FirstName', '$Surname', '$Age', '$Sex' )";
			
	$result = mysql_db_query($dbname, $str_sql, $id_link);

	if (! $result) {
	affy_error_exit('SQL Select Execution has failed.');
	}
	else{}

	$arr_request = array('');

	}


elseif ($arr_request['action'] == 'expectedarrive'){
		$default = "yes";


		##### delete from expected
		$str_sql = "DELETE FROM Expected WHERE Key_ID = $arr_request[Key_ID]";
		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) {
		affy_error_exit("$str_sql SQL delete from expected triage Execution has failed.");
		}else{}
		
	}

else{
	$default = "yes";
	}


$allowcache = "Y";
# $refresh="70";
include('header.inc');
include('navbar.inc'); 


print"<CENTER>";##### Start Main Table

print"<TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD>";##### main table 
print"<FORM action=\"triage.php\" method=\"post\" name=\"triageform\">"; ##?action=Triage

print"<TABLE cellpadding=1 cellspacing=1 border=3 width=100%>";##### 2 side by side windows 

print"<TR>";#####                       window 1 
print"<TD width=20% valign=top bgcolor=$bgcolor>";


print"<CENTER><H2>Triage</H2></CENTER>";


##### get all non-seen patients

$str_sql = "SELECT * FROM Patients WHERE Doctor = '' ORDER BY TriagePosition";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$num_waiting = mysql_num_rows ($result);


print '<TABLE cellpadding=0 cellspacing=1 border=0 width=100%  >';#table to hold patients

while ($row = mysql_fetch_array($result)){##### list of all patients

	print '<TR><TD width=100% bgcolor=';##### insert row of correct colour
	$triagecat = $row["TriageCategory"];

	switch ($triagecat){
		case '1': print "$triage1colour"; break;
		case '2': print "$triage2colour"; break;
		case '3': print "$triage3colour"; break;
		case '4': print "$triage4colour"; break;
		case '5': print "$triage5colour"; break;
		default : print "$triage6colour"; break;
	}
	print ' VALIGN=TOP><TABLE cellpadding=0 cellspacing=0 border=0 width=100%><TR><TD>';
	if ($row["TriagePosition"] > '1') { 
	print "<A HREF=\"triage.php?action=triageup&key_ID=$row[key_ID]&TriagePosition=$row[TriagePosition]\">";
	print '<IMG SRC="images/triageup.gif" WIDTH="10" HEIGHT="10" BORDER="0"></A>';
		}
	else {print '<IMG SRC="images/dummy.gif" height="10" width="10">';}
	
	if ($triagecat!='1') {
		$waittime = (int)((time() +  120 - $row['TriageTimeStamp'])/(60*$triagecat*($triagecat - 1)));

		if ($waittime > '6' ){$waittime = '6' ;} 
		else{}

		print '</TD><TD ALIGN=RIGHT ><IMG SRC="images/timeout' . $waittime. '.gif"></TD></TR></TABLE>';

		}
	else{$waittime = '6' ;
		print '</TD><TD ALIGN=RIGHT ><IMG SRC="images/timeout' . $waittime. '.gif"></TD></TR></TABLE>';
		}


	print'<A HREF="detail.php?key_ID='.$row[key_ID].'">';##### link to detail screen
	$agelen=(strpos($row["Age"],32)+2);#cut down to m or d 
	print '<H5>&nbsp;'.$row["FirstName"]." <B>".$row["Surname"]."</B>, &nbsp;&nbsp;&nbsp;".substr($row["Age"],0,$agelen);
	print '</A></H5>';
	if ($row["TriagePosition"] < $num_waiting) {print "<A HREF=\"triage.php?action=triagedown&key_ID=$row[key_ID]&TriagePosition=$row[TriagePosition]\">";
	print '<IMG SRC="images/triagedown.gif" WIDTH="10" HEIGHT="10" BORDER="0">';
		}
	else {print '<IMG SRC="images/dummy.gif" height="10">';}
	print '</TD></TR>';
}

print '</TABLE>';




print"</TD>";#####                             window 1 
###############################################
print"<TD width=60% valign=top>";#####         window 2

print"<H1><TABLE cellpadding =5 cellspacing=0 border=0 width=100%><TR><TD width=30%>"; 




if ($default){
	$triagetimestampar = getdate();
	print "<INPUT TYPE=\"hidden\" name = \"TriageTimeStamp\" value = '".time()."'>";
	}
	else {
	$triagetimestampar = getdate($arr_request[TriageTimeStamp]);
	print "<INPUT TYPE=\"hidden\" name = \"TriageTimeStamp\" value = '".$arr_request[TriageTimeStamp]."'>";
	}


print "Triage Date </TD><TD width=70%>";

print $triagetimestampar[mday];
print "&nbsp;<B>/</B>&nbsp;";

print $triagetimestampar[mon];
print "&nbsp;<B>/</B>&nbsp;";

print $triagetimestampar[year];
print "&nbsp;";

print '</TD></TR><TR><TD>';


print 'Triage Time </TD><TD>';
print $triagetimestampar[hours];
print "&nbsp;<B>:</B>&nbsp;";

if ($triagetimestampar[minutes]<10){
print "0";
	}
print $triagetimestampar[minutes];
print "&nbsp;&nbsp;";
print '</TD></TR>';


print "<TR><TD>Triage Nurse </TD><TD>";
dropdownbox2 ($nurselist, "TriageNurse", $arr_request[TriageNurse]);
print '</TD></TR>';

print "<TR><TD>First Name </TD><TD><input type=\"text\" name=\"FirstName\" size= \"30\" value=\"".stripslashes($arr_request[FirstName])."\"><BR>";
print '</TD></TR>';

print "<TR><TD>Surname </TD><TD><input type=\"text\" name=\"Surname\" size= \"30\" value=\"".stripslashes($arr_request[Surname])."\"><BR>";
print '</TD></TR>';

print '<TR><TD>Triage Code </TD><TD>';
codedropdownbox($triagenursecodelist, "TriageNurseCode", $arr_request[TriageNurseCode]);
print '</TD></TR>';

print "<TR><TD>Triage Category </TD><TD>";
if ($default=="yes"){$arr_request[NewTriageCategory]="4";}
dropdownbox ($triagecatlist, "TriageCategory", $arr_request[NewTriageCategory]);

print "&nbsp;&nbsp;&nbsp;".$arr_request[TriageCategory];

#print "<input type = \"submit\" name = \"action\" value= \"Help\">";



print '</TD></TR>';



print "<TR><TD valign=top>Triage Diagnosis </TD><TD><textarea onKeyPress=\"return ( this.value.length < 100 );\" onPaste=\"return (( this.value.length + window.clipboardData.getData('Text').length) < 100 );\" name=\"TriageDiagnosis\" cols= \"30\" rows=\"3\" >".stripslashes($arr_request[TriageDiagnosis])."</textarea><BR>";
print '</TD></TR>';

print "<TR><TD>Location </TD><TD>";
dropdownbox ($locationlist, "Location", $arr_request[Location]);
print "<BR></TD></TR>";

print "<TR><TD>Age (approx)</TD><TD><input type=\"text\" name=\"Age\" size= \"3\" value=\"$arr_request[Age]\"><BR>";
print '</TD></TR>';

print "<TR><TD>Sex </TD><TD><input type=\"radio\" name=\"Sex\" value=\"M\"";
if ($arr_request[Sex]== 'M') {print ' checked ';} else{}
print '>Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
print "<input type=\"radio\" name=\"Sex\" value=\"F\"";
if ($arr_request[Sex]== 'F') {print ' checked ';} else{}
print '>Female';
print '</TD></TR>';

print "<TD></TD><TD>";

print "<input type = \"submit\" name = \"action\" value= \"Triage\">";

print "&nbsp;&nbsp;<INPUT TYPE=\"reset\"></FORM>";
print '</TD></TR></TABLE>';


print"</TD>";##### window 2 
##########################################
print"<TD width=20% valign=top bgcolor=$bgcolor>";### window 3

$str_sql = "SELECT * FROM Expected ORDER BY Key_ID"; ##get all expected patients
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}


print '<TABLE cellpadding=0 cellspacing=1 border=0 width=100%  >';#table to hold expected
print "<TR><TD>";
print"<CENTER><H2>Expected&nbsp;&nbsp;<A HREF=\"expected.php\"><IMG SRC=\"images/arrivals.gif\" ALT= \"Expected patients\"></A></H2></CENTER>";
print"</TD></TR>";

while ($row = mysql_fetch_array($result)){##### list of all expected

	print "<TR><TD  bgcolor='#FFFFCC'>";
	print "<A HREF=\"triage.php?action=expectedarrive&Key_ID=$row[Key_ID]&FirstName=$row[FirstName]&Surname=$row[Surname]&Sex=$row[Sex]&Age=$row[Age]&TriageDiagnosis=$row[TriageDiagnosis]\">";
	print"<H6><B>$row[Surname]</B>, $row[FirstName] &nbsp; $row[Sex],&nbsp;$row[Age]<BR>$row[TriageDiagnosis]</H6></A>";
	print"</TD></TR>";
	}

print "<TR><TD>";

print"</TD></TR>";
print"</TABLE>";##### window 3

print"</TD></TR>";
print"</TABLE>";##### 2 side by side windows	
print"</TD></TR></TABLE>";##### main table
print"</CENTER>";##### Finish Main Table

include('footer.inc'); 