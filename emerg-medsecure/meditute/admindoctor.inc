<?php 
 

print"<BLOCKQUOTE><CENTER><TABLE width=98% cellspacing='5' cellpadding = '5' border='0' >";

print "<TR><TD colspan=2>";
print "";
print "<BR><B>$resultar[Name] - Welcome to the medical administration menu</B><BR>";
print "</TD></TR>";

print "<TR><TD colspan=2>";
print "";
print "<H6>If you give a non-administrator doctor a username and password, they can change the help files, and the waiting room message text</H6>";
print "<H6><FONT COLOR=\"FF0000\">Close this window when you have finished</FONT></H6>";
print "</TD></TR>";


print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/users.php?login=084eri320ut08dh7923Yw9q78&user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;Users</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the details of the doctors using the system";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/medhelpedit.php?login=084eruthrhjgoj94h7923Yw9q78&user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;help</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the medhelp pages";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/undischarge.php?user=$resultar[Name]');\"><SPAN class='bluebutton' >Undischarge</SPAN></A></H5>";
print "</TD><TD>";
print "Undischarges a patient discharged in the previous 12 hours";
print "</TD></TR>";

if ($private){
	print "<TR><TD>";
	print "<H5><A HREF=\"javascript:popupwindow('/facilityfee.php?user=$resultar[Name]');\"><SPAN class='greenbutton' >Facility&nbsp;Fee</SPAN></A></H5>";
	print "</TD><TD>";
	print "Change the Facility Fee";
	print "</TD></TR>";
	}

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/message.php?user=$resultar[Name]');\"><SPAN class='redbutton' >Edit&nbsp;Message</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the message shown to the Waiting room";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/alerts.php?user=$resultar[Name]');\"><SPAN class='redbutton' >Edit&nbsp;Alerts</SPAN></A></H5>";
print "</TD><TD>";
print "Edit Alerts";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/quality.php?user=$resultar[Name]');\"><SPAN class='bluebutton' >Quality</SPAN></A></H5>";
print "</TD><TD>";
print "Review quality submissions";
print "</TD></TR>";


print "<TR><TD>";
print "";
print "</TD><TD>";
print "";
print "</TD></TR>";


print"</TABLE></CENTER></BLOCKQUOTE><BR><BR><BR>"; 

?>