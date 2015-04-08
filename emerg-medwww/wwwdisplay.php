<?php
require('common.inc');
#phpinfo();

$page=cleanup($arr_request[text]);
if(!$page){include (index.php);
	exit;
	}

/*
$str_sql = "SELECT * FROM www WHERE Code = '".$page."'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed- content.');}
$content=@mysql_fetch_array($result);
*/



if (!is_file("./content/".$page.".inc")){
	error('no page of that name','try using the menu bar');
	}else{
	include("content/$page.inc");
	}

include ('wwwheader.inc');
include ('wwwnavbar.inc');

#print "$page";

print "<CENTER><TABLE width=98% cellpadding =5 cellspacing =0>";

#print "<TR><TD ALIGN=LEFT VALIGN=bottom><IMG SRC=\"images/logo2.gif\" BORDER=0 ALT=\"meditute,org\"><IMG SRC=\"images/logo1.gif\" BORDER=0 ALT=\"meditute.org\">&nbsp;</TD></TR>";

print "<TR><TD ALIGN=LEFT VALIGN=bottom><BR></TD></TR>";


print "<TR><TD width=600>";

print "<BLOCKQUOTE><H2>";
print $Title;
print "</H2><BR>";
print $Text;


print "</BLOCKQUOTE>";


print "</TD></TR>";


print "</TABLE>";
print "<BR>";

include ('wwwfooter.inc');

?>