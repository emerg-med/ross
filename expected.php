<?php 
require('common.inc');
include('header.inc'); 
include('navbar.inc');



print "<FORM action=\"triage.php\" method=\"post\" name=\"expected\">";

print"<CENTER><TABLE cellpadding =5 cellspacing=0 border=0 width=500><TR><TD width=30%>"; 

print "<TR><TD colspan=2><H1>Expected Patient</H1><BR></TD></TR>";


print "<TR><TD>First Name </TD><TD><input type=\"text\" name=\"FirstName\" size= \"30\" value=\"$arr_request[FirstName]\"><BR>";
print '</TD></TR>';

print "<TR><TD>Surname </TD><TD><input type=\"text\" name=\"Surname\" size= \"30\" value=\"$arr_request[Surname]\"><BR>";
print '</TD></TR>';


print "<TR><TD valign=top>Information </TD><TD><textarea name=\"TriageDiagnosis\" cols= \"30\" rows=\"3\" >$arr_request[TriageDiagnosis]</textarea><BR>";
print '</TD></TR>';

print "<TR><TD>Age (approx)</TD><TD><input type=\"text\" name=\"Age\" size= \"3\" value=\"$arr_request[Age]\"><BR>";
print '</TD></TR>';

print "<TR><TD>Sex </TD><TD><input type=\"radio\" name=\"Sex\" value=\"M\"";
if ($arr_request[Sex]== 'M') {print ' checked ';} else{}
print '>Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
print "<input type=\"radio\" name=\"Sex\" value=\"F\"";
if ($arr_request[Sex]== 'F') {print ' checked ';} else{}
print '>Female';
print '</TD></TR>';

print "<TR><TD></TD><TD>";
print "<input type = hidden  name='action' value='Add Expected'>";
print "<BR><input type = \"submit\" value= \"Add  to Expected\"><BR><BR><BR></TD></TR>";




print"</TABLE></CENTER>";


include('footer.inc'); 
?>