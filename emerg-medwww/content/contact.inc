<?php
$Title="Contacting meditute.org";
$Text="
We do <B>not</B> offer support in Linux loading and configuration, unless you have bought a licence from meditute.<BR>If you require help configuring or running linux, buy a registered e.g. RedHat copy, and this will enable you to get support.<BR>
<BR>
This form sends an email to meditute.
If you want a reply, please make sure you fill in the email details.<BR>
<BR>
<FONT SIZE=\"+1\" COLOR=\"FF0000\">We do not provide medical advice.</FONT><BR>
<HR><BR>
<FORM METHOD=POST ACTION=\"contactprocess.php\">
I am contacting meditute regarding:<BR><BR>
<INPUT TYPE=\"radio\" NAME=\"enqtype\" VALUE=\"Licence\">Licensing 
<INPUT TYPE=\"radio\" NAME=\"enqtype\" VALUE=\"Content\">Meditute content 
<INPUT TYPE=\"radio\" NAME=\"enqtype\" VALUE=\"Program\">The meditute program 
<BR>
<BR>My question:<BR>
<TEXTAREA NAME=\"query\" ROWS=\"2\" COLS=\"60\"></TEXTAREA>
<BR>
<BR>
My email address (optional):<BR>
<INPUT TYPE=\"text\" NAME=\"email\" size=60><BR>
[we do not share any data with anyone]<BR>
<BR>
<INPUT TYPE=\"submit\" VALUE=\"Check\">


</FORM>


";

?>