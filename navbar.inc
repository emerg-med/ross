<?php
### http://<?php print $hostname; 

print "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\" HEIGHT=\"15\" BGCOLOR=\"#000000\">";

print "<TR>";
# print "<TD><A HREF=\"./index.php\" onmouseover=\"imgOn('img1')\" onmouseout=\"imgOff('img1')\"><IMG SRC=\"images/homei.gif\" NAME=\"img1\" ALT=\"Home\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"./triage.php\" onmouseover=\"imgOn('img2')\" onmouseout=\"imgOff('img2')\"><IMG SRC=\"images/triagei.gif\" NAME=\"img2\" ALT=\"Triage\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"./reg.php\" onmouseover=\"imgOn('img3')\" onmouseout=\"imgOff('img3')\"><IMG SRC=\"images/regi.gif\" NAME=\"img3\" ALT=\"Registration\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"./phone.php\" onmouseover=\"imgOn('img4')\" onmouseout=\"imgOff('img4')\"><IMG SRC=\"images/phonei.gif\" NAME=\"img4\" ALT=\"Phone Directory\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"$PHP_SELF?key_ID=$key_ID\"><IMG SRC=\"images/timebar.gif\" ALT=\"\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"./index_SSU.php\" onmouseover=\"imgOn('img6')\" onmouseout=\"imgOff('img6')\"><IMG SRC=\"images/viewi.gif\" NAME=\"img6\" ALT=\"SSU View\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"./index_SSU2.php\" onmouseover=\"imgOn('img11')\" onmouseout=\"imgOff('img11')\"><IMG SRC=\"images/viewi2.gif\" NAME=\"img6\" ALT=\"SSU-2 View\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><A HREF=\"javascript:popupwindow('$securebase/admin.php?login=n');\" onmouseover=\"imgOn('img7')\" onmouseout=\"imgOff('img7')\"><IMG SRC=\"images/admini.gif\" NAME=\"img7\" ALT=\"Administrator\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "<TD><IMG SRC=\"images/contacti.gif\" ALT=\"\" HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></IMG></TD>";

print "<TD><A HREF=\"javascript:popupwindow('./medhelp.php?medhelp_search=$patient[TriageNurseCode]');\" onmouseover=\"imgOn('img9');\" onmouseout=\"imgOff('img9')\"><IMG SRC=\"images/helpi.gif\" NAME=\"img9\" ALT=\"Help\" BORDER=0 HEIGHT=15 WIDTH=60 ALIGN=BOTTOM></A></TD>";

print "</TR>";
print "</TABLE>";
?>