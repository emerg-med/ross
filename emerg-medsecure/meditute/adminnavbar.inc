<?php
### http://<?php print $hostname; 

print "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\" HEIGHT=\"15\" BGCOLOR=\"#000000\">";

print "<TR>";
print "<TD><A HREF=\"http://$hostname/index.php\" onmouseover=\"imgOn('img1')\" onmouseout=\"imgOff('img1')\"><IMG SRC=\"images/homei.gif\" NAME=\"img1\" ALT=\"Home\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" NAME=\"img2\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" NAME=\"img3\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" NAME=\"img4\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" ALT=\"\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" NAME=\"img6\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><IMG SRC=\"images/blank.gif\" NAME=\"img7\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></TD>";

print "<TD><A HREF=\"mailto:$administrator_email\"; \" onmouseover=\"imgOn('img8')\" onmouseout=\"imgOff('img8')\"><IMG SRC=\"images/contacti.gif\" NAME=\"img8\" ALT=\"Contact the Administrator\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"javascript:popupwindow('http://$hostname/medhelp.php?medhelp_search=$patient[TriageNurseCode]');\" onmouseover=\"imgOn('img9');\" onmouseout=\"imgOff('img9')\"><IMG SRC=\"images/helpi.gif\" NAME=\"img9\" ALT=\"Help\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "</TR>";
print "</TABLE>";
?>