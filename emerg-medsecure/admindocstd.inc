<?php 
 

print"<CENTER><TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

print "<TR><TD colspan=2>";
print "";
print "<BR><B>$resultar[Name] - Welcome to the medical administration menu</B><BR>";
print "</TD></TR>";

print "<TR><TD colspan=2>";
print "";
print "<H6><FONT COLOR=\"FF0000\">Close this window when you have finished</FONT></H6>";
print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/medhelpedit.php?login=084eruthrhjgoj94h7923Yw9q78&user=$resultar[Name]');\"><SPAN class='bluebutton' >Edit&nbsp;help&nbsp;&nbsp;</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the medhelp pages";

print "</TD></TR>";

print "<TR><TD>";
print "<H5><A HREF=\"javascript:popupwindow('/message.php?user=$resultar[Name]');\"><SPAN class='redbutton' >Edit&nbsp;Message</SPAN></A></H5>";
print "</TD><TD>";
print "Edit the message shown to the Waiting room";

print "</TD></TR>";

print "<TR><TD>";
print "";
print "</TD><TD>";
print "";

print "</TD></TR>";


print"</TABLE></CENTER><BR><BR><BR>"; 

?>