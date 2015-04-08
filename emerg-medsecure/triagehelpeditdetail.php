<?php 
include("../emerg-med/common.inc");
include('checkvalid.inc');
# PHPINFO(); 

$key_ID = $arr_request['key_ID'];


$boxcolourlist = array("1","2","3","4","5","6","7");

# get the relevant triage decision support data

$str_sql = "SELECT * FROM TriageDiagnosis WHERE key_ID = '$key_ID'";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

$triagehelp =  mysql_fetch_array($result);

$triagediagnosisrow= explode("{",$triagehelp[TriageDiagnosis]);
$triagerow1 = explode("{",$triagehelp[TriageA]);
$triagerow2 = explode("{",$triagehelp[TriageB]);
$triagerow3 = explode("{",$triagehelp[TriageC]);
$triagerow4 = explode("{",$triagehelp[TriageD]);
$triagerow5 = explode("{",$triagehelp[TriageE]);
$triagerow6 = explode("{",$triagehelp[TriageF]);


include("../emerg-med/header.inc");
include('adminnavbar.inc');

print "<FORM method='post' action = 'triagehelpedit.php'>";

print "<INPUT TYPE=\"hidden\" name= \"updatetriagehelp\" value=\"yes\">";
print "<INPUT TYPE=\"hidden\" name= \"key_ID\" value=\"$key_ID\">";
print "<INPUT TYPE=\"hidden\" name= \"user\" value=\"$arr_request[user]\">";
print "<H5><CENTER><TABLE cellpadding=5 cellspacing=5 WIDTH =98% border=0>";
print "<TR><TD colspan=3><H1>Triage Guidelines - $triagediagnosisrow[1]</H1></TD></TR>";

print "<TR><TD>Triage Code&nbsp;&nbsp;<input type='text' name='TriageDetails[]' value='$triagediagnosisrow[0]' size = 7></TD></TR>";
print "<TR><TD>Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='TriageDetails[]' value='$triagediagnosisrow[1]' size = 30></TD></TR>";




########## row A

print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageA[]", $triagerow1[0]);

print "<BR>";
print "<textarea name=\"TriageA[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow1[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageA[]", $triagerow1[2]);

print "<BR>";
print "<textarea name=\"TriageA[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow1[3]</textarea><BR>";

print "</TD></TR>";

print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";

######### row B


print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageB[]", $triagerow2[0]);

print "<BR>";
print "<textarea name=\"TriageB[]\" cols= \"30\" rows=\"3\" wrap='virtual' >$triagerow2[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageB[]", $triagerow2[2]);

print "<BR>";
print "<textarea name=\"TriageB[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow2[3]</textarea><BR>";

print "</TD></TR>";

print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";


######### row C


print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageC[]", $triagerow3[0]);

print "<BR>";
print "<textarea name=\"TriageC[]\" cols= \"30\" rows=\"3\" wrap='virtual' >$triagerow3[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageC[]", $triagerow3[2]);

print "<BR>";
print "<textarea name=\"TriageC[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow3[3]</textarea><BR>";

print "</TD></TR>";

print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";

######### row D


print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageD[]", $triagerow4[0]);

print "<BR>";
print "<textarea name=\"TriageD[]\" cols= \"30\" rows=\"3\" wrap='virtual' >$triagerow4[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageD[]", $triagerow4[2]);

print "<BR>";
print "<textarea name=\"TriageD[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow4[3]</textarea><BR>";

print "</TD></TR>";

print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";


######### row E


print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageE[]", $triagerow5[0]);

print "<BR>";
print "<textarea name=\"TriageE[]\" cols= \"30\" rows=\"3\" wrap='virtual' >$triagerow5[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageE[]", $triagerow5[2]);

print "<BR>";
print "<textarea name=\"TriageE[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow5[3]</textarea><BR>";

print "</TD></TR>";

print "<TR><TD><CENTER><IMG SRC=\"images/downarrow.gif\"></CENTER></TD><TD></TD><TD></TD></TR>";

######### row F


print "<TR><TD width=50%>Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageF[]", $triagerow6[0]);

print "<BR>";
print "<textarea name=\"TriageF[]\" cols= \"30\" rows=\"3\" wrap='virtual' >$triagerow6[1]</textarea><BR>";

print "</TD><TD  width =25% ><CENTER><IMG SRC=\"images/yesarrow.gif\"></CENTER></TD>";
print "<TD width =25% >Box Colour&nbsp;&nbsp;&nbsp;";

dropdownbox2 ($boxcolourlist, "TriageF[]", $triagerow6[2]);

print "<BR>";
print "<textarea name=\"TriageF[]\" cols= \"30\" rows=\"3\" wrap='virtual'>$triagerow6[3]</textarea><BR>";

print "</TD></TR>";

########## Triage Notes

print "<TR><TD >Triage Notes</TD></TR>";

print "<TR><TD colspan = 3><textarea name=\"TriageNotes\" cols= \"60\" rows=\"8\" wrap='virtual' >$triagehelp[TriageNotes]</textarea></TD></TR>";


print "<TR><TD colspan =3><CENTER><input type = \"submit\" value= \"Update\" ></CENTER></TD></TR></FORM>";



print "</TABLE></CENTER></H5>";
print "</BODY></HTML>";
?>