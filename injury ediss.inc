<?

# need to add fields, convert activity, injury place codes to numbers
# need to add update codes into detail.php
# also need the data validation
# e.g. OD must have alcohol/ drug completed, also assault
# need to change the codes for the injury nature and body region and the validation matrix


$injurydatelist = array ("00/00/0000{today","00/00/0000{yesterday");
$injurytimelist = array ("0000{0000-0100","0100{0100-0200");


$injurynaturelist = array ("2{Open wound - not eye","5{Sprain or strain","3{Fracture - not tooth","13{Eye injury - not FB","14{Foreign body","20{Poison / toxic effect","1{Superficial - not eye","7{Injury - blood vessel","11{Injury - internal organ","8{Injury - muscle / tendon","6{Injury nerve","15{Intracranial injury","24{Multiple injuries","25{No injury detected","12{Burn or corrosion","9{Crushing injury","16{Dental injury","4{Dislocation","17{Drowning / immersion","19{Electrical injury","18{Asphyxia / breathing","21{Bites - venom","26{Bites - no venom","10{Traumatic amputation","23{Injury - unspecified","22{Injury - other specified");
$bodyregionlist = array ("1{Head (not face)","2{Face (not eye)","3{Neck","4{Thorax","5{Abdomen","6{Lower Back","7{Pelvis","8{Shoulder","9{Upper arm","10{Elbow","11{Forearm","12{Wrist","13{Hand (& fingers)","14{Hip","15{Thigh","16{Knee","17{Lower leg","18{Ankle","19{Foot","20{Unspecified","21{Multiple","22{Not applicable (eg eye not FB)","F1{FB in Eye","F2{FB in Ear","F3{FB in Nose","F4{FB in Respiratory tract","F5{FB in Digestive tract","F6{FB in Genitourinary tract","F7{FB in Soft tissue");
$injuryplacelist = array ("01{Own home", "02{Other home", "03{Residential institution", "04{Medical service area", "05{Education inc. sports", "06{Sports - public area", "07{Street/highway/ road/pavement", "08{Industrial/construction", "09{Farm", "10{Recreational area/Public building", "11{Commercial area (non-recreational)", "12{Countryside/Beach/Sea", "13{Licensed Premesis", "97{Other specified place", "98{N/A - non-injury", "99{Unspecified");
$injurycauselist = array("01{Fall/slip/trip  <1 metre","02{Fall/slip/trip >1 metre","03{Blunt injury", "04{Crush injury", "05{Stabbing", "06{Cut with sharp object", "07{Shot", "08{Foreign Body", "09{Drowning/near drowning", "10{Asphyxiation-external mechanical", "11{Physical over-exertion", "12{Poisoning/Overdose", "13{Burning/Scalding", "14{Fireworks",  "20{Heat/Cold related", "97{Other specified","98{N/A not injury", "99{Unspecified");
$injuryactlist = array ("01{Work","02{Education","03{Sport/exercise - Organised","04{Sport/exercise - informal/casual", "05{Leisure/ Play","06{Home/DIY/Gardening","07{Being taken care of", "08{RTC Pedestrian", "09{RTC Cyclist", "10{RTC Motorcycle Rider", "11{RTC Motorcycle Passenger", "12{RTC Driver", "13{RTC Passenger", "14{RTC Other", "15{RTC Unspecified", "97{Other", "98{N/A not injury", "99{Unspecified");
$injuryintentlist= array ("11{Accident","12{Assault","8{Complication of medical care","2{Intentional self - harm","4{Child neglect / NAI","5{Domestic violence","3{Sexual assault","6{Legal intervention","9{Intent cannot be determined","10{Other specified intent","11{Intent not specified");
$injuryassaultlist = array ("01{Spouse/ Partner","02{Family","03{Neighbour","04{Acquaintance","05{Stranger","06{Other relationship - specify below","99{Unspecified");
$injurysportlist= array ("21{Football (soccer)","7{Rugby League","8{Rugby Union","2{Cricket");







$str_sql = "SELECT InjuryMain,InjuryBodyRegion FROM InjuryMatrix WHERE ICD10 = '$Diagnosis1' "; 
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
$injar = mysql_fetch_array($result);

$patient[InjuryBodyRegion]=$injar[InjuryBodyRegion];
$patient[InjuryNatureof]=$injar[InjuryMain];


print "\n<CENTER><TABLE border =0 cellspacing = 0 cellpadding = 3 width =98%>";
print '<TR><TD colspan = 4><H3>Injury<H3></TD></TR>';

print "<TR><TD>Date of Injury </TD><TD>";
codedropdownbox ($injurydatelist, "InjuryDate", $patient[InjuryDate] );
print '</TD>';

print "<TD>Time of Injury </TD><TD>";
codedropdownbox ($injurytimelist, "InjuryTime", $patient[InjuryTime] );
print '</TD></TR>';


print "<TR><TD>Type </TD><TD>";
codedropdownbox ($injurynaturelist, "InjuryNatureof", $patient[InjuryNatureof] );
print '</TD>';

print "<TD>Part </TD><TD>";
codedropdownbox ($bodyregionlist, "InjuryBodyRegion", $patient[InjuryBodyRegion] );
print '</TD></TR>';

print "<TR><TD>Place </TD><TD>";
codedropdownbox ($injuryplacelist, "InjuryPlace", $patient[InjuryPlace] );
print '</TD>';

print "<TD>Mechanism </TD><TD>";
codedropdownbox ($injurycauselist, "InjuryCause", $patient[InjuryCause] );
print '</TD></TR>';

print "<TR><TD>Activity </TD><TD>";
codedropdownbox ($injuryactlist, "InjuryActivity", $patient[InjuryActivity] );
print '</TD>';

print "<TD>Intent </TD><TD>";
codedropdownbox ($injuryintentlist, "InjuryIntent", $patient[InjuryIntent] );
print '</TD></TR>';

print "<TR><TD>Assault </TD><TD>";
codedropdownbox ($injuryassaultlist, "InjuryAssault", $patient[InjuryAssault] );
print '</TD>';

print "<TD>Sport activity </TD><TD>";
codedropdownbox ($injurysportlist, "InjurySport", $patient[InjurySport] );
print '</TD></TR>';

print "<TR><TD>Drug and Alcohol</TD><TD><H6><I>";

$procs = array("01{alcohol","02{street drugs","12{paracetamol");
procedureboxes ($procs, $Procedures);

print "</I></H6></TD><TD><H6><I>";

$procs = array("04{aspirin","02{benzodiazepine ","03{opiate");
procedureboxes ($procs, $Procedures);

print "</I></H6></TD><TD><H6><I>";

$procs = array("05{non-TCA antidepressant","05{TCA","99{other - specify below");
procedureboxes ($procs, $Procedures);

print "</I></H6></TD></TR>";



print "<TD>Description </TD><TD colspan=3>";
print "<textarea name=\"TriageDiagnosis\" rows=\"3\" cols= \"85\" > ".trim($patient[TriageDiagnosis])."</textarea><BR>";
print "<FONT SIZE=1>What actually happend? include any details such as safety devices in use, product brand names</FONT>";
print '</TD></TR>';

print '</TABLE></CENTER>';

?>