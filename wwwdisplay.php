<?php
require('common.inc');
#phpinfo();

$page=$arr_request[text];
if(!$page){$page='home';}

$str_sql = "SELECT * FROM www WHERE Code = '".$page."'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed- content.');}
$content=@mysql_fetch_array($result);




include ('wwwheader.inc');

print "";

print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";
print "<TR><TD ALIGN=LEFT VALIGN=bottom><IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"emerg-med.com\"><IMG SRC=\"images/logo1.gif\" BORDER=0 ALT=\"emerg-med.com\">&nbsp;</TD></TR>";#


print "<TR><TD>";
include ('wwwnavbar.inc');
print "&nbsp;</TD></TR>";



 

print "<TR><TD width=600>";

print "<H2>";
print nl2br($content[Title]);
print "</H2><BR>";
print nl2br($content[Text]);


print "<BR><BR>";


print "";
print "</TD></TR>";


print "<TR><TD>";
print "";
print "</TD></TR>";
print "<TR><TD>";
print "";
print "</TD></TR>";
print "<TR><TD>";
print "";
print "</TD></TR>";
print "<TR><TD>";
print "";
print "</TD></TR>";

print "<TR><TD>";
include ('wwwfooter.inc');
print "</TD></TR>";



?>