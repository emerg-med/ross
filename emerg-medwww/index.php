<?php 
include ('wwwheader.inc');
print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";
print "<TR><TD><BR><BR><BR><BR><BR><BR><BR><BR></TD></TR>";
print "<TR><TD ALIGN=RIGHT VALIGN=bottom><IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"emerg-med.com\"><BR>";
include ('wwwnavbar.inc');
print "</TD></TR>";


print "<TR><TD><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CENTER>";

print "</CENTER></TD></TR>";
print "<TR><TD><CENTER><FONT SIZE=1>&copy; copyright 1999-".(date("Y"))." emerg-med.com. All rights reserved.</FONT></CENTER>";
print "<CENTER><FONT SIZE=1><A HREF=\"browsers.php\">Click here if you cannot see the menu bar above.</A> .</FONT></CENTER></TD></TR></TABLE></CENTER>";

print "</BODY></HTML>";
ob_end_flush(); 
?>