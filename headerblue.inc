<?php
ob_start();

if (!$allowcache){
header ("Cache-Control: no-cache, must-revalidate");
header ("Expires: -1");
header ("Pragma: no-cache");
$allowcache="";
}


print "<HTML><HEAD><TITLE>$institution</TITLE>";


if ($refresh){
	print "<META HTTP-EQUIV=\"Refresh\" Content=\"$refresh;URL=$PHP_SELF\">";
	}
	else{}



?>

<STYLE TYPE="text/css">
<!-- 
A:link, A:visited, A:active {
		text-decoration: none;
		color: #000000;
		}
BODY,H1,H2,H3,H4,H5,H6{
	text-decoration: none;
	font-family: Verdana,helvetica,arial,geneva,sansserif,sans-serif;
	color: #000000;
	padding: 0px;
	font-style: normal;
	border: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	font-weight: normal;
	}

H6	{
	font-size:0.6 em;
	}

H5	{
	font-size:0.9 em;
	}

H4	{
	font-style: normal;
	font-size: 1.1 em;
	}

H3	{
	font-style: bold;
	font-size: 1.1 em;
	}


H2	{
	font-style: bold;
	font-size: 1.3 em;
	}

H1	{
	font-style: bold;
	font-size: 1.5 em;
	}

.redbutton {
	padding: 2px;
	background-color: #FF9999;
	border:3px outset #CC6666;
	}
.bluebutton {
	padding: 2px;
	background-color: #9999FF;
	border:3px outset #6666CC;
	}
.greenbutton {
	padding: 2px;
	background-color: #99FF99;
	border:3px outset #66CC66;
	}

.link {
	color: #0000ff;
	text-decoration: underline;
	}

.blue {
	vertical-align:baseline;
	background-color: #CCFFFF;
	color: #0000ff;
	}

.title{
	margin-top: 4px;
	margin-bottom: 4px;
	}


IMG {
	text-decoration: none;
	color: #000000;
	padding: 0%;
	border: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	}


 -->
</STYLE>

<SCRIPT LANGUAGE=JavaScript>
<!--
function popupwindow(URL) {
aWindow=window.open(URL,'_blank','toolbar=1,width=750,height=550,status=0,scrollbars=1,resizable=1,menubar=0');
}
function minipopupwindow(URL) {
aWindow=window.open(URL,'_blank','toolbar=0,,width=290,height=250,status=0,scrollbars=0,resizable=1,menubar=0');
}

if (document.images) {
            img1on = new Image();          
            img1on.src ="images/homea.gif";       // Active Images
            img2on = new Image(); 
            img2on.src ="images/triagea.gif";   
            img3on = new Image(); 
            img3on.src ="images/rega.gif";   
            img4on = new Image(); 
            img4on.src ="images/phonea.gif";   
            img5on = new Image(); 
            img5on.src ="images/timebar.gif";   
            img6on = new Image(); 
            img6on.src ="images/viewa.gif";
            img7on = new Image(); 
            img7on.src ="images/admina.gif";   
            img8on = new Image(); 
            img8on.src ="images/contacta.gif";   
            img9on = new Image(); 
            img9on.src ="images/helpa.gif";
			img10on = new Image(); 
            img10on.src ="images/footera.gif";
            img11on = new Image(); 
            img11on.src ="images/viewa2.gif";


            img1off = new Image();          
            img1off.src ="images/homei.gif";       // Inactive Images
            img2off = new Image(); 
            img2off.src ="images/triagei.gif";   
            img3off = new Image(); 
            img3off.src ="images/regi.gif";   
            img4off = new Image(); 
            img4off.src ="images/phonei.gif";  
            img5off = new Image(); 
            img5off.src ="images/timebar.gif";  
            img6off = new Image(); 
            img6off.src ="images/viewi.gif";
            img7off = new Image(); 
            img7off.src ="images/admini.gif";   
            img8off = new Image(); 
            img8off.src ="images/contacti.gif";   
            img9off = new Image(); 
            img9off.src ="images/helpi.gif";
			img10off = new Image(); 
            img10off.src ="images/footeri.gif";    
            img11off = new Image(); 
            img11off.src ="images/viewi2.gif";
         }
// Function to 'activate' images.
function imgOn(imgName) {
        if (document.images) {
            document[imgName].src = eval(imgName + "on.src");
        }
}
// Function to 'deactivate' images.
function imgOff(imgName) {
        if (document.images) {
            document[imgName].src = eval(imgName + "off.src");                        
        }
}
// -->
</SCRIPT>
<meta name="MSSmartTagsPreventParsing" content="TRUE">
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
</HEAD>
<BODY BGCOLOR="#F6F6F6" BACKGROUND="images/bluebckgrnd.gif" bgproperties="fixed">
