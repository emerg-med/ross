<?php 
include ('wwwheader.inc');
print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";
print "<TR><TD></TD></TR>";
print "<TR><TD ALIGN=LEFT VALIGN=bottom><IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"emerg-med.com\"></TD></TR>";

print "<TR><TD bgcolor=000000 ><FONT SIZE=1>&nbsp;</FONT></TD></TR>";
#<HR color='#000000' size=10>
print "<TR><TD><FONT SIZE=\"+1\" ><BR>Why can't I see the menu bar ?</FONT><BR><BR>";

print "This site uses a menubar written in java.<BR>
Some web browsers have problems with java - either they do not fully support it or they have bugs in their implementation.<BR><BR>
This includes Microsoft Internet Explorer 6+, which can download java from <A HREF=\"javascript:popupwindow('http://java.sun.com/getjava/download.html');\">here</A>
<BR><BR>
If your browser does not work on this site, and you want to upgrade, we strongly recommend <A HREF=\"javascript:popupwindow('http://www.mozilla.org/');\">Mozilla</A>. It's free, fast, and doesn't try to harvest your personal details or sign you up with services you do not want/ need.<BR>
<BR>
In the meantime, here are the other pages:


<UL>
<LI><A HREF=\"\">Start emerg-meds</A>
<LI><A HREF=\"wwwdisplay.php?text=emerg-medfeatures\">What is a emerg-med.com?</A>

<LI><A HREF=\"wwwdisplay.php?text=recordingprogress\">Emergency medicine</A>
<LI><A HREF=\"wwwdisplay.php?text=theory\">Theory and Practice</A>
<LI><A HREF=\"wwwdisplay.php?text=background\">Background to emerg-med.com</A>
<LI><A HREF=\"wwwdisplay.php?text=goals\">Goals of emerg-med.com</A>
<LI><A HREF=\"wwwdisplay.php?text=progress\">Progress of emerg-med.com</A>

<LI><A HREF=\"wwwdisplay.php?text=help\">How you can help the emerg-med project</A>

<LI><A HREF=\"wwwdisplay.php?text=legal\">Disclaimer</A>
<LI><A HREF=\"wwwdisplay.php?text=privacy\">Privacy</A>

<LI><A HREF=\"wwwdisplay.php?text=serverwhat\">emerg-med server - what does it do?</A>
<LI><A HREF=\"wwwdisplay.php?text=serverwork\">emerg-med server - how does it work</A>
<LI><A HREF=\"wwwdisplay.php?text=emerg-medanalysis\">emerg-med server - why was it developed</A>
<LI><A HREF=\"wwwdisplay.php?text=whysetup\">emerg-med server - why set up your own server</A>
<LI><A HREF=\"wwwdisplay.php?text=req\">emerg-med server - server requirements</A>
<LI><A HREF=\"wwwdisplay.php?text=setup\">emerg-med server - server setup</A>
<LI><A HREF=\"wwwdisplay.php?text=serverdl\">emerg-med server - download now</A>

<LI><A HREF=\"wwwdisplay.php?text=oss\">emerg-med system - how much does it cost? - open source software</A> 
<LI><A HREF=\"wwwdisplay.php?text=free\">emerg-med system - how much does it cost? - how free is free?</A>
<LI><A HREF=\"wwwdisplay.php?text=licence\">emerg-med system - how much does it cost? - licence</A>
<LI><A HREF=\"wwwdisplay.php?text=licencewhybuy\">emerg-med system - how much does it cost? - why buy a licence?</A>
<LI><A HREF=\"wwwdisplay.php?text=licencecosts\">emerg-med system - how much does it cost? - licence costs</A>
<LI><A HREF=\"wwwdisplay.php?text=emerg-medwindows\">System server setup - emerg-med on windows</A>

<LI><A HREF=\"wwwdisplay.php?text=contact\">Contact us</A>

</UL>
</TD></TR>
";


print "<TR><TD><CENTER><FONT SIZE=1>&copy; copyright 1999-".(date("Y"))." emerg-med.org. All rights reserved.</FONT></CENTER>";
print "</TD></TR></TABLE></CENTER></BODY></HTML>";
ob_end_flush(); 
?>