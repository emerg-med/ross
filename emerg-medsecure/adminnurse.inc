<?php 

print"<CENTER><TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

print "<TR><TD colspan=2>";
print "";
print "<BR><B>$resultar[Name] - Welcome to the nursing administration menu</B><BR>";
print "</TD></TR>";

print "<TR><TD colspan=2>";
print "";
print "<H6>If you give a non-administrator nurse a username and password, they can change the triage help files, and the waiting room message text</H6>";
print "<H6><FONT COLOR=\"FF0000\">Close this window when you have finished</FONT></H6>";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('users.php?login=084eri320ut08nh7923Yw9q78&user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;Users&nbsp;&nbsp;</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the details of the nurses using the system";

print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('triagehelpedit.php?user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;Triage&nbsp;Codes&nbsp;&nbsp;</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the codes available for triage and the flow diagrams";

print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('currentpatients.php?user=$resultar[Name]');\"><SPAN class='greenbutton' >Edit&nbsp;Triage</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the triage details of patients still in the department";

print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('message.php?user=$resultar[Name]');\"><SPAN class='redbutton' >Edit Message</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the message shown to the Waiting room";

print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('undischarge.php?user=$resultar[Name]');\"><SPAN class='bluebutton' >Undischarge</SPAN></A></H5>";
print "</TD><TD>";
print "Undischarges a patient discharged in the previous 12 hours";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('quality.php?user=$resultar[Name]');\"><SPAN class='bluebutton' >Breach/ Quality</SPAN></A></H5>";
print "</TD><TD>";
print "Review breach/quality submissions";
print "</TD></TR>";

print "<TR><TD>";
print "";
print "</TD><TD>";
print "";

print "</TD></TR>";


print"</TABLE></CENTER><BR><BR><BR>"; 

?>