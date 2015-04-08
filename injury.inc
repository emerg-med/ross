<?

$injurynaturelist = array ("2{Open wound - not eye","5{Sprain or strain","3{Fracture - not tooth","13{Eye injury - not FB","14{Foreign body","20{Poison / toxic effect","1{Superficial - not eye","7{Injury - blood vessel","11{Injury - internal organ","8{Injury - muscle / tendon","6{Injury nerve","15{Intracranial injury","24{Multiple injuries","25{No injury detected","12{Burn or corrosion","9{Crushing injury","16{Dental injury","4{Dislocation","17{Drowning / immersion","19{Electrical injury","18{Asphyxia / breathing","21{Bites - venom","26{Bites - no venom","10{Traumatic amputation","23{Injury - unspecified","22{Injury - other specified");
$bodyregionlist = array ("1{Head (not face)","2{Face (not eye)","3{Neck","4{Thorax","5{Abdomen","6{Lower Back","7{Pelvis","8{Shoulder","9{Upper arm","10{Elbow","11{Forearm","12{Wrist","13{Hand (& fingers)","14{Hip","15{Thigh","16{Knee","17{Lower leg","18{Ankle","19{Foot","20{Unspecified","21{Multiple","22{Not applicable (eg eye not FB)","F1{FB in Eye","F2{FB in Ear","F3{FB in Nose","F4{FB in Respiratory tract","F5{FB in Digestive tract","F6{FB in Genitourinary tract","F7{FB in Soft tissue");
$injuryplacelist = array ("H{Home","R{Road / Street / Highway","I{Residential / elderly care","S{School / Daycare / Public area","A{Sports area","T{Trade / Service area - shops","M{Hospital","P{Park","F{Farm","C{Industrial / Construction","Q{Mine / Quarry","O{Other - Not above","U{Unknown");
$injurycauselist = array("9{Fall - low  <1 metre","10{Fall - high >1 metre","24{Struck/ collision object","23{Struck / collision person","17{Poisoning - medication","18{Poisoning - other / unknown","20{Cutting / piercing","19{Firearm related","5{Cyclist - rider / passenger","1{Motor vehicle - driver","2{Motor vehicle - passenger","3{Motorcycle - driver","4{Motorcycle - passenger","6{Pedestrian","8{Other transport related","21{Dog related","7{Horse related","22{Other animal related","14{Fire / flames / smoke","26{Electricity","28{Cold conditions","27{Hot conditions","16{Contact burn","15{Scalds","11{(Near) drowning - pool","12{(Near) drowning - other","13{Threat to breathing","29{Other known cause","30{Unknown cause");
$injuryactlist = array ("L{Leisure","W{Working for income","C{Working (not paid)","N{Being nursed / cared for","E{Education","V{Vital activity","S{Sports","O{Other specified activity","U{Unknown");
$injuryintentlist= array ("1{Accident","7{Assault - not specified","8{Complication of medical care","2{Intentional self - harm","4{Child neglect / NAI","5{Domestic violence","3{Sexual assault","6{Legal intervention","9{Intent cannot be determined","10{Other specified intent","11{Intent not specified");


$str_sql = "SELECT InjuryMain,InjuryBodyRegion FROM InjuryMatrix WHERE ICD10 = '$Diagnosis1' "; 
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
$injar = mysql_fetch_array($result);

$patient[InjuryBodyRegion]=$injar[InjuryBodyRegion];
$patient[InjuryNatureof]=$injar[InjuryMain];


print "\n<CENTER><TABLE border =0 cellspacing = 0 cellpadding = 3 width =98%>";
print '<TR><TD colspan = 4><H3>Injury<H3></TD></TR>';

print "<TR><TD>Type </TD><TD>";
codedropdownbox ($injurynaturelist, "InjuryNatureof", $patient[InjuryNatureof] );
print '</TD>';

print "<TD>Part </TD><TD>";
codedropdownbox ($bodyregionlist, "InjuryBodyRegion", $patient[InjuryBodyRegion] );
print '</TD></TR>';

print "<TR><TD>Place </TD><TD>";
codedropdownbox ($injuryplacelist, "InjuryPlace", $patient[InjuryPlace] );
print '</TD>';

print "<TD>Cause </TD><TD>";
codedropdownbox ($injurycauselist, "InjuryCause", $patient[InjuryCause] );
print '</TD></TR>';

print "<TR><TD>Activity </TD><TD>";
codedropdownbox ($injuryactlist, "InjuryActivity", $patient[InjuryActivity] );
print '</TD>';

print "<TD>Intent </TD><TD>";
codedropdownbox ($injuryintentlist, "InjuryIntent", $patient[InjuryIntent] );
print '</TD></TR>';

print "<TD>Description </TD><TD colspan=3>";
print "<input type=\"text\" name=\"TriageDiagnosis\" size= \"85\" value=\"".$patient[TriageDiagnosis]."\"><BR>";
print "<FONT SIZE=1>What actually happend? include any details such as safety devices in use, product brand names</FONT>";
print '</TD></TR>';

print '</TABLE></CENTER>';

?>