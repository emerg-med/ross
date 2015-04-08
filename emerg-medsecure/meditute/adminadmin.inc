<?php 

print"<CENTER><TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

print "<TR ><TD colspan=2 width = 100%>";
print "";
print "<BR><B>$resultar[Name]&nbsp;- Welcome&nbsp;to&nbsp;the&nbsp;system&nbsp;administrator's&nbsp;menu</B><BR>";
print "</TD></TR>";

print "<TR><TD colspan=2>";
print "";
print "<H6><FONT COLOR=\"FF0000\">Close this window when you have finished</FONT></H6>";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/users.php?login=084eri320ut08ah7923Yw9q78&user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;Users&nbsp;&nbsp;</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the details of all system users";

print "</TD></TR>";


print "<TR><TD>";
print "<H5><SPAN class='greenbutton' >Edit&nbsp;Triage</SPAN></H5>";
print "</TD><TD>";
print "";
print "</TD></TR>";


print "<TR><TD colspan =2><HR><HR></TD></TR>";## break above serious functions



print "<TR><TD>";
print "<H5><SPAN class='redbutton' >Delete Doctors</SPAN></H5>";
print "</TD><TD>";
print "Deletes all non-current Doctors (speeds up loading of some pages)";
print "</TD></TR>";


print "<TR><TD>";
print "<H5><SPAN class='redbutton' >Delete Nurses</SPAN></H5>";
print "</TD><TD>";
print "Deletes all non-current Nursing staff (speeds up loading of some pages)";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><SPAN class='redbutton' >Delete Clerical</SPAN></H5>";
print "</TD><TD>";
print "Deletes all non-current Clerical staff (speeds up loading of some pages)";
print "</TD></TR>";

print"</TABLE></CENTER><BR><BR><BR>"; 

?>