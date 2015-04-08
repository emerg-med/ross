<?php

print "<TR><TD VALIGN=top>";

print "<applet codebase='java' Code=apPopupMenu Archive= apPopupMenu.jar Width=100% Height=20 MAYSCRIPT>
<param name=\"Copyright\" value=\"Apycom Software - www.apycom.com\">
<param name=\"isHorizontal\" value=\"true\">
<param name=\"overSound\" value=\"pix/bell.au\">
<param name=\"clickSound\" value=\"pix/kap2.au\">
<param name=\"systemSubFont\" value=\"false\">
<param name=\"solidArrows\" value=\"true\">
<param name=\"buttonType\" value=\"1\">
<param name=\"status\" value=\"link\">
<param name=\"alignText\" value=\"left\">
<param name=\"backColor\" value=\"000033\">
<param name=\"backHighColor\" value=\"FFCC00\">
<param name=\"fontColor\" value=\"000000\">
<param name=\"fontHighColor\" value=\"000000\">
<param name=\"font\" value=\"Arial,12,1\">";

print "<param name=\"menuItems\" value=\"
{Home,../wwwdisplay.php?text=home,_self}
{emerg-med.com}

{|Background,../wwwdisplay.php?text=background,_self}
{|Knowledge,../wwwdisplay.php?text=knowledge,_self}
{|Skills,../wwwdisplay.php?text=skills,_self}

{Products}
{|Emergency Department management system}
{||Features,../wwwdisplay.php?text=edfeatures,_self}
{||How it works,../wwwdisplay.php?text=edanalysis,_self}
{||How it can help you,../wwwdisplay.php?text=edbenefits,_self}
{||Try it now!,../wwwtryit.php?try=ED,_self}
{||Download it,../wwwdownload.php?dl=ED,_self}

{|Intensive Care management system}
{||Features,../wwwdisplay.php?text=icfeatures,_self}
{||How it works,../wwwdisplay.php?text=icanalysis,_self}
{||How it can help you,../wwwdisplay.php?text=icbenefits,_self}
{||Try it now!,_,_}
{||Download it,_,_}

{|Ward management system}
{||Features,../wwwdisplay.php?text=wardfeatures,_self}
{||How it works,../wwwdisplay.php?text=wardanalysis,_self}
{||How it can help you,../wwwdisplay.php?text=wardbenefits,_self}
{||Try it now!,_,_}
{||Download it,_,_}

{|Guidelines database}
{||Features,../wwwdisplay.php?text=glfeatures,_self}
{||How it works,../wwwdisplay.php?text=glanalysis,_self}
{||How it can help you,../wwwdisplay.php?text=glbenefits,_self}
{||Try it now!,../wwwtryit.php?try=GL,_self}
{||Download it,../wwwdownload.php?dl=GL,_self}

{FAQ}
{|How much does it cost?}
{||Open source software,../wwwdisplay.php?text=oss,_self}
{||How free is free?,../wwwdisplay.php?text=free,_self}
{||Who has to pay?,../wwwdisplay.php?text=pay,_self}
{||Licence,../wwwdisplay.php?text=licence,_self}

{|System Requirements,../wwwdisplay.php?text=req,_self}
{|System Setup,../wwwdisplay.php?text=setup,_self}
{|Map Setup,../wwwdisplay.php?text=map,_self}


{Contact}
{|Sales,../wwwdisplay.php?text=contactsales,_self}
{|Technical,../wwwdisplay.php?text=contacttech,_self}


\"></applet>\n";

print "&nbsp;</TD></TR>";

/*
../wwwdisplay.php?text=background
../wwwdisplay.php?text=knowledge
../wwwdisplay.php?text=skills
../wwwdisplay.php?text=edfeatures
../wwwdisplay.php?text=edanalysis
../wwwdisplay.php?text=edbenefits
../wwwtryit.php?try=ED
../wwwdownload.php?dl=ED
../wwwdisplay.php?text=icfeatures
../wwwdisplay.php?text=icanalysis
../wwwdisplay.php?text=icbenefits
../wwwdisplay.php?text=wardfeatures
../wwwdisplay.php?text=wardanalysis
../wwwdisplay.php?text=wardbenefits
../wwwdisplay.php?text=glfeatures
../wwwdisplay.php?text=glanalysis
../wwwdisplay.php?text=glbenefits
../wwwtryit.php?try=GL
../wwwdownload.php?dl=GL
../wwwdisplay.php?text=oss
../wwwdisplay.php?text=free
../wwwdisplay.php?text=pay
../wwwdisplay.php?text=licence
../wwwdisplay.php?text=req
../wwwdisplay.php?text=setup
../wwwdisplay.php?text=map
../wwwdisplay.php?text=contactsales
../wwwdisplay.php?text=contacttech
*/

?>