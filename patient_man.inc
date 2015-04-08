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


$triagetime = $row["TriageTimeStamp"];


## wait time in half hour segments - calc in seconds - adds two minutes (120 seconds)

$waittime = (int)((time() +  120 - $triagetime)/1800); #1800
	
#$waittime = (int)((time() +  120 - $triagetime)/(60*$triagecategory*($triagecategory - 1)));





print "<TD bgcolor=";
	#insert row of correct colour

	switch ($waittime){
		case '0': print '#99FF99'; break; # green 0 - 0.5 hour
		case '1': print '#FFFF99'; break; # green-yellow 0.5 - 1 hour
		case '2': print '#FFFF99'; break; # yellow 1 - 1.5
		case '3': print '#FFCC66'; break; # yellow/orange 1.5 - 2
		case '4': print '#FF9933'; break; # orange 2-2.5 hrs
		case '5': print '#FF8866'; break; # dark orange 2.5 - 3
		case '6': print '#FF8888'; break; # red 3-3.5
		case '7': print '#FF8888'; break; # red and flashing
		
		default : print '#666666'; break; # grey/black
	}

print '  VALIGN=TOP><A HREF="detail.php?key_ID='.$row[key_ID].'">';

print "<TABLE border = 0 cellpadding=2 cellspacing=0 border=0 width=100%><TR><TD><H6>$location</H6></TD><TD ALIGN=RIGHT><H6>";#table to hold top line

if (($row["TriagePosition"] == "1")&&(!$row["Doctor"])) {
	print '<IMG SRC="images/nexttosee.gif">';
	}

if ($waittime == "7") {
	print '<IMG SRC="/images/timeout5.gif">';
	}


$waittimehr = (int)((time() +  120 - $triagetime)/3600); 
$waittimemin = (int)((time() +  120 - $triagetime - 3600*$waittimehr)/60);
print "$waittimehr : $waittimemin</H6></TD></TR></TABLE></H6><H5";



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