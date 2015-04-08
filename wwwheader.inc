<?php
ob_start();

if (!$allowcache){
header ("Cache-Control: no-cache, must-revalidate");
header ("Expires: -1");
header ("Pragma: no-cache");
$allowcache="";
}


print "<HTML><HEAD><TITLE>emerg-med.com</TITLE>";


if ($refresh){
	print "<META HTTP-EQUIV=\"Refresh\" Content=\"$refresh;URL=$PHP_SELF\">";
	}
	else{}



?>

<STYLE TYPE="text/css">
<!-- 
A:link {
		text-decoration: underline;
		color: #0000FF;
		}
A:visited {
		text-decoration: none;
		color: #000099;
		}
A:active {
		text-decoration: none;
		color: #FF0000;
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
// -->
</SCRIPT>

<meta name="MSSmartTagsPreventParsing" content="TRUE">
</HEAD>
<BODY BGCOLOR="#F6F6F6" BACKGROUND="images/bckgrnd.gif" bgproperties="fixed">
