<?php
require('common.inc');
#phpinfo();

$enqtype=cleanup($arr_request[enqtype]);
$email=cleanup($arr_request[email]);
$query=bigcleanup($arr_request[query]);


if ($arr_request[checked]){ # if has already checked, send email
	if (mail("enquiries@meditute.org",$enqtype,$query)){
		error ("Your message was successfully sent","We try to answer all emails within 24 hours<BR><BR>Click <A HREF=\"index.php\">here</A> to continue");
		}else{
		error ("There is a problem with your message","Please try again shortly");
		}
	}


/*
$str_sql = "SELECT * FROM www WHERE Code = '".$page."'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed- content.');}
$content=@mysql_fetch_array($result);
*/

include ('wwwheader.inc');

if (!$query || !$enqtype){error ("Oops, better go back and fill in a bit more of the form","please use the back button to go back");}


if (!$email){$email="An anonymous coward";}

#print "$page";

print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";
print "<TR><TD ALIGN=LEFT VALIGN=bottom><IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"meditute,org\"><IMG SRC=\"images/logo1.gif\" BORDER=0 ALT=\"meditute.org\">&nbsp;</TD></TR>";#


print "<TR><TD>";
include ('wwwnavbar.inc');
print "</TD></TR>";

print "<TR><TD width=600>";

print "<BLOCKQUOTE><BR><H2>";
print "To: Meditute.org ";

print "</H2><BR><H2>";
print "re. ";
print $enqtype;
print "</H2><BR>";
print "From: &nbsp;";
print $email;
print "<BR><BR>Question: &nbsp;";
print $query;

print "<BR><BR>";


print "<FORM METHOD=POST ACTION=\"contactprocess.php\">";
print "<INPUT TYPE=\"hidden\" NAME=\"enqtype\" VALUE=\"$enqtype\">";
print "<INPUT TYPE=\"hidden\" NAME=\"email\" VALUE=\"$email\">";
print "<INPUT TYPE=\"hidden\" NAME=\"query\" VALUE=\"$query\">";
print "<INPUT TYPE=\"hidden\" NAME=\"checked\" VALUE=\"1\">";
print "<INPUT TYPE=\"submit\" VALUE=\"Send\">";
print "</FORM>";
print "</BLOCKQUOTE>";
print "</TD></TR>";


print "</TABLE>";
print "<BR>";
include ('wwwfooter.inc');

?>