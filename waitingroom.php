<?php 
/*
# get text from database

$str_sql = "SELECT text FROM WaitingRoom WHERE key_ID=1";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$waittext = mysql_fetch_array($result))

*/

require('common.inc');
$refresh = "90";
$str_sql = " SELECT Text1  FROM Setup WHERE Name='Message'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$resultar = mysql_fetch_array($result);

#$resultar[text1]="Do not have anything to eat or drink until you have seen the doctor, in case you need an operation. Remember that patients are seen in order of urgency, NOT in the order in which they arrived. Think about it - if you had a heart attack, you would want to be seen first. The closer to the top of the list you are, the sooner you will be seen.";

include('header.inc'); 

print "<CENTER><H1>PATIENTS WAITING TO BE SEEN</H1><BR>";

print "<applet codebase=\"java/\" code=\"iscroll.class\" width=\"600\" height=\"30\"><param name=\"Notice\" value=\"Applet by www.CodeBrain.com\">";

print "<param name=\"Text\" value='$resultar[Text1]'>\n";

print '<param name="TextColor" value="#FF3030"><param name="TextLinkColor"     value="#00FF00"><param name="VerticalBias" value="0"><param name="FontName" value="Helvetica"><param name="FontStyle" value="0"><param name="Link"   value="http://www.emerg-med.com"><param name="Target" value="_new"><param name="Speed"  value="5"><param name="Pause" value="1000"><param name="BackgroundColor" value="#F6F6F6"><param name="MouseMode" value="0"><param name="StatusBarText"     value="Turn the status bar off"></applet>';



print "</CENTER><BR>\n";


##### get all non-seen, non-DOA patients

$str_sql = "SELECT * FROM Patients WHERE (Doctor = '') AND (TriageCategory < 6)ORDER BY TriagePosition";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

$num_waiting = mysql_num_rows ($result);


print '<CENTER><TABLE cellpadding=2 cellspacing=0 border=0 width=80%>';

while ($row = mysql_fetch_array($result)){##### list of all patients

	print '<TR bgcolor=';##### insert row of correct colour
	$triagecat = $row["TriageCategory"];

	switch ($triagecat){
		case '1': print "$triage1colour"; break;
		case '2': print "$triage2colour"; break;
		case '3': print "$triage3colour"; break;
		case '4': print "$triage4colour"; break;
		case '5': print "$triage5colour"; break;
		default : print "$triage6colour"; break;
	}

	print ' ><TD WIDTH 10%>&nbsp;</TD><TD WIDTH = 40% VALIGN=TOP ALIGN = CENTER><H1><B>';
	
	


	print substr($row["FirstName"], 0,1)."&nbsp;".substr($row["Surname"], 0,1)."</B></H1></TD><TD WIDTH = 45%><H1><B>".$row["Location"];


	print "</B></H1></TD></TR>\n";
}

print '</TABLE></CENTER>';

print "<BR><BR><CENTER><TABLE cellpadding=5 cellspacing=5 border=0 width=80%><TR>";
print "<TD WIDTH= 20% bgcolor=$triage1colour><CENTER><H4>Most<BR>Urgent</H4></CENTER></TD>";
print "<TD WIDTH= 20% bgcolor=$triage2colour>&nbsp;</TD>";
print "<TD WIDTH= 20% bgcolor=$triage3colour>&nbsp;</TD>";
print "<TD WIDTH= 20% bgcolor=$triage4colour>&nbsp;</TD>";
print "<TD WIDTH= 20% bgcolor=$triage5colour><CENTER><H4>Least<BR>Urgent</H4></CENTER></TD>";

print "</TR></TABLE></CENTER>";
print '</BODY></HTML>';



 
 
?>