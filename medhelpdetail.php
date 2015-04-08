<?php 

$table_name = 'MedHelp';

if (!$lone_record){
	require('common.inc');
	$key_ID = $arr_request[key_ID];
}

 //pull stuff off database
	
$str_sql = " select * from MedHelp where key_ID = '$key_ID'	";
$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {
	affy_error_exit('SQL Delete Execution has failed.');
	}

$page = mysql_fetch_array($result); // put it into associative array


## Start Page Display

include('header.inc');
include('navbar.inc');


## Title Table

print "<TABLE CELLPADDING=5 CELLSPACING=5 BORDER=0 WIDTH=100%><TR>";

if (!$page[AuthorisedBy]) {
	print '<TD VALIGN=TOP WIDTH=150 ><CENTER><FONT SIZE=1>&nbsp;<BR><FONT FACE="arial,helvetica,geneva,sansserif" SIZE=6 COLOR="#FF0000">DRAFT<BR><FONT SIZE = 1>Not yet authorised</CENTER></FONT></TD><TD VALIGN=TOP ALIGN=LEFT WIDTH=500>';
	}
else {print '<TD WIDTH=150 >&nbsp;</TD><TD VALIGN=TOP ALIGN=LEFT WIDTH=500>';
	}

	print "<FONT SIZE=1>&nbsp;<BR><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=6>$page[Title]</FONT></TD>";

if (!$page[AuthorisedBy]) {
	print '<TD VALIGN=TOP ALIGN=LEFT WIDTH=100><CENTER><FONT SIZE=1>&nbsp;<BR><FONT FACE="arial,helvetica,geneva,sansserif" SIZE=6 COLOR="#FF0000">DRAFT<BR><FONT SIZE = 1>Not yet authorised</CENTER></FONT></TD>';
	}
	
print '</TR></FONT>';

if ($page[Important]) {
	print "<TR VALIGN=TOP><TD WIDTH=150  bgcolor=$bgcolor><FONT SIZE=4 COLOR=\"#FF0000\" FACE=\"arial,helvetica,geneva,sansserif\" >Important</FONT></TD><TD  ALIGN=LEFT WIDTH=500><FONT SIZE=4 COLOR=\"#FF0000\" FACE=\"arial,helvetica,geneva,sansserif\" >".nl2br($page[Important])."</FONT><TD>&nbsp;</TD></TR>";
}

for ($i = 1; $i<16; $i++){     // cycle from 1 to 15
	if ($page["Para".$i]) {// ignore if paragraph blank "Para".$i

		print "<TR><TD VALIGN=TOP bgcolor=$bgcolor WIDTH=150 ><FONT SIZE=4 FACE=\"arial,helvetica,geneva,sansserif\">";
		print $page["Title".$i."Side"];
		print "&nbsp;</FONT></TD><TD WIDTH=500 VALIGN=top >"; // print side title

			if ($page["Title".$i."Main"]) {     // print main title
			print "<FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>";
			print $page["Title".$i."Main"];
			print '</FONT>';  
			}
	
		print "<FONT SIZE=2><P class=\"para\" >";
		print nl2br($page["Para".$i]);
		print "&nbsp;</FONT></P></TD><TD>&nbsp;</TD></TR>";   // print main paragraph
		}

	if ($page["Ref".$i]) { //ignore if reference blank
	print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>";
	

		$refurl=$page["Ref".$i."URL"];
		if ($refurl) {
			if (ereg ("#####",$refurl)){
				$refurl=$base."/medhelpdetail.php?key_ID=".ereg_replace("#####","",$refurl);
				}
			print 'Link</FONT></TD>';
			print "<TD><A HREF=\"javascript:popupwindow('";
			print ($refurl);
			print "');\"><H4 class=\"link\">";
			print $page["Ref".$i];
			print '</H4></A></TD></TR>';
			} else {
			print 'Reference</FONT></TD><TD><H4>';
			print $page["Ref".$i];
			print '</H4></TD></TR>';
		}
	}
	
	if ($page["Pic".$i]){ //ignore if no picture
		print "<TR VALIGN=TOP><TD bgcolor=$bgcolor>&nbsp;</TD>";
		print "<TD colspan=2><A HREF=\"javascript:popupwindow('medhelpimages.php?key_ID=$key_ID&Pic=$i');\">";
		print "<IMG SRC=\"";

		print "medhelpimages.php?key_ID=$key_ID&Pic=$i";
		print "\" BORDER=0 HEIGHT=300></A><BR><H6>click to view full size image</H6></TD></TR>";
	}
	if (($page["Pic16"]) && ($i==7)){ //ignore if no ECG
		print '<TR><TD colspan=3 BACKGROUND="images/ecggrid.gif"><IMG SRC="';
		print "medhelpimages.php?key_ID=$key_ID&Pic=16";
		print "\" BORDER=0></TD></TR>";

	}


}



print "<TR VALIGN=TOP><TD bgcolor=$bgcolor colspan= 3>&nbsp;</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Created</FONT></TD>";
print "<TD>".strftime ("%d %B, %Y","$page[CreatedTimestamp]")."</TD></TR>";

if ($page[AuthorisedBy]){
	print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Authorised by</FONT></TD>";
	print "<TD>$page[AuthorisedBy] &nbsp;&nbsp;&nbsp;&nbsp;".strftime ("%d %B, %Y","$page[UpdatedTimestamp]")."</TD></TR>";
	}

#print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Department</FONT></TD>";
#print "<TD>$page[Department]</TD></TR>";


print '</TABLE>';

include('footer.inc');
?>