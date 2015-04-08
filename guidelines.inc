<?php
print " 
<applet codebase='java' Code=apPopupMenu Archive=apPopupMenu.jar Width=110 Height=86 MAYSCRIPT>
<param name=\"Copyright\" value=\"Apycom Software - www.apycom.com\">
<param name=\"popupOver\" value=\"true\">
<param name=\"systemSubFont\" value=\"false\">
<param name=\"showArrows\" value=\"true\">
<param name=\"solidArrows\" value=\"true\">
<param name=\"3DBorder\" value=\"true\">
<param name=\"buttonType\" value=\"0\"> 
<param name=\"isHorizontal\" value=\"false\">
<param name=\"alignText\" value=\"left\"> 

<param name=\"backColor\" value=\"c0c0c0\">
<param name=\"backHighColor\" value=\"000080\">
<param name=\"fontColor\" value=\"000000\">
<param name=\"fontHighColor\" value=\"FFFFFF\">
<param name=\"font\" value=\"Verdana,12,0\">

<param name=\"menuItems\" value=\"
{Guidelines";

$tc=$patient[TriageNurseCode];

 function GuidelineBox($guidelinetype, $triagecode){

	$str_sql = "SELECT Title,MedHelpType,key_ID FROM MedHelp WHERE Title != '## BLANK ##' &&  Keywords LIKE '%".$triagecode."%' &&  MedHelpType LIKE '%".$guidelinetype."' ORDER BY Title";

	$result = mysql_db_query($GLOBALS[dbname], $str_sql, $GLOBALS[id_link]);
	if (! $result) {affy_error_exit('**SQL Select Execution has failed.');}

	if (!mysql_num_rows ($result))	{print ",_,_}";
		
		}else{
		print "}";
	  
			while ($guideline = @mysql_fetch_array($result)){
			print "{|$guideline[Title],../medhelpdetail.php?key_ID=$guideline[key_ID],_blank}";
			}
		}
	}


GuidelineBox(Guideline,$tc);

print "{Protocols";
GuidelineBox(Protocol,$tc);

print "{Handouts";
GuidelineBox(Handout,$tc);

print "{Information";
GuidelineBox(Information,$tc);


print "\"></APPLET></TD>";
?>