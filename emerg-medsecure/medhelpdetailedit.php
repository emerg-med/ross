<?php 



$sidetitlelist= array('Background','History','Examination','Tests','Treatment','Disposition','Description','Indications','Contraindications','Complications','Preparation','How to...','Equipment','Staff','Technique','Comments','Advice');

$medhelptypelist= array('Guideline','Paediatric Guideline','Protocol','Handout','Information','Drug','ECG/EKG','Practical','How to...','Research','Equipment','Nursing');

$reftypelist= array('Internet','Book','Journal','Department Policy','Hospital Policy','Government Policy');

$table_name = 'MedHelp';

if (!$lone_record){
	require("../common.inc");
	$key_ID = $arr_request[key_ID];
	}
include('checkvalid.inc');

 //pull stuff off database
	
    $str_sql = "
    select *
	from MedHelp
	where
	key_ID = '$key_ID'
	";

 $result = mysql_db_query($dbname, $str_sql, $id_link);

 if (! $result) {
 affy_error_exit('SQL Delete Execution has failed.');
 }

 $page = mysql_fetch_array($result); // put it into associative array




## Start Page Display

include("../header.inc");
include('adminnavbar.inc');


## Title Table
print "<FORM METHOD=POST  ENCTYPE=\"multipart/form-data\" ACTION='medhelpedit.php'>";

print "<INPUT TYPE='HIDDEN' NAME='key_ID' VALUE='$key_ID'>";
print "<INPUT TYPE='HIDDEN' NAME='init' VALUE='1'>";

print "<FONT SIZE=1>&nbsp;<BR></FONT>";
print "<TABLE CELLPADDING=5 CELLSPACING=5 BORDER=0 WIDTH=100%><TR>";

	print '<TD WIDTH=150 ><FONT FACE="arial,helvetica,geneva,sansserif" SIZE=5 >Title</FONT></TD><TD VALIGN=TOP ALIGN=LEFT WIDTH=80%>';
	
	print "<FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=6><INPUT TYPE=\"text\" NAME=\"Title\" SIZE=\"80\" VALUE=\"$page[Title]\"></FONT></TD>";

	

print '</FONT></TR>';

//Important Table


	print "<TR VALIGN=TOP><TD WIDTH=150  bgcolor=$bgcolor><FONT SIZE=5 COLOR=\"#FF0000\" FACE=\"arial,helvetica,geneva,sansserif\" >Important</FONT></TD><TD  ALIGN=LEFT WIDTH=80%><FONT SIZE=5 COLOR=\"#FF0000\" FACE=\"arial,helvetica,geneva,sansserif\" >";

	print"<TEXTAREA NAME=\"Important\" ROWS=2 COLS=70  WRAP=virtual>".$page[Important]."</TEXTAREA>";  
	
	print "</FONT></TR>";


// Main Table


for ($i = 1; $i<16; $i++){     // cycle from 1 to 15

		print "<TR><TD VALIGN=TOP bgcolor=$bgcolor WIDTH=20% ><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>";
		print $i."&nbsp;&nbsp;";
		$sidetitle = "Title".$i."Side";

		dropdownbox2 ($sidetitlelist, $sidetitle, $page["Title".$i."Side"] );

		print "&nbsp;</FONT></TD><TD WIDTH=80%>"; // print side title

			
			print "<FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>";
			$maintitle = 'Title'.$i.'Main';
			print "<INPUT TYPE=\"text\" NAME=\"$maintitle\" VALUE ='$page[$maintitle]' SIZE=\"80\" >";

			print '</FONT><BR>';  
		
		
		$para = "Para".$i;

		print"<TEXTAREA NAME='".$para."' ROWS=6 COLS=70 WRAP=virtual>".$page['Para'.$i]."</TEXTAREA>";




		print "</TD></TR>";  


	## links to other pages/ external pages/ documents

		print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Reference ".$i.'</FONT></TD>';

		$ref = "Ref".$i;
		$refURL = "Ref".$i."URL";

		print "<TD><INPUT TYPE=\"text\" NAME=\"$ref\" VALUE ='$page[$ref]' SIZE=\"80\" ><BR>";
		print '</TD></TR>';


		print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Reference ".$i.' URL</FONT></TD>';
		print "<TD><INPUT TYPE=\"text\" NAME=\"$refURL\" VALUE ='$page[$refURL]' SIZE=\"80\" >";

		## provide link to other pages within medhelp database
		print "<input type =\"submit\" name=\"action\" value=\"$i Link to another page\">";
		

		print "<BR><H6>external (www) links: make sure you include the http://www. <BR>links to documents/video: put yourfile in the $hostname/documents file, and link to documents/yourfile</H6>";

		print '</TD></TR>';
		
		## picture

		$pic = "Pic".$i;
		print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Picture ".$i.'</FONT></TD>';


		print '<TD colspan=2 >';

		if ($page[$pic]){ //ignore if no picture
			print "<A HREF=\"javascript:popupwindow('medhelpimages.php?key_ID=$key_ID&Pic=$i');\"><IMG SRC=\"";
			print "medhelpimages.php?key_ID=$key_ID&Pic=$i";
			print "\" BORDER=0 HEIGHT=300></A><BR><H6>click to view full size image. Pictures must be .gif .png or .jpg, with a maximum size = 500kb</H6><BR>";
			}

		print "<INPUT TYPE=\"file\" NAME=\"$pic\" SIZE=\"60\" >";
		print '</TD></TR>';
		


		if ($i=='7'){ // ECG

			print "\n<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE='arial,helvetica,geneva,sansserif' SIZE=4>ECG</FONT></TD>";

			if ($page[Pic16]){
				print '<TD colspan=2 BACKGROUND="../html/images/ecggrid.gif" ><IMG SRC="';
				print "\medhelpimages.php?key_ID=$key_ID&Pic=16";
				print "\" BORDER=0><BR><BR>";
				}
			else{print '<TD colspan=2 >';		
				}	
				print "<INPUT TYPE=\"file\" NAME=\"Pic16\" SIZE=\"60\" >";
				print "<BR><H6>ECGs should be .gif or .png with a transparent background.</H6>";
				print "</TD></TR>\n";
			}

}#end of loop


print "<TR VALIGN=TOP><TD bgcolor=$bgcolor colspan= 2>&nbsp;</TD></TR>";

#print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Creator</FONT></TD>";
#print "<TD>$page[Creator]</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Authorised by</FONT></TD>";
print "<TD><INPUT TYPE=\"TEXT\" NAME=\"AuthorisedBy\" SIZE=25 VALUE=\"";
if ($page[AuthorisedBy]){
	print $page[AuthorisedBy];
	}else{
	print $arr_request[user];
	}
print "\">";
print "<BR><FONT SIZE=\"1\" COLOR=\"FF0000\">To save as a draft, clear your name from this box</FONT></TD></TR>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$user'>";

#print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Department</FONT></TD>";
#print "<TD>$page[Department]</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Your computer ID</FONT></TD>";
print "<TD>$REMOTE_ADDR</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Your computer</FONT></TD>";
print "<TD>$HTTP_USER_AGENT</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Type of helpfile</FONT></TD><TD>";
dropdownbox ($medhelptypelist, MedHelpType, $page[MedHelpType]);
print "</TD></TR>";

print "<TR VALIGN=TOP><TD bgcolor=$bgcolor><FONT FACE=\"arial,helvetica,geneva,sansserif\" SIZE=4>Keywords</FONT></TD>";
print "<TD><INPUT TYPE=\"text\" NAME=\"Keywords\" VALUE ='$page[Keywords]' SIZE=\"80\" ></TD></TR>";

print '<TR><TD colspan=3><CENTER><input type ="submit" name="action" value="Update"></CENTER></TD></TR>';

print '</TABLE>';



include("../footer.inc");
?>