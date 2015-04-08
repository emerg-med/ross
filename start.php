<?php 
#phpinfo();
#require('common.inc');

include ('wwwheader.inc');

print "";

print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";


print "<TR><TD>";
print "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
print "</TD></TR>";


print "<TR><TD ALIGN=RIGHT VALIGN=bottom>&nbsp;<IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"emerg-med.com\"><IMG SRC=\"images/logo1.gif\" BORDER=0 ALT=\"emerg-med.com\"></TD></TR>";#

include ('wwwnavbar.inc');



print "<TR><TD>";
print "<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";
print "</TD></TR>";

print "<TR><TD>";
print "<CENTER><FONT SIZE=1>&copy; copyright 1999-".(date("Y"))." emerg-med.com. All rights reserved.</FONT></CENTER>";
#print "</TD></TR>";

#print "<TR><TD>";
print "<CENTER><FONT SIZE=1>This site requires a browser version >4.7 (Windows XP/IE6 needs java from <A HREF=\"javascript:popupwindow('http://java.sun.com/getjava/');\">here</A>) with Java, Javascript and cookies enabled.</FONT></CENTER>";
print "</TD></TR>";

print "</TABLE></CENTER>";
print "</BODY>";
print "</HTML>";

ob_end_flush(); 
?>